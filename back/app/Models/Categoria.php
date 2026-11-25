<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    public $timestamps = false;

    protected $fillable = ['nome'];

    public function watches(): HasMany
    {
        return $this->hasMany(Relogio::class, 'categoria_id');
    }
}
