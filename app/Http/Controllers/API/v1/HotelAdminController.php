<?php
namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HotelAdmin;
use App\Models\Hotel;
use App\Models\User;

class HotelAdminController extends Controller
{
    /**
     * Display a listing of the hotel admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotelAdmins = HotelAdmin::with(['hotel', 'user'])->get();
        return response()->json($hotelAdmins);
    }

   

    /**
     * Display the specified hotel admin.
     *
     * @param  int  $hotel_id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($hotel_id, $user_id)
    {
        $hotelAdmin = HotelAdmin::where('hotel_id', $hotel_id)
            ->where('user_id', $user_id)
            ->with(['hotel', 'user'])
            ->firstOrFail();

        return response()->json($hotelAdmin);
    }

    /**
     * Remove the specified hotel admin from storage.
     *
     * @param  int  $hotel_id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hotel_id, $user_id)
    {
        $hotelAdmin = HotelAdmin::where('hotel_id', $hotel_id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        $hotelAdmin->delete();
        return response()->json(null, 204);
    }

    /**
     * Display hotels associated with the authenticated admin user.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMyHotels()
{
    // Retrieve the authenticated user
    $user = Auth::user();

    // Ensure the user is authenticated
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Retrieve hotels associated with the authenticated user along with related rooms, events, special offers, and reviews
    $hotels = $user->hotels()->with(['rooms', 'events', 'specialOffers', 'reviews'])->get();

    // Return the hotels as a response
    return response()->json($hotels);
}


    /**
     * Remove all hotels associated with the authenticated admin user from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyMyHotels()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retrieve all hotel admin entries associated with the authenticated admin user
        $hotelAdmins = HotelAdmin::where('user_id', $user->id)->get();

        // Delete all hotels associated with the authenticated admin user
        foreach ($hotelAdmins as $hotelAdmin) {
            $hotelAdmin->hotel->delete();
        }

        // Return a success response
        return response()->json(['message' => 'All hotels associated with the authenticated admin user have been deleted']);
    }
}
