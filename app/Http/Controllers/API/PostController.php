<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'status' => true,
            'message' => 'all post récupérés avec succès',
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Création d'une nouvelle instance de Post et sauvegarde dans la base de données
        $post = Post::create( $request->all());

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $post->update([
                'image' => $imageName
            ]);
        }

        // Retourne une réponse JSON avec un message de succès, un statut et les détails du post nouvellement créé avec un code de statut 201
        return response()->json([
            'message' => 'Post ajouté avec succès',
            'status' => true,
            'post' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'message' => 'Post trouvé',
            'status' => true,
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $post->update([
                'image' => $imageName
            ]);
        }
        
        return response()->json([
            'status' => true,
            'post' => $post,
            'message' => 'Post modifié',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'status' => true,
            'post' => $post,
            'message' => 'Post supprimé',
        ]);
    }
}
