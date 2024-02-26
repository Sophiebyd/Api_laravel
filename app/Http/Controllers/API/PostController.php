<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        // Validation des données de la requête
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required|min:5|max:3000',
                'tags' => 'required|min:5|max:3000',
                'user_id' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            ],
        );

        // Vérification des erreurs de validation
        if ($validator->fails()) {
            // Si la validation échoue, retourne les erreurs au format JSON avec un code de statut 400
            return response()->json($validator->errors(), 400);
        }

        // Création d'une nouvelle instance de Post et sauvegarde dans la base de données
        $post = Post::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
            'image' => $request->image,
            'tags' => $request->tags,
        ]);

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
    public function update(Request $request, Post $post)
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
