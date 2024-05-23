<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomFeature;
use Illuminate\Http\Request;

class RoomFeatureController extends Controller
{
    public function store(Request $request, Room $room)
    {
        // Validate the request data
        $request->validate([
            'feature_id' => 'required|exists:features,id',
        ]);

        // Create a new RoomFeature
        $roomFeature = new RoomFeature();
        $roomFeature->room_id = $room->id;
        $roomFeature->feature_id = $request->feature_id;
        $roomFeature->save();

        return response()->json(['message' => 'Feature added to room successfully'], 201);
    }

    public function destroy(Room $room, $featureId)
    {
        // Detach the feature from the room
        $room->features()->detach($featureId);
        
        return response()->json(['message' => 'Feature removed from room successfully'], 200);
    }
}
