<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $fillable = ['cuestionario_id','text_pregunta'];

    public function Cuestionario(){
        return $this->belongsTo(Cuestionario::class,'cuestionario_id');
    }
}
