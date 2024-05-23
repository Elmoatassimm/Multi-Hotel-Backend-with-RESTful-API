<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'room', 'offer'])->get();
        return response()->json($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $room = Room::findOrFail($request->room_id);

        if (!$room->availability) {
            return response()->json(['error' => 'Room not available'], 400);
        }

        $bookingData = $request->validated();
        $bookingData['user_id'] = $user->id;
        $booking = Booking::create($bookingData);

        if ($request->status == 'confirmed') {
            $room->availability = false;
            $room->save();
        }

        return response()->json(['message' => 'Booking created successfully', 'booking' => $booking], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'room', 'offer'])->findOrFail($id);
        return response()->json($booking);
    }

    /**
     * Cancel the specified booking.
     */
    public function cancel($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $booking = Booking::findOrFail($id);

        if ($booking->user_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $booking->status = 'cancelled';
        $booking->save();

        $room = $booking->room;
        $room->availability = true;
        $room->save();

        return response()->json(['message' => 'Booking cancelled successfully'], 200);
    }


    public function confirm($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $booking = Booking::findOrFail($id);

        if ($booking->user_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($booking->status == 'confirmed') {
            return response()->json(['message' => 'Booking is already confirmed'], 400);
        }

        $booking->status = 'confirmed';
        $booking->save();

        $room = $booking->room;
        $room->availability = false;
        $room->save();

        return response()->json(['message' => 'Booking confirmed successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $booking = Booking::findOrFail($id);

        if ($booking->user_id != $user->id) {
            return response()->json(['error' => 'UnauthorizedDDDDDDDDDD'], 401);
        }

        $booking->delete();

        if ($booking->status == 'confirmed') {
            $room = $booking->room;
            $room->availability = true;
            $room->save();
        }

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
