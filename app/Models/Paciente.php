<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'cpf',
        'celular',
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
