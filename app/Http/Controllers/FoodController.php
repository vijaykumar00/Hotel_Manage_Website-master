<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\food;
use App\category_food;
class FoodController extends Controller
{
    public function getFood()
    {
        $food=food::all();
        return view('admin.food.list',['food'=>$food]);
    }
    public function Edit($id)
    {
        $categoryFood=category_food::all();
        $food=food::find($id);
        return view('admin.food.edit',['food'=>$food,'categoryFood'=>$categoryFood]);
    }
    public function EditPost(Request $request,$id)
    {
        $this->validate($request,
        [
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
            
            
        ],
        [   
            'name.required'=>"name is required",
            'description.required'=>"enter the description",
            'price.required'=>"price is required",

           
        ]);
        
        $food=food::find($id);
        $food->name=$request->name;
        $food->description=$request->description;
        $food->price=$request->price;
        $food->idCategory=$request->idCategory;
      
       
    
        $food->save(); 


        return redirect('admin/food/list')->with('annoucement','Edit successful dish information');
      
    }

    public function Add()
    {
        $categoryFood=category_food::all();
        return view('admin.food.add',['categoryFood'=>$categoryFood]);
    }
    public function AddPost(Request $request)
    {
       $this->validate($request,
        [
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
            
            
        ],
        [   
            'name.required'=>"name is requird",
            'description.required'=>"enter the description",
            'price.required'=>"enter the price",

           
        ]);
        // dd($request->all());
        $food=new food;
        $food->name=$request->name;
        $food->description=$request->description;
        $food->price=$request->price;
        $food->idCategory=$request->idCategry;
      
       
    
        $food->save(); 


        return redirect('admin/food/list')->with('annoucement','Add a successful dish');
      
      
    }
    public function Delete($id)
    {
        $food=food::find($id);
        $food->delete();
        return redirect('admin/food/list')->with('annoucement','
        Successfully deleted the dish');
     }

}   
 ?>