<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'aslafit@email.com'], // Verifica se o usuário já existe pelo e-mail
            [
                'name' => 'Administrador',
                'email' => 'aslafit@email.com',
                'password' => Hash::make('123456'), // Substitua "senha123" por uma senha segura
            ]
        );
    }
}
