<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Relogio;
use Illuminate\Database\Seeder;

class WatchSeeder extends Seeder
{
    public function run(): void
    {
        $watches = [
            ['p692', 'Poedagar 692 Cronógrafo', 'Poedagar', 'Cronógrafo', 17000, 'Cronógrafo desportivo, ponteiros luminosos, resistência à água até 30 m, bracelete em couro genuíno.', 'Couro', '30', 'poedagar-692.jpg'],
            ['azul', 'Poedagar Azul Rosé', 'Poedagar', 'Elegante', 18000, 'Movimento de quartzo, resistência à água 3 ATM, vidro Hardlex e mostrador azul.', 'Couro', '30', 'poedagar-azul.jpg'],
            ['aco', 'Poedagar Aço Clássico', 'Poedagar', 'Clássico', 18000, 'Bracelete em aço inoxidável, mostrador preto texturado, movimento de quartzo e calendário.', 'Aço inoxidável', '30', 'poedagar-aco.jpg'],
            ['bin', 'Binbond Ouro e Prata', 'Binbond', 'Elegante', 18000, 'Mostrador com cristais, indicação de dia e data, acabamento dourado e prateado.', 'Aço inoxidável', '30', 'binbond.jpg'],
            ['dg', 'Dazzling Grafite', 'Dazzling', 'Clássico', 16000, 'Movimento de quartzo, vidro mineral endurecido e caixa em liga metálica.', 'Couro', '30', 'dazzling-grafite.jpg'],
            ['da', 'Dazzling Areia', 'Dazzling', 'Clássico', 16000, 'Movimento de quartzo, vidro mineral endurecido e caixa em liga metálica.', 'Couro', '30', 'dazzling-areia.jpg'],
        ];

        foreach ($watches as [$reference, $model, $brandName, $categoryName, $price, $description, $strap, $waterResistance, $image]) {
            Relogio::updateOrCreate(
                ['referencia' => $reference],
                [
                    'marca_id' => Marca::where('nome', $brandName)->value('id'),
                    'categoria_id' => Categoria::where('nome', $categoryName)->value('id'),
                    'modelo' => $model,
                    'descricao' => $description,
                    'preco' => $price,
                    'tipo_movimento' => 'quartzo',
                    'material_caixa' => 'Liga metálica',
                    'material_bracelete' => $strap,
                    'diametro_mm' => 40,
                    'resistencia_agua_m' => (int) $waterResistance,
                    'genero' => 'masculino',
                    'cor_mostrador' => str_contains($reference, 'azul') ? 'Azul' : 'Preto',
                    'garantia_meses' => 12,
                    'stock' => 10,
                    'imagem' => 'img/'.$image,
                    'estado' => 'disponivel',
                ]
            );
        }
    }
}
