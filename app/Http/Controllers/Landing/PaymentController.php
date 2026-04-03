<?php

namespace App\Http\Controllers\Landing;

use App\Enums\BookingPayment;
use App\Enums\BookingStatus;
use App\Enums\ChargeType;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\RoomTypeResource;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        if (!$booking->isPayable() || $booking->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        $booking->load('charges')->loadCount('rooms');

        $roomType = $booking->rooms()->first()->type;
        $roomType->load('media', 'bedTypes');

        return inertia('Landing/Checkout', [
            'booking' => BookingResource::make($booking),
            'roomType' => RoomTypeResource::make($roomType),
            'stripeKey' => config('services.stripe.key'),
            'charges' => ChargeType::asSelect(),
            'isStripeConfigured' => !empty(config('services.stripe.key')) && !empty(config('services.stripe.secret')),
            'isFedaPayConfigured' => !empty(config('services.fedapay.key')),
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function store(Booking $booking)
    {
        if (!$booking->isPayable() || $booking->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $booking->total_price * 100,
            'currency' => strtolower(config('hotel.currency')),
            'metadata' => [
                'user_id' => auth('customer')->id(),
                'booking_id' => $booking->id,
            ],
            'description' => 'Hotel Booking Payment',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        $booking->payments()->update(['reference' => $intent->id]);

        return response()->json(['client_secret' => $intent->client_secret]);
    }

    public function payWithFedaPay(Booking $booking)
    {
        if (!$booking->isPayable() || $booking->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        FedaPay::setApiKey(config('services.fedapay.key'));
        FedaPay::setEnvironment(config('services.fedapay.environment'));

        set_time_limit(120); // Increase timeout for API call

        $booking->load('customer');

        try {
            \Log::info('FedaPay payload', [
                'booking_id' => $booking->id,
                'amount' => $booking->total_amount ?? null,
                'customer_email' => $booking->customer?->email ?? null,
                'customer_name' => $booking->customer?->name ?? null,
            ]);
            $transaction = Transaction::create([
                'description' => "Booking #{$booking->ref_number} payment",
                'amount' => (int) $booking->total_price,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('payments.fedapay.confirm', ['booking' => $booking->id]),
                'customer' => [
                    'firstname' => $booking->customer->first_name,
                    'lastname' => $booking->customer->last_name,
                    'email' => $booking->customer->email,
                    'phone_number' => [
                        'number' => $booking->customer->mobile,
                        'country' => 'TG' // Default to BJ as per common usage in the region
                    ]
                ]
            ]);

            $token = $transaction->generateToken();

            return response()->json(['url' => $token->url]);
        } catch (\Exception $e) {
            Log::error('FedaPay Payment Error: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'exception' => $e
            ]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function confirmFedaPay(Request $request, Booking $booking)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        if ($status === 'approved') {
            FedaPay::setApiKey(config('services.fedapay.key'));
            FedaPay::setEnvironment(config('services.fedapay.environment'));

            set_time_limit(120); // Increase timeout for API call

            try {
                $transaction = Transaction::retrieve($id);
                if ($transaction->status === 'approved') {
                     DB::Transaction(function () use ($booking) {
                        $booking->update([
                            'status' => BookingStatus::RESERVED,
                            'payment_status' => BookingPayment::PAID,
                        ]);

                        $payment = $booking->payments()->first();

                        $payment->update([
                            'status' => PaymentStatus::PAID,
                            'paid_at' => now(),
                        ]);

                        $booking->statuses()->create([
                            'status' => BookingStatus::RESERVED,
                        ]);
                    });

                    Mail::to($booking->customer->email)->queue(new BookingConfirmed($booking));

                    return redirect()->route('bookings.success', $booking);
                }
            } catch (\Exception $e) {
                Log::error('FedaPay Confirmation Error: ' . $e->getMessage(), [
                    'booking_id' => $booking->id,
                    'transaction_id' => $id,
                    'exception' => $e
                ]);
            }
        }

        return redirect()->route('bookings.failed', $booking);
    }

    public function confirmPayment(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent');

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }

        $bookingId = $intent['metadata']['booking_id'] ?? null;
        $booking = $bookingId ? Booking::find($bookingId) : null;

        if (!$booking) {
            return redirect()->route('home');
        }

        if ($intent->status === 'succeeded') {
            DB::Transaction(function () use ($intent, $booking) {
                $booking->update([
                    'status' => BookingStatus::RESERVED,
                    'payment_status' => BookingPayment::PAID,
                ]);

                $payment = $booking->payments()->first();

                $payment->update([
                    'status' => PaymentStatus::PAID,
                    'paid_at' => now(),
                ]);

                $booking->statuses()->create([
                    'status' => BookingStatus::RESERVED,
                ]);
            });

            Mail::to($booking->customer->email)->queue(new BookingConfirmed($booking));

            return redirect()->intended(route('bookings.success', $booking));
        }

        return redirect()->intended(route('bookings.failed', $booking));
    }

    public function success(Booking $booking)
    {
        if ($booking->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        if ($booking->isPayable()) {
            return redirect()->route('bookings.payments.create', $booking);
        }

        $roomType = RoomType::whereHas('rooms.bookings', fn($query) => $query->whereKey($booking->id))->first();
        $roomType->load('media', 'bedTypes');

        $booking->load(['charges', 'mealPlan', 'customer', 'rooms', 'payments'])->loadCount('rooms');
        return inertia('Landing/Success', [
            'booking' => BookingResource::make($booking),
            'roomType' => RoomTypeResource::make($roomType),
            'charges' => ChargeType::asSelect(),
            'statuses' => BookingStatus::asSelect(),
            'bookingPayments' => BookingPayment::asSelect(),
            'smokings' => SmokingPreference::asSelect(),
            'types' => PaymentType::asSelect(),
            'methods' => PaymentMethod::asSelect(),
            'paymentStatuses' => PaymentStatus::asSelect(),
        ]);
    }

    public function failed(Booking $booking)
    {
        if (!$booking->isPayable() || $booking->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        return inertia('Landing/Failed', [
            'booking' => BookingResource::make($booking),
        ]);
    }
}
