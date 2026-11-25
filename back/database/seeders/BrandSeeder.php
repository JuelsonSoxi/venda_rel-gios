<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Poedagar', 'Binbond', 'Dazzling'] as $name) {
            Marca::firstOrCreate(['nome' => $name]);
        }
    }
}
