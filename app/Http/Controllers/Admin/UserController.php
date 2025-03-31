<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $users = UserResource::collection(User::all())->resolve();
        return inertia('Admin/User/Index', compact(['users']));
    }

    public function show(User $user)
    {
        $user->load('profile');
        $user = UserResource::make($user)->resolve();
        return inertia('Admin/User/Show', compact('user'));
    }


    public function create()
    {
        return inertia('Admin/User/Create');
    }

    public function store(StoreRequest $request)
    {
        $user = $this->userService->store($request->validated());
        return inertia('Admin/User/Store', compact(['user']));
    }

    public function list(Request $request)
    {
        $query = User::query()->select('id', 'email');

        if ($search = $request->get('search')) {
            $query->where('email', 'like', "%{$search}%");
        }

        return $query->limit(10)->get();
    }


}
