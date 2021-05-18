<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category_food extends Model
{
    protected $table="category_foods";
    public function getFood()
    {
    	return $this->hasMany('App\food','idCategory','id');
    }
}
