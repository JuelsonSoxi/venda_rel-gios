<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Relogio extends Model
{
    protected $table = 'relogios';

    public $timestamps = false;

    protected $fillable = [
        'referencia',
        'marca_id',
        'categoria_id',
        'modelo',
        'descricao',
        'preco',
        'tipo_movimento',
        'material_caixa',
        'material_bracelete',
        'diametro_mm',
        'resistencia_agua_m',
        'genero',
        'cor_mostrador',
        'garantia_meses',
        'stock',
        'imagem',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'diametro_mm' => 'integer',
            'resistencia_agua_m' => 'integer',
            'garantia_meses' => 'integer',
            'stock' => 'integer',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Compra::class, 'relogio_id');
    }
}
