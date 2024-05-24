<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::with("rooms","events","specialOffers","reviews")->get();
        return response()->json($hotels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        // Validate the incoming request
        $validatedData = $request->validated();

        // Handle uploaded photos
        if ($request->hasFile('photos')) {
            $photosPaths = [];

            foreach ($request->file('photos') as $file) {
                // Store each photo in the 'Hotel_images' directory
                $path = $file->store('Hotel_images');

                // Store the relative path in an array
                $photosPaths[] = $path;
            }

            // Convert the array of photo paths to a string and store in the 'photos_path' field
            $validatedData['photos_path'] = implode(',', $photosPaths);
        }

        // Create a new hotel with the validated data
        $hotel = Hotel::create($validatedData);

        // Optionally, you can return a success response or redirect
        return response()->json(['message' => 'Hotel created successfully', 'hotel' => $hotel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        // Validate the incoming request
        $validatedData = $request->validated();

        // Handle uploaded photos
        if ($request->hasFile('photos')) {
            $photosPaths = [];

            foreach ($request->file('photos') as $file) {
                // Store each additional photo in the 'Hotel_images' directory
                $path = $file->store('Hotel_images');

                // Store the relative path in an array
                $photosPaths[] = $path;
            }

            // Append new photo paths to the existing ones in the 'photos_path' field
            $existingPhotosPaths = explode(',', $hotel->photos_path);
            $allPhotosPaths = array_merge($existingPhotosPaths, $photosPaths);

            // Update the 'photos_path' field with the concatenated paths
            $hotel->update(['photos_path' => implode(',', $allPhotosPaths)]);
        }

        // Update the hotel with the validated data
        $hotel->update($validatedData);

        // Optionally, you can return a success response or redirect
        return response()->json(['message' => 'Hotel updated successfully', 'hotel' => $hotel]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        // Return the specified hotel as JSON response
        return response()->json($hotel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        // Delete the photos from the storage
        $photosPaths = explode(',', $hotel->photos_path);
        foreach ($photosPaths as $path) {
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        // Delete the hotel record from the database
        $hotel->delete();

        // Optionally, you can return a success response or redirect
        return response()->json(['message' => 'Hotel deleted successfully']);
    }
}



/*
if ($request->hasFile('photo')) {
    // Deleting old photo if it exists
    if (!empty($aa->photo) && Storage::exists($aa->photo)) {
        Storage::delete($aa->photo);
    }
    // Storing the new photo and updating the data array
    $data['photo'] = request()->file('photo')->store('images');
} else {
    // If no new photo is uploaded, remove 'photo' from the data array
    unset($data['photo']);
}

*/


/*

$data['photo'] = request()->file('photo')->store('images');
*/