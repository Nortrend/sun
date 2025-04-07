<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\Role\RoleResource;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Permission\StoreRequest;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = PermissionResource::collection(Permission::all())->resolve();
        return inertia('Admin/Permission/Index', compact('permissions'));
    }

    public function show(Permission $permission)
    {
        $permission = PermissionResource::make($permission)->resolve();
        return inertia('Admin/Permission/Show', compact('permission'));
    }

    public function create()
    {
        return inertia('Admin/Permission/Create');
    }

    public function store(StoreRequest $request)
    {
        $permission = $this->permissionService->store($request->validated());
        return redirect()->route('admin.permissions.create')
            ->with('success', 'Разрешение успешно создана!');
    }
}
