<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs;
use App\ServiceOffer;
use App\ServiceRequest;
use App\ServiceRequestConvo;
use App\JobsHiring;
use Auth;
use DB;

use Illuminate\Support\Facades\Redirect;

//my perosnal controller
class ServiceRequestApplicationController extends Controller
{
    //service list page
    public function index()
    {        
        if(Auth::check())
        {
            $getJobs = ServiceRequest::where(['employer_id' => Auth::user()->id])->get();       
            return view('employer.service_applications',compact('getJobs'));  
        }
    }

    //service ocnvo age
    public function showServiceApplicationDetail($id,$to,$employer_id)
    {      
        if(Auth::check())
        {
            $getServiceApplicationDetail = ServiceRequest::where(['service_id' => $id,'employer_id' => $employer_id])->first(); 
            $getServiceDetail = ServiceOffer::where(['id' => $id])->first(); 
            $log_user = Auth::user()->id;
            $convo = DB::connection('mysql')->select("select * from  service_offer_convo where service_id = $id  and (sender =$log_user or sender = $to) and (send_to = $log_user or send_to = $to) order by sent_dt asc");
            //$convo = ServiceRequestConvo::where(['service_id' => $id])->orderBy('sent_dt','asc')->get(); 
            return view('employer.service_applications_detail',compact('getServiceDetail' ,'getServiceApplicationDetail','convo'));  
        }
    }

    //store convo
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new ServiceRequest;
        $c->employer_id = Auth::user()->id;
        $c->service_id = $request->service_id;
        $c->message = $request->message;
        $c->applied_dt = date("Y-m-d H:i");
        $c->subject = $request->subject;
        $c->save();        
        return redirect()->back();
    }

    public function store_convo(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new ServiceRequestConvo;
        $c->sender = Auth::user()->id;
        $c->send_to = $request->to;
        $c->service_id = $request->service_id;
        $c->message = $request->message;
        $c->sent_dt = date("Y-m-d H:i");
        $c->save();        
        echo true;
    }
}
