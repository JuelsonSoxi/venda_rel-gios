<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Cronógrafo', 'Clássico', 'Elegante'] as $name) {
            Categoria::firstOrCreate(['nome' => $name]);
        }
    }
}
