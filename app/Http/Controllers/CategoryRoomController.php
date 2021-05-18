<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\room;
use App\category_room;
class CategoryRoomController extends Controller
{
	public function getRoom()
	{
		$room=category_room::all();
		return view('admin.room_category.list',['category_room'=>$room]);
	}
	public function Edit($id)
	{
        //$categoryRoom=CategoryRoom::all();
		$room=category_room::find($id);
		return view('admin.room_category.edit',['category_room'=>$room]);
	}

	public function EditPost(Request $request,$id)
	{
		$this->validate($request,
        [
            
            'name'=>'required',
            'price'=>'required',
            'description'=>'required',
            
        ],
        [   
            
            'name.required'=>"You have not entered a room type name",
            'price.required'=>"You have not entered a room type rate",
            'description.required'=>"You have not entered a room type description",
           
        ]);
        
        $room=category_room::find($id);
       // $room->link=$request->link;
        $room->name=$request->name;
        $room->price=$request->price;
        $room->description=$request->description;
        if ($request->image) $room->image="images/" . $request->image->getClientOriginalName();
      
       
    
        $room->save(); 


        return redirect('admin/category_room/list')->with('annoucement','Successfully edited room information');
      
	}

    public function Add()
    {
        $categoryRoom=category_room::all();
        return view('admin.room_category.add',['categoryRoom'=>$categoryRoom]);
    }
    public function AddPost(Request $request)
    {
      $this->validate($request,
        [
            
            'name'=>'required',
            'price'=>'required',
            'description'=>'required',
            'image' => 'required'
            
        ],
        [   
            
            'name.required'=>"Name is required",
            'price.required'=>"price is required",
            'description.required'=>"description is required",
            'image.required'=>"image is required",
           
        ]);
        
        $room=new category_room;
       // $room->link=$request->link;
        $room->name=$request->name;
        $room->price=$request->price;
        $room->description=$request->description;
        $room->image="images/" . $request->image->getClientOriginalName();
      
       
    
        $room->save(); 


        return redirect('admin/category_room/list')->with('annoucement','
        added room type successfully');
      
      
    }
    public function Delete($id)
    {
        $room=category_room::find($id);
        $room->delete();
        return redirect('admin/category_room/list')->with('annoucement','Room type deleted successfully');
     }

}	
 ?>