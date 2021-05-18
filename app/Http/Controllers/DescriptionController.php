<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\description;
class DescriptionController extends Controller
{
	public function getDescription()
	{
		$description=description::all();
		return view('admin.description.list',['description'=>$description]);
	}
	public function edit()
	{
		$description=description::find(1);
		return view('admin.description.edit',['description'=>$description]);
	}
	public function editPost(Request $request)
	{
		 $this->validate($request,
        [
            'room'=>'required',
            'photo'=>'required',
            'menu'=>'required',
            'event'=>'required',
            
        ],
        [
            'room.required'=>"You did not enter content",
            'photo.required'=>"You have not imported photo",
            'menu.required'=>"You have not entered the menu",
            'event.required'=>"You have not entered the event yet",
            
           

        ]);
        
        $description=description::find(1);
        $description->room=$request->room;
        $description->photo=$request->photo;
        $description->menu=$request->menu;
        $description->event=$request->event;

        $description->save(); 


        return redirect('admin/description/list')->with('annoucement','Successfully edited hotel information');
      
	}
}	
 ?>