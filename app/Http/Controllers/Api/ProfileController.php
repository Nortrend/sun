<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\StoreRequest;
use App\Http\Requests\Api\Profile\UpdateRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProfileResource::collection(Profile::all())->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $profile = Profile::create($data);

        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Profile $profile, UpdateRequest $request)
    {
        $data = $request->validated();
        $profile->update($data);
        return ProfileResource::make($profile)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response([
            'message' => 'Profile deleted successfully'
        ],
            Response::HTTP_OK);
    }
}
