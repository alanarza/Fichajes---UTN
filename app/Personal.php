<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
	protected $fillable =  
	['persona_id', 
	'documento'];

    public function persona ()
    {
    	return $this->hasOne('App\Persona', 'id', 'persona_id');

    	//REVISAR
    }

    public function registros ()
    {
    	return $this->hasMany('App\Registro', 'persona_id');
    }

    protected $primaryKey = 'persona_id';
    protected $table = 'personal';
    public $timestamps = false;
}
