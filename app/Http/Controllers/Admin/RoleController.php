<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleResource;
use App\Models\Category;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Role\StoreRequest;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = RoleResource::collection(Role::all())->resolve();
        return inertia('Admin/Role/Index', compact('roles'));
    }

    public function show(Role $role)
    {
        $role = RoleResource::make($role)->resolve();
        return inertia('Admin/Role/Show', compact('role'));
    }

    public function create()
    {
        return inertia('Admin/Role/Create');
    }

    public function store(StoreRequest $request)
    {
        $role = $this->roleService->store($request->validated());
        return redirect()->route('admin.roles.create')
            ->with('success', 'Роль успешно создана!');
    }
}
