<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with(['features', 'bookings'])->get();
        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        // Validate the incoming request
        $validatedData = $request->validated();

        // Handle uploaded photos
        if ($request->hasFile('photos')) {
            $photosPaths = [];

            foreach ($request->file('photos') as $file) {
                // Store each photo in the 'Rooms_images' directory
                $path = $file->store('Rooms_images');

                // Store the relative path in an array
                $photosPaths[] = $path;
            }

            // Convert the array of photo paths to a string and store in the 'photos_path' field
            $validatedData['photos_path'] = implode(',', $photosPaths);
        }

        // Create a new room with the validated data
        $room = Room::create($validatedData);

        // Return a success response
        return response()->json(['message' => 'Room created successfully', 'room' => $room], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $room->load(['features', 'bookings']);
        return response()->json($room);
    }

    /**
     * Display the rooms of the hotels managed by the authenticated user.
     */
    public function showMyHotelRooms()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retrieve rooms of the hotels managed by the user
        $rooms = Room::whereHas('hotel', function ($query) use ($user) {
            $query->whereHas('admins', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        })->with(['features', 'bookings'])->get();

        // Return the rooms as a response
        return response()->json($rooms);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        // Validate the incoming request
        $validatedData = $request->validated();

        // Handle uploaded photos
        if ($request->hasFile('photos')) {
            $photosPaths = [];

            foreach ($request->file('photos') as $file) {
                // Store each additional photo in the 'Rooms_images' directory
                $path = $file->store('Rooms_images');

                // Store the relative path in an array
                $photosPaths[] = $path;
            }

            // Append new photo paths to the existing ones in the 'photos_path' field
            $existingPhotosPaths = explode(',', $room->photos_path);
            $allPhotosPaths = array_merge($existingPhotosPaths, $photosPaths);

            // Update the 'photos_path' field with the concatenated paths
            $room->update(['photos_path' => implode(',', $allPhotosPaths)]);
        }

        // Update the room with the validated data
        $room->update($validatedData);

        // Return a success response
        return response()->json(['message' => 'Room updated successfully', 'room' => $room]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(null, 204);
    }
}
