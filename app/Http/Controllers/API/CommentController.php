<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required|min:15|max:3000',
                'user_id' => 'required',
                'post_id' => 'required',
                'tags' => 'required|min:5|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            ],
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comment = Comment::create([
            'content' => $request->pseudo,
            'image' => $request->image,
            'tags' => $request->email,
        ]);

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
    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required|min:15|max:3000',
                'tags' => 'required|min:5|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
            ],
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
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
            'message' => 'Commantaire modifié',
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
