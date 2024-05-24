<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Feature;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::all();
        return response()->json($features, 200);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeatureRequest $request)
    {
        $feature = Feature::create($request->validated());
        return response()->json($feature, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feature $feature)
    {
        return response()->json($feature, 200);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $feature->update($request->validated());
        return response()->json($feature, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();
        return response()->json(["message"=> "feature deleted successfully"]);
    }
}
