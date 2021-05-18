<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    protected $table="reservations";
    public $timestamps = false;
    public function getRoom()
    {
    	return $this->belongsTo('App\Room','idRoom','id');
    }
}
