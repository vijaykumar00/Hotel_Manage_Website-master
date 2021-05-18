<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
use App\User;
use App\Charts\yearlyReport;
use Excel;
use App\Exports\InvoicesExport;
use App\details_bill;
use App\reservation;
use App\room;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    
    public function getDangNhapAdmin()
    {
        return view('admin.login');
    }

    public function postDangNhapAdmin(Request $request)
    {
        $this->validate($request,
        [
            
            'name'=>'required',
            'password'=>'required',
        ],
        [
            'password.required'=>'You have not entered password yet',
            'name.required'=>'
            You have not entered a name',
                       
        ]);
      if (Auth::attempt(['name'=>$request->name,'password'=>$request->password]))

        {
            return redirect('admin/information/list')->with('annoucement','Logged in successfully');
        }
        else {
            return redirect('admin/login')->with('annoucement','
            Login failed');
        }
    }

    public function getDangXuatAdmin()
    {
        Auth::logout();
        return redirect('admin/login');
    }

    public function ExportBill()
    {
        $data=['name'=>'Vijay'];
        $pdf = PDF::loadview('pages.export_bill',compact('data'));

        return $pdf->download('export_bill.pdf');
    }

    public function Report()
    {
        $chart=new yearlyReport;
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'bar', [1, 2, 3, 4]);
        //$chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);
        $data_month=Reservation::
                     whereMonth('DateOut',1)
                     ->get();
        $sum=0;
        foreach ($data_month as $item) {
            $sum += $item->total_bill;
        };
        
        return view('pages.report', ['chart' => $chart,'month1'=> $sum]);
    }

    public function monthReport($idMonth)
    {
        $chart=new yearlyReport;
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'bar', [1, 2, 3, 4]);

        $reservation=Reservation::whereMonth('DateOut',$idMonth)
                     ->orderBy('DateOut','ASC')
                     ->get();

        return view('pages.monthReport', ['chart' => $chart,'reservation' =>$reservation,'idMonth' => $idMonth]);
    }

    public function exportInvoice($idReservation)
    {
        $detail_bill= DetailBill::where('idReservation', $idReservation)->get();
        // dd($detail_bill);
        $sum=0;
        foreach ($detail_bill as $item) {
            $sum += $item->price;
        }
        $reservation = Reservation::find($idReservation);
        // dd($reservation);
        $reservation->total_bill=$sum;
        // $reservation->status=1;
        $reservation->save();

        // $room=Room::find($reservation->idRoom);
        // $room->Status=1;
        // $room->save();

        //return Reservation::where('id',$idReservation)->get();
        return Excel::download(new InvoicesExport($idReservation), 'invoices.xlsx');
        
        return redirect('admin/reservation/list')
                ->with('annoucement','
                Payment success. Invoice issued')
                ;
    }

    public function getUser()
    {   
        $user=User::all();
        return view('admin.user.danhsach')
            ->with('user', $user);
    }

    public function Edit($id)
    {
        
        $user=User::find($id);
        return view('admin.user.sua',['user'=>$user]);
    }
    public function EditPost(Request $request,$id)
    {
        $this->validate($request,
        [
            
            'name'=>'required',
            'password'=>'required',
            
            
        ],
        [   
            
            'name.required'=>"name is required",
            'password'=>"enter the password
            ",
            
           
        ]);
        
        $user=User::find($id);
       // $room->link=$request->link;
        $user->name=$request->name;
        $user->password=Hash::make($request->password);
      
       
    
        $user->save(); 


        return redirect('admin/user/list')->with('thongbao','Successfully edited user information');
      
    }

    public function Add()
    {
        
        return view('admin.user.them');
    }
    public function AddPost(Request $request)
    {
      $this->validate($request,
        [
            
            'name'=>'required',
            'password'=>'required',
            
            
        ],
        [   
            
            'name.required'=>"name is required",
            'password'=>"entter the password",
            
           
        ]);
        
        $user=new User;
       // $room->link=$request->link;
        $user->name=$request->name;
        $user->password=Hash::make($request->password) ;
        // $user->type=1;
      
       
    
        $user->save(); 


        return redirect('admin/user/list')->with('thongbao','user successfully added');
      
      
    }
    public function Delete($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect('admin/user/list')->with('thongbao','Successfully deleted the user');
     }


}

