<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\StoreRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    public function index()
    {
        $articles = ArticleResource::collection(Article::all())->resolve();
        return inertia('Admin/Article/Index', compact('articles'));
    }

    public function show(Article $article)
    {
        $article->load('profile'); // Загружаем профиль прямо из переданного объекта
        $article = ArticleResource::make($article)->resolve();
        return inertia('Admin/Article/Show', compact('article'));
    }

    public function create()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        return inertia('Admin/Article/Create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $article = $this->articleService->store($request->validated());
        return ArticleResource::make($article)->resolve();
    }

}
