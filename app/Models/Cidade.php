<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cidade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'estado',
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}
