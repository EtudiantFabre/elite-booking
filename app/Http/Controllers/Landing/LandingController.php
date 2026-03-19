<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;

class LandingController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('media')
            ->active()
            ->limit(8)
            ->latest()
            ->get();

        return inertia('Landing/Home', [
            'roomTypes' => RoomTypeResource::collection($roomTypes),
        ]);
    }

    public function about()
    {
        return inertia('Landing/About');
    }

    public function amenities()
    {
        return inertia('Landing/Amenities');
    }
}
