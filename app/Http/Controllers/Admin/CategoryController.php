<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        return inertia('Admin/Category/Index', compact('categories'));
    }

    public function show(Category $category)
    {
        $category = CategoryResource::make($category)->resolve();
        return inertia('Admin/Category/Show', compact('category'));
    }

    public function create()
    {
        return inertia('Admin/Category/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $category = $this->categoryService->store($request->validate([
            'title' => 'required|string|max:255'
        ]));

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно создана');
    }
}
