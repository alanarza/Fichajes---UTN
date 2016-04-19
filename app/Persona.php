<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

    /*public function personalObj ()
    {
    	return this->belongsTo('App\Personal', 'personal_id');
    }*/

    protected $primaryKey = 'id';
    protected $table = 'persona';
    public $timestamps = false;
}
