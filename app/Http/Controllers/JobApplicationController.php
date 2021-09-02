<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs;
use App\JobsCategory;
use App\JobsSkills;
use App\JobsAttachments;
use App\JobServiceCategory;
use App\JobMasterSkills;
use App\JobsApplication;
use App\User;
use App\JobsApplicationConvo;
use App\JobsHiring;
use Auth;
use DB;

use Illuminate\Support\Facades\Redirect;

//my perosnal controller
class JobApplicationController extends Controller
{
    public function index()
    {        
        if(Auth::check())
        {
            $getJobs = JobsApplication::where(['user_id' => Auth::user()->id])->get();       
            return view('front.job_applications',compact('getJobs'));  
        }
    }

    public function showJobApplicationDetail($id,$to,$user_id)
    {    
        if(Auth::check())
        {
            $getJobsApplicationDetail = JobsApplication::where(['job_id' => $id,'user_id'=>$user_id])->first(); 
            $getJobDetail = Jobs::where(['id' => $id])->first(); 
            $log_user = Auth::user()->id;
            $convo = DB::connection('mysql')->select("select * from  job_applied_convo where job_id = $id  and (sender =$log_user or sender = $to) and (employer = $log_user or employer = $to) order by sent_dt asc");
            return view('front.job_applications_detail',compact('getJobDetail' ,'getJobsApplicationDetail','convo'));  
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new JobsApplication;
        $c->user_id = Auth::user()->id;
        $c->job_id = $request->job_id;
        $c->message = $request->message;
        $c->date_applied = date("Y-m-d H:i");
        $c->subject = $request->subject;
        $c->save();        
        return redirect()->back();
    }

    public function store_convo(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new JobsApplicationConvo;
        $c->sender = Auth::user()->id;
        $c->employer = $request->to;
        $c->job_id = $request->job_id;
        $c->message = $request->message;
        $c->sent_dt = date("Y-m-d H:i");
        $c->save();        
        echo true;
    }

    public function hire_this_applicant(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new JobsHiring;
        $c->user_id = $request->user_id;
        $c->job_id = $request->job_id;
        $c->remarks = $request->remarks;
        $c->hired_dt = date("Y-m-d H:i");
        $c->employer_id = Auth::user()->id;
        $c->save();        
        echo true;
    }
}
