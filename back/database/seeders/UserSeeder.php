<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class UserSeeder extends Seeder
{
    private const DEMO_PASSWORD = 'TempusLocal2026!';

    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('UserSeeder is only available in local and testing environments.');
        }

        $users = [
            ['Administrador Principal', 'soxi@multitel.co.ao', 'administrador'],
            ['Administrador Secundário', 'juelson@multitel.co.ao', 'administrador'],
            ['Cliente Demonstração 1', 'cliente1@multitel.co.ao', 'cliente'],
            ['Cliente Demonstração 2', 'cliente2@multitel.co.ao', 'cliente'],
        ];

        foreach ($users as [$name, $email, $profile]) {
            User::withoutTimestamps(fn () => User::firstOrCreate(
                ['email' => $email],
                [
                    'nome' => $name,
                    'password' => self::DEMO_PASSWORD,
                    'perfil' => $profile,
                ]
            ));
        }
    }
}
