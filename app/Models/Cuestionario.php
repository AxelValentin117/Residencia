<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    protected $table = 'cuestionarios';
    protected $fillable = ['curso_id','titulo'];

    public function curso(){
        return $this->belongsTo(Curso::class,'curso_id');
    }

    public function preguntas(){
        return $this -> hasMany(Pregunta::class,'cuestionario_id');
    }

}
