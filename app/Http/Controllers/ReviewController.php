<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('user', 'hotel')->latest()->paginate(10);
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $validatedData = $request->validate([
        'hotel_id' => 'required|exists:hotels,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $review = new Review();
    $review->user_id = $user->id;
    $review->hotel_id = $validatedData['hotel_id'];
    $review->rating = $validatedData['rating'];
    $review->comment = $validatedData['comment'];
    $review->save();

    $review->load('user', 'hotel');    
    return response()->json($review, 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load('user', 'hotel');
        return response()->json($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->all());

        return response()->json($review, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 204);
    }
}
