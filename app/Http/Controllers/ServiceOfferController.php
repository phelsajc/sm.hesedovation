<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceOffer;
use App\ServiceOfferCategory;
use App\JobServiceCategory;
use App\ServiceRequest;
use App\User;
use Auth;
use Illuminate\Support\Facades\Redirect;

//my perosnal controller
class ServiceOfferController extends Controller
{
    public function index()
    {   
        if(Auth::check())
        {
            $getServices = ServiceOffer::where(['user_id' => Auth::user()->id])->get();
            $getCat = JobServiceCategory::all();
            
            return view('front.services_offer',compact('getServices','getCat'));  
        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));    
    }

    public function store(Request $request)
    {
        //dd($request);exit;
        date_default_timezone_set('Asia/Manila');
        $c = new ServiceOffer;
        $c->title = $request->titles;
        $c->user_id = Auth::user()->id;
        $c->details = $request->detail;
        $c->fee = $request->fee;
        #$c->status = $request->status;
        $c->created_dt = date("Y-m-d H:i");
        $c->save();
        
        if(sizeof($request->cat)>0){
            foreach ($request->cat as $key => $value) {
               $cat = new ServiceOfferCategory;
               $cat->service_id = $c->id;
               $cat->category = $value;
               $cat->save();       
            }
        }

        return Redirect::to('/manage-services');   
    }
    
    public function show($id)
    {
        $getServices = ServiceOffer::where(['id' => $id])->first();
        $getServicesCat = ServiceOfferCategory::where(['service_id' => $id])->get();
        $output = array("getServices" => $getServices,"getServicesCat" => $getServicesCat);
        return $output;
    }


    public function update(Request $request)
    {
        //dd($request);exit;
        date_default_timezone_set('Asia/Manila');
        $c = ServiceOffer::find($request->id);
        $c->title = $request->titles;
        $c->details = $request->detail;
        $c->fee = $request->fee;
        $c->updated_dt = date("Y-m-d H:i");
        $c->save();

        
        if(sizeof($request->cat)>0){
            ServiceOfferCategory::where(['service_id'=>$request->id])->delete();
            foreach ($request->cat as $key => $value) {
               $cat = new ServiceOfferCategory;
               $cat->service_id = $c->id;
               $cat->category = $value;
               $cat->save();       
            }
        }
        //dd($request);exit;
        return Redirect::to('/manage-services');   
    }

    public function ServiceDetailPage($id)
    {
        $get_service_detail = ServiceOffer::where(['id'=>$id])->first();
        $get_service_categories = ServiceOfferCategory::where(['service_id'=>$id])->get();
        $get_freelancer_img = User::where(['id'=>$get_service_detail->user_id])->first();
        return view('front.service_detail',compact('get_service_detail', 'get_service_categories', 'get_freelancer_img'));
    }

    public function JobList()
    {
        $get_job_list= Jobs::where(['employer_id'=>Auth::user()->id])->get();
        return view('employer.jobs',compact('get_job_list'));
    } 
    
    public function edit($id)
    {
        $get_job_detail = Jobs::where(['id'=>$id])->first();
        $get_job_skills = JobsSkills::where(['job_id'=>$id])->get();
        $get_job_categories = JobsCategory::select('categories')->where(['job_id'=>$id])->get();
        $cat_arr = array("MOBILES","DIGITAL MARKETING", "WRTING & TRANSLATION","PROGRAMMING TECH","VIRTUAL ASSISTANT","BUSINESS", "MUSIC & AUDIUO","ANIMATION");
        $skills_arr = array("CSS","PHP", "JAVA SCRIPT","JAVA","FLUTTER","REACT", "ANGULAR");
        $cat_array = array();
        $skills_array = array();
        foreach ($get_job_skills as $key => $value) {
            $skills_array[] = $value->skills;
        }
        foreach ($get_job_categories as $key => $value) {
            $cat_array[] = $value->categories;
        }
        $new_array_skills = array();
        foreach ($skills_arr as $key => $value) {
            if (in_array($value, $skills_array)) {
                $new_array_skills[] = "<option value='$value' selected>$value</option>";
            }else{
                $new_array_skills[] = "<option value='$value'>$value</option>";
            }
        }
        $new_array = array();
        foreach ($cat_arr as $key => $value) {
            if (in_array($value, $cat_array)) {
                $new_array[] = "<option value='$value' selected>$value</option>";
            }else{
                $new_array[] = "<option value='$value'>$value</option>";
            }
        }
        //dd($skills_array);exit;
        return view('admin.jobs.insert',compact('get_job_detail', 'get_job_skills', 'get_job_categories', 'new_array', 'new_array_skills'));
    }

    public function showServiceList()
    {
        $get_services_offer = ServiceOffer::all();
        $get_services_categories = ServiceOfferCategory::all();
        $get_services = ServiceOffer::paginate(5);
        return view('front.service_listings',compact('get_services_offer', 'get_services_categories', 'get_services'));
    }

    public function showOffer()
    {
        $get_services_offer = ServiceOffer::all();
        $get_services_categories = ServiceOfferCategory::all();
        $get_services = ServiceOffer::paginate(5);
        return view('front.services_offer.blade',compact('get_services_offer', 'get_services_categories', 'get_services'));
    }

    public function viewOffers($id)
    {       
        if(Auth::check())
        {
            $getServices = ServiceRequest::where(['service_id' => $id])->get();       
            return view('front.services_view_offer',compact('getServices'));  
        }
    }
}
