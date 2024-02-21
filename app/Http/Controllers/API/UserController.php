<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pseudo' => 'required|min:15|max:3000',
                'email' => 'required|min:5|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
                'password' => [
                    'required', 'confirmed',
                    Password::min(8) // minimum 8 caractères   
                        ->mixedCase() // au moins 1 minuscule et une majuscule
                        ->letters()  // au moins une lettre
                        ->numbers() // au moins un chiffre
                        ->symbols() // au moins un caractère spécial parmi ! @ # $ % ^ & * ?  
                ],
            ],
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'pseudo' => $request->pseudo,
            'image' => $request->image,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

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
    public function update(Request $request, User $user)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pseudo' => 'required|min:15|max:3000',
                'email' => 'required|min:5|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
            ],
        );

        // renvoi d'un ou plusieurs messages d'erreur si champ(s) incorrect(s)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user->update($request->all());
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
