<?php 
namespace App\Http\Controllers;

use App\category_room;
use Illuminate\Http\Request;
use App\Room;
class RoomController extends Controller
{
	public function getRoom()
	{
		$room=room::all();
		return view('admin.room.list',['room'=>$room]);
	}
	public function Edit($id)
	{
        $categoryRoom=category_room::all();
		$room=room::find($id);
		return view('admin.room.edit',['room'=>$room,'categoryRoom'=>$categoryRoom]);
	}
	public function EditPost(Request $request,$id)
	{
		$this->validate($request,
        [
            
            'name'=>'required',
            'idCategory'=>'required',
            'status'=>'required',
            
        ],
        [   
            
            'name.required'=>"Bạn chưa nhập tên phòng",
            'idCategory.required'=>"Bạn chưa nhập loại phòng",
            'status.required'=>"Bạn chưa nhập tình trạng phòng",
           
        ]);
        
        $room=room::find($id);
       // $room->link=$request->link;
        $room->name=$request->name;
        $room->idCategory=$request->idCategory;
        $room->Status=$request->status;
      
       
    
        $room->save(); 


        return redirect('admin/room/list')->with('annoucement','Sửa thông tin room thành công');
      
	}

    public function Add()
    {
        $categoryRoom=category_room::all();
        return view('admin.room.add',['categoryRoom'=>$categoryRoom]);
    }
    public function AddPost(Request $request)
    {
      $this->validate($request,
        [
            
            'name'=>'required',
            'idCategory'=>'required',
            'status'=>'required',
            
        ],
        [   
            
            'name.required'=>"name is requird",
            'idCategory.required'=>"You have not entered a room type",
            'status.required'=>"You have not entered room status",
           
        ]);
        
        $room=new Room;
       // $room->link=$request->link;
        $room->name=$request->name;
        $room->idCategory=$request->idCategory;
        $room->Status=$request->status;
      
       
    
        $room->save(); 

// dd($room);
        return redirect('admin/room/list')->with('annoucement','room added successfully');
      
      
    }
    
    public function Delete($id)
    {
        $room=room::find($id);
        $room->delete();
        return redirect('admin/room/list')->with('annoucement','
        Room deleted successfully');
     }

}	
 ?>