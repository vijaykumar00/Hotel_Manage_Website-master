<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\event;
class EventController extends Controller
{
	public function getEvent()
	{
		$event=event::all();
		return view('admin.event.list',['event'=>$event]);
	}
	public function Edit($id)
	{
		$event=event::find($id);
		return view('admin.event.edit',['event'=>$event]);
	}
	public function EditPost(Request $request,$id)
	{
		$this->validate($request,
        [
            'name'=>'required',
            'body'=>'required',
            'image'=>'required',
            
            
        ],
        [   
            'name.required'=>"name is required",
            'body.required'=>"
            You did not enter content",
            'image.required'=>"You did not enter image",
            
            
           

        ]);
        
        $event=event::find($id);
        
       $event->name=$request->name;
        $event->body=$request->body;
        $event->image="images/" . $request->image->getClientOriginalName();
       
    
        $event->save(); 


        return redirect('admin/event/list')->with('annoucement','
        Successfully edited event information');
      
	}

    public function Add()
    {
        return view('admin.event.add');
    }
    public function AddPost(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'required',
            'body'=>'required',
            'image'=>'required',
            
        ],
        [   
            'name.required'=>"name is requird",
            'body.required'=>"enter the content",
            'image.required'=>"You did not enter image",
           
        ]);
// dd($request->all());
        $event=new event;
        $event->name=$request->name;
        $event->body=$request->body;
        $event->image="images/" . $request->image;
       
    
        $event->save(); 


        return redirect('admin/event/list')->with('annoucement','
        Successfully added event');
    }
    public function Delete($id)
    {
        $event=event::find($id);
        $event->delete();
         return redirect('admin/event/list')->with('annoucement','Successfully deleted the event');
     }

}	
 ?>