<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\StoreRequest;
use App\Http\Requests\Api\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $comment = Comment::create($data);

        return CommentResource::make($comment)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return CommentResource::make($comment)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Comment $comment, UpdateRequest $request)
    {
        $data = $request->validated();
        $comment->update($data);
        return CommentResource::make($comment)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response([
            'message' => 'Comment deleted successfully'
        ],
            Response::HTTP_OK);
    }
}
