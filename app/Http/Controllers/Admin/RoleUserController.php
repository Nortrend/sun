<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleUser\StoreRequest;
use App\Http\Resources\RoleUser\RoleUserResource;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Role;
use App\Services\RoleUserService;
use Illuminate\Http\RedirectResponse;

class RoleUserController extends Controller
{
    protected RoleUserService $roleUserService;

    public function __construct(RoleUserService $roleUserService)
    {
        $this->roleUserService = $roleUserService;
    }

    public function index()
    {
        $rolesUsers = RoleUserResource::collection(
            RoleUser::with(['user', 'role'])->get()
        )->resolve();

        return inertia('Admin/RoleUser/Index', compact('rolesUsers'));
    }

    public function create()
    {
        $roles = Role::select('id', 'title')->get();

        return inertia('Admin/RoleUser/Create', [
            'roles' => $roles,
        ]);
    }


    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->roleUserService->store($validated);

        return redirect()->route('admin.role_users.create')
            ->with('success', 'Роль успешно назначена пользователю!');
    }
}
