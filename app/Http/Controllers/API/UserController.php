<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        $user = new User;
        $user->pseudo = $request->input('pseudo');
        $user->email = $request->input('email');
        $user->departement_id = $request->input('departement');
        $user->image = $request->input('image');
        $user->password = $request->input('password');
        $user->save();

        return response()->json(['message' => 'Utilisateur ajouté avec succès']);
    }

    // Fonction pour récupérer les infos d'un utilisateur spécifique
    public function show($id)
    {
        $user = User::find($id);

        if ($user !== null) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

     // Fonction pour mettre à jour les informations d'un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user !== null) {
            $user->pseudo = $request->input('pseudo');
            $user->email = $request->input('email');
            $user->departement_id = $request->input('departement');
            $user->image = $request->input('image');
            $user->password = $request->input('password');
            $user->save();
            return response()->json(['message' => 'Utilisateur mis à jour avec succès']);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

     // Fonction pour supprimer un utilisateur

    public function destroy($id)
    {
        $user = User::find($id);
        
        if ($user !== null) {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }
};