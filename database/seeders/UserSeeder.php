<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el usuario admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('Admin');

        // Crear un usuario con rol Vendedor
        $vendedor = User::create([
            'name' => 'vendedor',
            'email' => 'vendedor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('vendedor123'),
        ]);
        $vendedor->assignRole('Vendedor');

        // Crear un usuario con rol Usuario
        $usuario = User::create([
            'name' => 'usuario',
            'email' => 'usuario@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('usuario123'),
        ]);
        $usuario->assignRole('Usuario');
    }
}