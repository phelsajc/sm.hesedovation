<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs;
use App\JobsCategory;
use App\JobsSkills;
use App\JobsAttachments;
use App\JobServiceCategory;
use App\JobMasterSkills;
use App\User;
use App\JobsApplication;
use Auth;
use Illuminate\Support\Facades\Redirect;

//my perosnal controller
class JobsController extends Controller
{
    public function index()
    {        
        $category = JobServiceCategory::all();
        $skills = JobMasterSkills::all();
        return view('admin.jobs.insert',compact('category', 'skills')); 
    }

    public function store(Request $request)
    {
        //dd($request);exit;
        date_default_timezone_set('Asia/Manila');
        $c = new Jobs;
        $c->title = $request->title;
        $c->level = $request->lvl;
        $c->time_frame = $request->proj_duration;
        $c->type_of_freelancers = $request->freelancers;
        $c->freelnacers_language_lvl = $request->eng_lvl;
        $c->details = $request->details;
        $c->cost = $request->cost;
        $dt = date_create($request->job_expiry);
        $c->expiry_dt = date_format($dt,"Y-m-d");;
        $c->location = $request->cid;
        $c->status = $request->status;
        $c->employer_id = Auth::user()->id;
        $c->created_dt = date("Y-m-d H:i");
        $c->save();

        if(sizeof($request->cetegories)>0){
            foreach ($request->cetegories as $key => $value) {
               $cat = new JobsCategory;
               $cat->job_id = $c->id;
               $cat->categories = $value;
               $cat->save();       
            }
        }

        if(sizeof($request->skills)>0){
            foreach ($request->skills as $key => $value) {
               $skills = new JobsSkills;
               $skills->job_id = $c->id;
               $skills->skills = $value;
               $skills->save();       
            }
        }
       // dd($request);exit;
        return Redirect::to('/add-job');   
    }

    public function update(Request $request)
    {
        //dd($request);exit;
        date_default_timezone_set('Asia/Manila');
        $c = Jobs::find($request->id);
        $c->title = $request->title;
        $c->level = $request->lvl;
        $c->time_frame = $request->proj_duration;
        $c->type_of_freelancers = $request->freelancers;
        $c->freelnacers_language_lvl = $request->eng_lvl;
        $c->details = $request->details;
        $c->cost = $request->cost;
        $dt = date_create($request->job_expiry);
        $c->expiry_dt = date_format($dt,"Y-m-d");;
        $c->location = $request->cid;
        $c->status = $request->status;
        $c->employer_id = Auth::user()->id;
        $c->created_dt = date("Y-m-d H:i");
        $c->save();
        if(sizeof($request->cetegories)>0){
            JobsCategory::where(['job_id'=>$request->id])->delete();
            foreach ($request->cetegories as $key => $value) {
               $cat = new JobsCategory;
               $cat->job_id = $request->id;
               $cat->categories = $value;
               $cat->save();       
            }
        }
        if(sizeof($request->skills)>0){
            JobsSkills::where(['job_id'=>$request->id])->delete();
            foreach ($request->skills as $key => $value) {
               $skills = new JobsSkills;
               $skills->job_id = $request->id;
               $skills->skills = $value;
               $skills->save();       
            }
        }
       return Redirect::to('edit-job/'.$request->id);   
    }

    public function JobDetailPage($id)
    {
        $get_job_detail = Jobs::where(['id'=>$id])->first();
        $get_job_skills = JobsSkills::where(['job_id'=>$id])->get();
        $get_job_categories = JobsCategory::where(['job_id'=>$id])->get();
        $get_employer_img = User::where(['id'=>$get_job_detail->employer_id])->first();
        return view('employer.job_detail',compact('get_job_detail', 'get_job_skills', 'get_job_categories', 'get_employer_img'));
    }

    public function JobList()
    {
        $get_job_list= Jobs::where(['employer_id'=>Auth::user()->id])->get();
        return view('employer.jobs',compact('get_job_list'));
    }

    public function ApplicantList($id)
    {
        $get_application_lists= JobsApplication::where(['job_id'=> $id])->get();
        $get_job_detail = Jobs::where(['id'=> $id])->first();
        return view('employer.applicants',compact('get_application_lists', 'get_job_detail'));
    } 
    
    public function edit($id)
    {
        $get_job_detail = Jobs::where(['id'=>$id])->first();
        $get_job_skills = JobsSkills::where(['job_id'=>$id])->get();
        $get_job_categories = JobsCategory::select('categories')->where(['job_id'=>$id])->get();
        $master_category = JobServiceCategory::all();
        $master_skills = JobMasterSkills::all();

        //$cat_arr = array("MOBILES","DIGITAL MARKETING", "WRTING & TRANSLATION","PROGRAMMING TECH","VIRTUAL ASSISTANT","BUSINESS", "MUSIC & AUDIUO","ANIMATION");
        $cat_arr = array();
        foreach ($master_category as $key => $value) {
            $cat_arr[] = $value->category;
        }

        //$skills_arr = array("CSS","PHP", "JAVA SCRIPT","JAVA","FLUTTER","REACT", "ANGULAR");
        $skills_arr = array();
        foreach ($master_skills as $key => $value) {
            $skills_arr[] = $value->skills;
        }

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

    public function showJobList()
    {        
        $get_job_skills = JobMasterSkills::all();
        $get_job_categories = JobServiceCategory::all();
        $get_jobs = Jobs::paginate(5);
        return view('employer.jobs_listings',compact('get_job_skills', 'get_job_categories', 'get_jobs'));
    }

    public function employerDetail($id)
    {
        $employer = User::where(['id' => $id])->first();
        return view('employer.profile',compact('employer'));
    }
}
