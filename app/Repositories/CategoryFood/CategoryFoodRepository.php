<?php

namespace App\Repositories\CategoryFood;

use App\category_food;
use App\Repositories\CategoryFood\CategoryFoodInterface as CategoryFoodInterface;
use App\CategoryFood;

class CategoryFoodRepository implements CategoryFoodInterface
{
    public $category_food;
    function __construct(category_food $category_food)
    {
        $this->category_food = $category_food;
    }

    public function GetAll()
    {
        return $this->category_food->all();
    }


}