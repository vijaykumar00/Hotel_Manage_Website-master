<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    protected $table="rooms";
   
    public $timestamps = false;

    public function categoryRoom()
    {
    	return $this->belongsTo('App\category_room','idCategory');
    }
}
