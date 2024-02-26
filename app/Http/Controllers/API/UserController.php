<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Fonction pour renvoyer la liste des utilisateurs
    public function index()
    {
        //On récupère tous les utilisateurs
        $users = User::all();

        //On retourne les utilisateurs en JSON
        return response()->json([
            'status' => true,
            'message' => 'utilisateur récupérés avec succès',
            'users' => $users
        ]);
    }

    // Fonction pour sauvegarder un nouvel utilisateur
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $user->update([
                'image' => $imageName
            ]);
        }
        
        return response()->json([
            'message' => 'Utilisateur ajouté avec succès',
            'status' => true,
            'user' => $user,
        ], 201);
    }

    // Fonction pour récupérer les infos d'un utilisateur spécifique
    public function show(User $user)
    {
        return response()->json([
            'message' => 'Utilisateur trouvé',
            'status' => true,
            'user' => $user,
        ]);
    }

    // Fonction pour mettre à jour les informations d'un utilisateur
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $user->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'Utilisateur modifié',
        ]);
    }

    // Fonction pour supprimer un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'Utilisateur supprimé',
        ]);
    }
}
