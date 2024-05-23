<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with("features","bookings")->get();
       //$rooms = Room::all();

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

    // Create a new hotel with the validated data
    $room = Room::create($validatedData);

    // Optionally, you can return a success response or redirect
    return response()->json(['message' => 'Room created successfully', 'Room' => $room]);
    }

    /**
     * Display the specified resource.
     */

     
    public function show( Room $room )
    {
        
        return response()->json($room);
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

    // Update the Room with the validated data
    $room->update($validatedData);

    // Optionally, you can return a success response or redirect
    return response()->json(['message' => 'Room updated successfully', 'Room' => $room]);
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
