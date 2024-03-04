<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //On récupère tous les utilisateurs
        $comments = Comment::all();

        //On retourne les utilisateurs en JSON
        return response()->json([
            'status' => true,
            'message' => 'commentaires récupérés avec succès',
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create( $request->all());

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $comment->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'message' => 'Commentaire ajouté avec succès',
            'status' => true,
            'comment' => $comment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'message' => 'Commentaire trouvé',
            'status' => true,
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $comment->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'status' => true,
            'comment' => $comment,
            'message' => 'Commentaire modifié',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'status' => true,
            'comment' => $comment,
            'message' => 'Commentaire supprimé',
        ]);
    }
}
