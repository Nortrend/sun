<?php

namespace App\Http\Controllers\Admin;

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
        return inertia('Admin/Profile/Index', compact(['profiles']));
    }

    public function show(Profile $profile)
    {
        $profile->load('user');
        $profile = ProfileResource::make($profile)->resolve();
        return inertia('Admin/Profile/Show', compact('profile'));
    }

    public function create()
    {
        return inertia('Admin/Profile/Create');
    }

    public function store(StoreRequest $request)
    {
        $profile = $this->profileService->store($request->validated());
        return inertia('Admin/Profile/Store', compact(['profile']));
    }

}
