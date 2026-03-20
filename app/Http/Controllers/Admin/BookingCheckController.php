<?php

namespace App\Http\Controllers\Admin;

use App\Attributes\Authorize;
use App\Enums\BookingPayment;
use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingCheckController extends Controller
{
    #[Authorize("checkIn", 'booking')]
    public function checkIn(Booking $booking)
    {
        if($booking->check_in->gt(now()->startOfDay())) {
            return redirect()->back()->with([
                'message' => __('admin.messages.checkin_on_date'),
                'type' => 'error'
            ]);
        }

        if($booking->status !== BookingStatus::RESERVED) {
            return redirect()->back()->with([
                'message' => __('admin.messages.checkin_only_reserved'),
                'type' => 'error'
            ]);
        }

        DB::Transaction(function () use ($booking) {
            $booking->update([
                'status' => BookingStatus::CHECK_IN,
            ]);

            $booking->statuses()->create([
                'status' => BookingStatus::CHECK_IN,
            ]);

            $booking->rooms()->update([
                'status' => RoomStatus::Occupied,
            ]);
        });


        return redirect()->back()->with(['message' => __('admin.messages.checkin_success')]);
    }

    #[Authorize("checkOut", 'booking')]
    public function checkOut(Booking $booking)
    {
        if($booking->check_out->gt(now()->startOfDay())) {
            return redirect()->back()->with([
                'message' => __('admin.messages.checkout_on_date'),
                'type' => 'error'
            ]);
        }

        if($booking->status !== BookingStatus::CHECK_IN) {
            return redirect()->back()->with([
                'message' => __('admin.messages.checkout_only_checked_in'),
                'type' => 'error'
            ]);
        }

        if($booking->payment_status !== BookingPayment::PAID) {
            return redirect()->back()->with([
                'message' => __('admin.messages.checkout_full_payment'),
                'type' => 'error'
            ]);
        }

        DB::Transaction(function () use ($booking) {
            $booking->update([
                'status' => BookingStatus::CHECK_OUT,
            ]);

            $booking->statuses()->create([
                'status' => BookingStatus::CHECK_OUT,
            ]);

            $booking->rooms()->update([
                'status' => RoomStatus::Available,
            ]);
        });

        return redirect()->back()->with(['message' => __('admin.messages.checkout_success')]);
    }
}
