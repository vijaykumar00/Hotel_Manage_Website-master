<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\information;
class InformationController extends Controller
{
	public function getInformation()
	{
		$information=information::all();
		return view('admin.information.list',['information'=>$information]);
	}
	public function edit()
	{
		$information=information::find(0);
		return view('admin.information.edit',['information'=>$information]);
	}
	public function editPost(Request $request)
	{
		 $this->validate($request,
        [
            'name'=>'required',
            'email'=>'required',
            'phone_number'=>'required',
            'slogan'=>'required',
            'address'=>'required',
            
        ],
        [
            'name.required'=>"name is requird",
            'email.required'=>"enter the email",
            'phone_number.required'=>"enter the phoone number",
            'slogan.required'=>"You have not entered a slogan",
            'address.required'=>"
            You do not enter an address",
           

        ]);
        
        $information=information::find(0);
        $information->name=$request->name;
        $information->email=$request->email;
        $information->phone_number=$request->phone_number;
        $information->slogan=$request->slogan;
        $information->address=$request->address;    
        $information->save(); 


        return redirect('admin/information/list')->with('annoucement','
        Successfully edited hotel information');
      
	}
}	
 ?>