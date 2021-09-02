<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Slider;
use App\SliderFacts;
use App\CategorySlider;
use App\Course;
use App\Meeting;
use App\BBL;
use App\BundleCourse;
use App\Testimonial;
use App\Trusted;
use App\Order;
use Auth;
use Session;
use Cookie;
use App\Blog;
use App\Batch;
use Illuminate\Support\Facades\Schema;
use App\Setting;
use App\Advertisement;
use App\Custom_section;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = Categories::orderBy('position','ASC')->get();
        $sliders = Slider::orderBy('position', 'ASC')->get();
        $facts = SliderFacts::limit(3)->get();
        $categories = CategorySlider::first();
        $cor = Course::all();
        $meetings = Meeting::where('link_by', NULL)->get();
        $bigblue = BBL::where('is_ended','!=',1)->where('link_by', NULL)->get();
        $testi = Testimonial::all();
        $trusted = Trusted::all();

        $blogs = Blog::where('status', '1')->get();

        $viewed = session()->get('courses.recently_viewed');


        if (Schema::hasColumn('bundle_courses', 'is_subscription_enabled'))
        {
            $bundles = BundleCourse::where('is_subscription_enabled', 0)->get();
            $subscriptionBundles = BundleCourse::where('is_subscription_enabled', 1)->get();
        }
        else{

            $bundles = NULL;
            $subscriptionBundles = NULL;

        }
        

        if(Schema::hasTable('batch')){
            $batches = Batch::where('status', '1')->get();
        }
        else{
            $batches = NULL;
        }

        if(Schema::hasTable('advertisements')){
            $advs = Advertisement::where('status','=',1)->get();
        }
        else{
            $advs = NULL;
        }
        


        if(isset($viewed))
        {
           $recent_course_id = array_unique($viewed); 
        }
        else{

            $recent_course_id = NULL;

        }


        $counter = 0;
        $recent_course = NULL;

        if(Auth::check())
        {
            if( isset($recent_course_id) )
            {
                foreach ($recent_course_id as $item) {

                    $recent_course = Course::where('id', $item)->where('status', '1')->first();

                    if(isset($recent_course))
                    {
                        $counter++;
                    }
                }

            }
            

        }
        


        $total_count=$counter-1;
        $section = Custom_section::where(['status'=>true])->get();
        /* $courses_section = DB::connection('mysql')->select("select * from courses where status = 1 and (category_id = 1 or category_id = 2)");
        $ff = json_decode(json_encode($courses_section),true); */
        return view('home', compact('section','category', 'sliders', 'facts', 'categories', 'cor', 'bundles', 'meetings', 'bigblue', 'testi', 'trusted', 'recent_course_id', 'blogs', 'subscriptionBundles', 'batches', 'recent_course', 'total_count', 'advs'));
    }
}
