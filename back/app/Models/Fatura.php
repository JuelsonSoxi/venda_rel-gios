<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fatura extends Model
{
    protected $table = 'faturas';

    public $timestamps = false;

    protected $fillable = ['compra_id', 'numero', 'data_emissao'];

    protected function casts(): array
    {
        return [
            'numero' => 'integer',
            'data_emissao' => 'date',
        ];
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
}
