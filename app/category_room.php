<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category_room extends Model
{
    protected $table="category_rooms";
    public $timestamps = false;
    public function getRoom()
    {
    	return $this->hasMany('App\Room','idCategory','id');
    }
}
