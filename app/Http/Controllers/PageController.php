<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\information;
use App\About;
use App\category_room;
use App\description;
use App\slide;
use App\category_food;
use App\Review;
use App\event;
use App\reservation;
use App\room;
use App\User;
use App\details_bill;
use App\food;
use App\Repositories\CategoryFood\CategoryFoodInterface;
use App\Builder\PageBuilder;
class PageController extends Controller
{
    
    function __construct(
        CategoryFoodInterface $category_food
        // Information $information, 
        // About $about,
        // Description $description,
        // Slide $slide,
        // Event $event,
        // CategoryRoom $category
    ) {   
        $this->category_food=$category_food;

        $builder = new PageBuilder($this);
        $this->builder=$builder->setInfor()
                               ->setAbout()  
                               ->setDescription()
                               ->setSlide()
                               ->setEvent()
                               ->setCategory(); 
        $this->shareView();                       

    	//$this->infor=$information->find(0);
    	// $this->about=$about->find(1);
    	// $this->description=$description->find(1);
    	// $this->slide=$slide->all();
    	// $this->event=$event->all();
    	// $this->category=$event->all();
                               
    	// view()->share('infor', $this->infor);
    	// view()->share('about', $this->about);
    	// view()->share('description', $this->description);
    	// view()->share('slide', $this->slide);
    	// view()->share('event', $this->event);
    	// view()->share('category', $this->category);
    }

    public function shareView()
    {
        view()->share('infor', $this->builder->getInfor());
        view()->share('about', $this->builder->getAbout());
        view()->share('description', $this->builder->getDescription());
        view()->share('slide', $this->builder->getSlide());
        view()->share('event', $this->builder->getEvent());
        view()->share('category', $this->builder->getCategory());
    }
    // public function adduser()
    // {
    //     $user=new User;
    //     $user->name='duy';
    //      $user->password=bcrypt('123');
    //     $user->save();
    //     return redirect('admin/login')->with('annoucement','them thanh cong');
    // }
    public function Home()
    {
        $food_category=category_food::all();
        $food_category=$this->category_food->GetAll();
        //return $this->builder->getInfor();
    	$review=Review::all();
        // $food=new Food();
        // $food_data=$food->GetById(3);
        // var_dump($food_data);return;
    	return view('pages.Home',['food_category'=>$food_category,'review'=>$review]);
    }
    public function About()
    {
    	return view('pages.About');
    }
    public function Event()
    {
    	return view('pages.Events');
    }
    public function Rooms()
    {
    	return view('pages.Rooms');
    }
    public function Reservation($idCate)
    {
        return view('pages.Reservation',['idCate'=>$idCate]);
    }
    public function postReservation(Request $request)
    {
        $room=room::where('Status',1)->where('idCategory',$request->room)->get();
        if (count($room)>0) 
        {
            $roomtaken=room::where('Status',1)->where('idCategory',$request->room)->take(1)->get();
            
            $this->validate($request,
            [
                'name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'datein'=>'required',
                'dateout'=>'required',
                'numbers'=>'required'
            ],
            [
                'name.required'=>"You have not entered a name",
                'email.required'=>"You have not entered email",
                'phone.required'=>"You did not enter a phone number",
                'datein.required'=>"You have not entered a date of arrival",
                'dateout.required'=>"You have not entered a date",
                'numbers.required'=>"You did not enter a number",
            ]);
            $reservation=new reservation;
            $reservation->name=$request->name;    
            $reservation->email=$request->email; 
            $reservation->phone=$request->phone; 
            $reservation->DateIn=$request->datein; 
            $reservation->DateOut=$request->dateout; 
            $reservation->Numbers=$request->numbers; 
            $reservation->Notes=$request->notes; 
            $reservation->idRoom=$roomtaken[0]->id; 
            $roomtaken[0]->Status=0;
            $roomtaken[0]->save();

            $reservation->save();

            $r=room::find($reservation->idRoom);
            $cate=category_room::find($r->idCategory);
           
            $day= (strtotime($reservation->DateOut) - strtotime($reservation->DateIn))/60/60/24;
            $bill=new details_bill;
            $bill->content='Room charge';
            $bill->price= $cate->price*$day;
            $bill->idReservation=$reservation->id;
            $bill->created_at=$request->dateout;
            $bill->save();  
            return redirect('reservation/{1}')->with('annoucement','Your reservation is successful. Your room is '.$roomtaken[0]->name .'  .See you soon !');
        }
        else return redirect('reservation/{1}')->with('annoucement','The room type you booked has run out. Please refer to the remaining room types in the hotel system. Thank you !');
    }

}
