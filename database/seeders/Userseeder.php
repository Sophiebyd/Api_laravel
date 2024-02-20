<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        //Création de l'administrateur
        User::create([
            'pseudo' => 'administrateur',
            'password'=> Hash::make('Azerty123@'),
            'email' => 'admin@arinfo.fr',
            'email_verified_at' => now(),
            'departement_id' => '72',
            'remember_token' => Str::random(10),
            'role_id' => 2
        ]);

        //création d'un utilisateur de test
        User::create([
            'pseudo' => 'utilisateur',
            'password'=> Hash::make('Azerty456@'),
            'email' => 'utilisateur@arinfo.fr',
            'email_verified_at' => now(),
            'departement_id' => '75',
            'remember_token' => Str::random(10),
            'role_id' => 1          
        ]);
    }
}
