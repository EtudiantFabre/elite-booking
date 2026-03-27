<?php

namespace App\Http\Middleware;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth.user' => function () {
                if (Auth::guard('web')->check()) {
                    $user = Auth::guard('web')->user()->load('media', 'roles');
                    return array_merge(UserResource::make($user)->resolve(), [
                        'unreadNotifications' => $user->unreadNotifications()->limit(5)->get()
                    ]);
                }
                return null;
            },
            'auth.customer' => function () {
                return Auth::guard('customer')->check()
                    ? CustomerResource::make(Auth::guard('customer')->user()->load('media'))
                    : null;
            },
            'csrf_token' => csrf_token(),
            'flash' => [
                'message' => fn() => $request->session()->get('message') ?? $request->session()->get('success') ?? $request->session()->get('error'),
                'type' => fn() => $request->session()->get('type') ?? ($request->session()->has('success') ? 'success' : ($request->session()->has('error') ? 'error' : 'success'))
            ],
            'old' => fn() => $request->session()->get('old'),
            'locale' => app()->getLocale(),
            'translations' => [
                'front' => __('front'),
                'admin' => __('admin'),
            ],
            'hotel' => [
                'currency' => config('hotel.currency'),
                'currency_symbol' => config('hotel.currency_symbol'),
            ],
        ];
    }
}
