<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\category_room;
use App\room;
use App\event;
use App\reservation;
use App\details_bill;
use Illuminate\Support\Facades\Input;
class ApiController extends Controller
{
	public function getRoomType()
    {
        $data=category_room::all();
        return response()->json([
            'code' => '200',
            'data' => $data
        ]);
    }
    public function testPost()
    {
        $name = Input::get('name');
        return $name;
    }
    public function getNews()
    {
        $data=event::all();
        return response()->json([
            'code' => '200',
            'data' => $data
        ]);
    }
    public function getHistory(Request $request)
    {
        $historyList = [];
            if ($request->has('email')){
                $reservation = reservation::where('email', $request->input('email'))->get();
                $properties = [];
                foreach ($reservation as $array_item) {
                    if (!is_null($array_item['id'])) {
                        $properties['id'] = $array_item['id'];
                        $properties['idRoom'] = $array_item['idRoom'];
                        $properties['DateIn'] = $array_item['DateIn'];
                        $properties['DateOut'] = $array_item['DateOut'];
                        // $properties['status'] = $array_item['status'];
                        $room = room::where('id', $properties['idRoom'])->first();
                        $properties['roomName'] = $room['name'];
                        $idCategory = $room['idCategory'];
                        $properties['categoryRoomName'] = category_room::where('id', $idCategory)->first()['name'];
                        $properties['image'] = category_room::where('id', $idCategory)->first()['image'];
                        $properties['price'] = details_bill::where('idReservation', $properties['id'])->first()['price'];
                    }
                array_push($historyList, $properties);
            }
            return response()->json([
                'code' => '200',
                'data' => $historyList
            ]);
        }
        else {
            $data = reservation::all();
            return response()->json([
                'code' => '200',
                'data' => $data
            ]);
        }
       
    }



    public function getRoomAvailable(Request $request, $idroom)
    {   
        $numberRoom = $request->input('number');
        $room=room::where('idCategory',$idroom)->get();
        if ($numberRoom && $numberRoom <= count($room)) {
            return response()->json([
                'code' => '200',
                'data' => $room
            ]);
        } else {
            return response()->json([
                'code' => '400',
                'message' => 'There is not enough room to reserve, please come back later!'
            ]);
        }
    }

    public function getMonthReportData($idMonth)
    {
        $reservation=reservation::whereMonth('DateOut',$idMonth)
                     ->orderBy('DateOut','ASC')
                     ->get();
                   
        return response()->json([
            'code' => '200',
            'data' => $reservation
        ]);
    }

    public function postReservation()
    {   
        $room_category = Input::get('room_category');

        $room=room::where('idCategory',$room_category)->get();
        if (count($room)>0) 
        {
            $roomtaken=room::where('idCategory',$room_category)->take(1)->get();
            
            $reservation=new reservation;
            $reservation->name=Input::get('name');    
            $reservation->email=Input::get('email'); 
            $reservation->phone=Input::get('phone'); 
            $reservation->DateIn=Input::get('dateIn'); 
            $reservation->DateOut=Input::get('dateOut'); 
            $reservation->Numbers=Input::get('numbers'); 
            $reservation->Notes=Input::get('note'); 
            $reservation->idRoom=$roomtaken[0]->id; 
            $roomtaken[0]->Status=0;
            $reservation->save();

            

            $r=room::find($reservation->room_id);
            $cate=category_room::find($r->idCategory);
           
            $day= (strtotime($reservation->DateOut) - strtotime($reservation->DateIn))/60/60/24;
            $bill=new details_bill();
            $bill->content='Room charge';
            $bill->price= $cate->price*$day;
            $bill->idReservation=$reservation->id;
            $bill->created_at=Input::get('dateOut');

            
            $roomtaken[0]->save();
            $bill->save();

            return response()->json([
                'code' => '200',
                'message' => 'Your reservation is successful. Your room is '.$roomtaken[0]->name .'  .See you soon !',
                'data' => $reservation
            ]);  
            
        }
        else return response()->json([
                'code' => '400',
                'message' => 'The room type you booked has run out. Please refer to the remaining room types in the hotel system. Thank you !',
             ]);   

            
    }
    public function Reservation(Request $request) {
        $numberRoom =$request->input('number');
        $room_category = Input::get('room_category');
        $room=room::where('idCategory',$room_category)->get();
        $roomList = [];
        if ($numberRoom && $numberRoom <= count($room)) {
            for ($i=0; $i<$numberRoom; $i++) {
                $roomtaken=room::where('idCategory',$room_category)->take(1)->get();
                $reservation=new reservation;
                $reservation->name=Input::get('name');    
                $reservation->email=Input::get('email'); 
                $reservation->phone=Input::get('phone'); 
                $reservation->DateIn=Input::get('dateIn'); 
                $reservation->DateOut=Input::get('dateOut'); 
                $reservation->Numbers=Input::get('numbers'); 
                $reservation->Notes=Input::get('note');
                $reservation->idRoom=$roomtaken[0]->id;
                // $roomtaken[0]->Status=0;
                $reservation->save();
                $r=Room::find($reservation->room_id);
                $cate=category_room::find($r->idCategory);
                $day= (strtotime($reservation->DateOut) - strtotime($reservation->DateIn))/60/60/24;
                $bill=new details_bill();
                $bill->content='Room charge';
                $bill->price= $cate->price*$day;
                $bill->idReservation=$reservation->id;
                $bill->created_at=Input::get('dateOut');
                $roomtaken[0]->save();
                $bill->save();
                $roomList[$i] = $roomtaken[0]->name;
            }
            return response()->json([
                'code' => '200',
                'message' => '
                Booking successful.See you soon !',
                'data' => $reservation
            ]); 

        } else {
            return response()->json([
                'code' => '400',
                'message' => 'There is not enough room to book. Please try again later!',
                'data' => $reservation
            ]); 
        }
    }
}	
?> 