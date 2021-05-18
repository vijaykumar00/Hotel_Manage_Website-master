<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class food extends Model
{
    protected $table="food";
    public $timestamps = false;

    public function GetById($id)
    {
    	$query="SELECT * FROM Food WHERE id=". $id;
    	// $data=DB::select(DB::raw($query));
    	// return $data;
    }
}
