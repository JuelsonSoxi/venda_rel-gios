<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Compra extends Model
{
    protected $table = 'compras';

    public $timestamps = false;

    protected $fillable = [
        'utilizador_id',
        'relogio_id',
        'valor_total',
        'estado',
        'motivo_rejeicao',
        'numero_serie',
        'inicio_garantia',
        'data_compra',
    ];

    protected function casts(): array
    {
        return [
            'valor_total' => 'decimal:2',
            'inicio_garantia' => 'date',
            'data_compra' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilizador_id');
    }

    public function watch(): BelongsTo
    {
        return $this->belongsTo(Relogio::class, 'relogio_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Fatura::class, 'compra_id');
    }
}
