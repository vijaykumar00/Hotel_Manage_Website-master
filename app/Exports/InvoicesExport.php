<?php
namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\details_bill;
use App\reservation;
class InvoicesExport implements FromView
{	
	public $view;
	public $data;

	public function __construct($id = "")
	{
	    //$this->view = $view;
	    $this->id = $id;
	}


    public function view(): view
    {
        // return view('admin.bill.invoice', [
        //     'invoices' => Invoice::all()
        // ]);
        $bill= details_bill::where('idReservation',$this->id)->get();
        $reservation = reservation::where('id',$this->id)->get();
        return view('admin.bill.invoice')
        	   ->with('bill', $bill)
        	   ->with('reservation',$reservation);
        	   
    }
}