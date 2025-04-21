<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\StoreRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    public function index()
    {
        $profiles = ProfileResource::collection(Profile::all())->resolve();
        return inertia('Client/Profile/Index', compact(['profiles']));
    }

    public function show(Profile $profile)
    {
        $profile->load('user');
        $profile = ProfileResource::make($profile)->resolve();
        return inertia('Client/Profile/Show', compact('profile'));
    }

    public function create()
    {
        return inertia('Client/Profile/Create');
    }

    public function store(StoreRequest $request)
    {
        $profile = $this->profileService->store($request->validated());
        return inertia('Client/Profile/Store', compact(['profile']));
    }

}
