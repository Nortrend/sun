<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Article\IndexRequest;
use App\Http\Requests\Api\Article\StoreRequest;
use App\Http\Requests\Api\Article\UpdateRequest;
use App\Http\Resources\Article\ArticleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        $data = $request->validated();
        $articles = Article::filter($data)->get();

        return ArticleResource::collection($articles)->response();
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $article = Article::create($request->validated());

        return response()->json($article, 201);
    }


    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->update($request->validated());

        return response()->json($article);
    }


    public function destroy($id): JsonResponse
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $article->delete();

        return response()->json(['success' => 'Article deleted successfully']);
    }

}

