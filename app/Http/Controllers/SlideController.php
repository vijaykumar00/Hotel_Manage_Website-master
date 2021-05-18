<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\slide;
class SlideController extends Controller
{
	public function getSlide()
	{
		$slide=slide::all();
		return view('admin.slide.list',['slide'=>$slide]);
	}
	public function Edit($id)
	{
		$slide=slide::find($id);
		return view('admin.slide.edit',['slide'=>$slide]);
	}
	public function EditPost(Request $request,$id)
	{
		$this->validate($request,
        [
            
            'caption'=>'required',
            
        ],
        [   
            
            'caption.required'=>"You have not entered image caption",
           
        ]);
        
        $slide=slide::find($id);
       // $slide->link=$request->link;
        $slide->caption=$request->caption;
        $slide->link="images/" . $request->image->getClientOriginalName();
       
    
        $slide->save(); 


        return redirect('admin/slide/list')->with('annoucement','Successfully edited slide information');
      
	}

    public function Add()
    {
        return view('admin.slide.add');
    }
    public function AddPost(Request $request)
    {
       $this->validate($request,
        [
            'link'=>'required',
            'caption'=>'required',
            
        ],
        [   
            'link.required'=>"You have not entered image link",
            'caption.required'=>"
            You have not entered image caption",
           
        ]);
        
        $slide=new slide;
        $slide->link=$request->link;
        $slide->caption=$request->caption;
      
       
    
        $slide->save(); 


        return redirect('admin/slide/list')->with('annoucement','Successfully added slide');
      
    }
    public function Delete($id)
    {
        $slide=slide::find($id);
        $slide->delete();
        return redirect('admin/slide/list')->with('annoucement','
        Successfully deleted the slide');
     }

}	
 ?>