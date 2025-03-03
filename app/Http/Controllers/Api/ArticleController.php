<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Article::all());
    }

    public function store(Request $request): JsonResponse
    {
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());
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

