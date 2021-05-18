<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\details_bill;
use App\reservation;
class BillController extends Controller
{
	public function getBill($id)
	{
		$bill=details_bill::where('idReservation',$id)->get();
        $reservation=Reservation::find($id);

		return view('admin.bill.list',['bill'=>$bill,'reservation'=>$reservation]);
	}
	

    public function Add($id)
    {
        $reservation=reservation::find($id);
        return view('admin.bill.add',['reservation'=>$reservation]);
    }

    public function AddPost(Request $request,$id)
    {
        $this->validate($request,
        [
            'content'=>'required',
            'price'=>'required',
           
            
        ],
        [   
            'content.required'=>"You did not enter content",
            'price.required'=>"You have not entered a price",
           
           
        ]);

        $bill=new details_bill;
        $bill->content=$request->content;
        $bill->price=$request->price;
        $bill->idReservation=$id;
        $bill->save();
       
    
     


        return redirect('admin/bill/list/'.$id)->with('annoucement','Successfully added bill');
    }
    public function Delete($id,$idReser)
    {
       
        $bill=details_bill::find($id);
        $bill->delete();
        return redirect('admin/bill/list/'.$idReser)->with('annoucement','Successfully deleted bill');
     }
     
}	
 ?>