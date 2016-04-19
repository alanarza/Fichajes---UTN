<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{

	protected $fillable =  
	['id', 
	'personal_id', 
	'entrada',
	'salida'];


	public function personal()
    {
        return $this->belongsTo('App\Personal', 'personal_id', 'persona_id');
    }

    protected $table = 'registro_es';
    public $timestamps = false;
}
