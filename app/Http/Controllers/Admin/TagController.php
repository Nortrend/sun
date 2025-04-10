<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Tag\TagResource;
use App\Models\Category;
use App\Models\Tag;
use App\Services\CategoryService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = TagResource::collection(Tag::all())->resolve();
        return inertia('Admin/Tag/Index', compact('tags'));
    }

    public function show(Tag $tag)
    {
        $tag = TagResource::make($tag)->resolve();
        return inertia('Admin/Tag/Show', compact('tag'));
    }

    public function create()
    {
        return inertia('Admin/Tag/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $tag = $this->tagService->store($request->validate([
            'title' => 'required|string|max:255'
        ]));
        return redirect()->route('admin.tags.index')->with('success', 'Тэг успешно создана');
    }

    public function list(Request $request)
    {
        $query = Tag::query()->select('id', 'title');

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->limit(10)->get();
    }

}
