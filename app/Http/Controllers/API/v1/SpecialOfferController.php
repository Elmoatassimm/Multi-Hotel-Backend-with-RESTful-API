<?php

namespace App\Http\Controllers\API\v1;

use App\Models\SpecialOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecialOfferRequest;
use App\Http\Requests\UpdateSpecialOfferRequest;

class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialOffers = SpecialOffer::all();
        return response()->json(['data' => $specialOffers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecialOfferRequest $request)
    {
        $specialOffer = SpecialOffer::create($request->validated());
        return response()->json(['data' => $specialOffer], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialOffer $specialOffer)
    {
        return response()->json(['data' => $specialOffer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialOfferRequest $request, SpecialOffer $specialOffer)
    {
        $specialOffer->update($request->validated());
        return response()->json(['data' => $specialOffer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialOffer $specialOffer)
    {
        $specialOffer->delete();
        return response()->json(['message' => 'Special offer deleted successfully']);
    }
}
