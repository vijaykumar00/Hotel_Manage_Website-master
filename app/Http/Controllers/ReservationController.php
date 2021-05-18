<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\reservation;
// use App\CategoryReservation;
use App\room;
use App\details_bill;
use App\category_room;
class ReservationController extends Controller
{
	public function getReservation()
	{
		$reservation=reservation::all();
        $room=room::all();
		return view('admin.reservation.list',['reservation'=>$reservation,'room'=>$room]);
	}
	public function Edit($id)
	{
        $room=room::all();
		$reservation=reservation::find($id);
		return view('admin.reservation.edit',['reservation'=>$reservation,'room'=>$room]);
	}
	public function EditPost(Request $request,$id)
	{
		$this->validate($request,
        [
            'idRoom'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'DateIn'=>'required',
            'DateOut'=>'required',
            'Numbers'=>'required',
            'Notes'=>'required',
            
        ],
        [   

            'idRoom.required'=>"room id is required",
            'name.required'=>"name is required",
            'phone.required'=>"phone is required",
            'email.required'=>"email is required",
            'DateIn.required'=>"You have not entered a date of arrival",
            'DateOut.required'=>"You have not entered a date",
            'Numbers.required'=>"
            You did not enter a number",
            'Notes.required'=>"
            You have not entered Notes",

           
        ]);
        
        $reservation=reservation::find($id);
       // $reservation->link=$request->link;
        
        $reservation->room_id=$request->idRoom;
        $reservation->name=$request->name;
        $reservation->phone=$request->phone;
        $reservation->email=$request->email;
        $reservation->DateIn=$request->DateIn;
        $reservation->DateOut=$request->DateOut;
        $reservation->Numbers=$request->Numbers;
        $reservation->Notes=$request->Notes;

      
       
    
        $reservation->save(); 


        return redirect('admin/reservation/list')->with('annoucement','
        Successfully edited reservation information');
      
	}

    public function Add()
    {
        
        $room=room::all();
        return view('admin.reservation.add',['room'=>$room]);
    }
    public function AddPost(Request $request)
    {
     $this->validate($request,
        [
            'idRoom'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'DateIn'=>'required',
            'DateOut'=>'required',
            'Numbers'=>'required',
            'Notes'=>'required',
            
        ],
        [   

            'idRoom.required'=>"
            You have not entered a room name",
            'name.required'=>"You have not entered a customer name",
            'phone.required'=>"
            You did not enter a phone number",
            'email.required'=>"
            You have not entered email yet",
            'DateIn.required'=>"
            You have not entered a date of arrival",
            'DateOut.required'=>"
            You have not entered a date",
            'Numbers.required'=>"
            You did not enter a number",
            'Notes.required'=>"
            You have not entered Notes",

           
        ]);
        
        // $roomtaken=room::where('id',$request->room_id)->get();
        // $roomtaken[0]->Status=0;
        // $roomtaken[0]->save();

        $reservation=new reservation;
       // $reservation->link=$request->link;
        
        $reservation->room_id=$request->idRoom;
        $reservation->name=$request->name;
        $reservation->phone=$request->phone;
        $reservation->email=$request->email;
        $reservation->DateIn=$request->DateIn;
        $reservation->DateOut=$request->DateOut;
        // $reservation->Numbers=$request->Numbers;ssssssss
        $reservation->Notes=$request->Notes;
            $reservation->food_id=1;
        $reservation->save(); 

        $r=Room::find($reservation->room_id);
        $cate=category_room::find($r->idCategory);
       
        $day= (strtotime($reservation->DateOut) - strtotime($reservation->DateIn))/60/60/24;
        $bill=new details_bill;
        $bill->content='
        Room charge';
        $bill->price= $cate->price*$day;
        $bill->idReservation=$reservation->id;
        $bill->save();  


        return redirect('admin/reservation/list')->with('annoucement','
        The reservation was added successfully');
      
    }
    public function Delete($id)
    {   
        $bill=details_bill::where('idReservation',$id)->get();
        // foreach ($bill as $b) {
        //     $b->delete();
        // }

        $reservation=reservation::find($id);
        // $reservation->status=1;
        $room=Room::find($reservation->room_id);
        // $room->Status=1;
        $room->save();
        $reservation->save();
        return redirect('admin/reservation/list')->with('annoucement','Check-out was successful');
     }

}	
 ?>