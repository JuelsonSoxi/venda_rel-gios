<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marca extends Model
{
    protected $table = 'marcas';

    public $timestamps = false;

    protected $fillable = ['nome'];

    public function watches(): HasMany
    {
        return $this->hasMany(Relogio::class, 'marca_id');
    }
}
