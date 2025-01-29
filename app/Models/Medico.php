<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medico extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'especialidade',
        'cidade_id',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
