<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseJournal;
use App\Course;
use App\CourseChapter;
use App\CourseClass;
use App\Order;
use App\User;
use App\Quiz;
use App\QuizTopic;
use App\QuizAnswer;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUser;
use App\Mail\CourseOrder;
use Illuminate\Support\Facades\URL;
use App\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Redirect;

//my perosnal controller
class ApiCustomController extends Controller
{
    //use RegistersUsers;
    public function SaveJournal(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $checkJournal = CourseJournal::where(['id' => $request->jid])->first();
        if($checkJournal){
            CourseJournal::where(['id' => $request->jid])->update([
                'content' => $request->content,        
                'update_dt' => time(),
            ]);
            echo $request->jid; 
        }else{
            $c = new CourseJournal;
            $c->content = $request->content;
            $c->class_id = $request->lid;
            $c->user_id = Auth::user()->id;
            $c->course_id = $request->cid;
            $c->created_dt = date("Y-m-d H:i");
            $c->save();
            echo $c->id; 
        }        
    }

    public function view_journal($id)
    {
        $data = CourseJournal::where(['class_id' => $id,"user_id"=>Auth::user()->id])->first();
        //echo Auth::user()->id;exit;
        echo json_encode($data);
    }

    public function progressPage()
    {
        /* $user = array(
            'fname'=>'Nika Lucasan',
            'course'=>'Sample Course'
        );
        Mail::to("jclucasan@gmail.com")->send(new CourseOrder($user));
        exit; */
        $course = Course::all();
        $coursechapter = CourseChapter::all();           
        return view('admin.course.progress',compact("course",'coursechapter'));
    }

    public function courseClassProgress($id)
    {  
        $course = Order::where(['course_id'=>$id])->get();
        $course_detail = Course::where(['id'=>$id])->first();
        $course_title = $course_detail->title;
        $course_data = array();
        foreach ($course as $value) {
            $row = array();
            $user = User::where(['id'=>$value->user_id])->first();     
            $row['student'] = $user->fname.' '.$user->lname;
            $row['img'] = $user->user_img;
            $row['id'] = $id;
            $row['uid'] = $value->user_id;
            $course_data[] = $row; 
        }
        return view('admin.course.progressDetail',compact('course_data', 'course_title' ));    
    }

    public function studentClassProgress($id,$uid)
    {  
        $course_journal = CourseJournal::where(['course_id'=>$id,'user_id'=>$uid])->first();
        $quiz_topic = QuizTopic::where(['course_id'=>$id])->get();        
        $user_info = User::where(['id'=>$uid])->first();
        $topics=QuizTopic::where('id',$id)->first();
        
        $user_id = $uid."_".$id;
        /* $course = Order::where(['course_id'=>$id])->get();
        $course_detail = Course::where(['id'=>$id])->first();
        $course_title = $course_detail->title;
        $course_data = array();
        foreach ($course as $value) {
             $row = array();
            $user = User::where(['id'=>$value->user_id])->first();     
            $row['student'] = $user->fname.' '.$user->lname;
            $row['img'] = $user->user_img;
            $course_data[] = $row; 
        } */
        return view('admin.course.progressDetailStudent',compact('course_data', 'topics' ,'course_journal', 'user_id', 'quiz_topic', 'user_info' ));    
    }    
    
    public function givePoints(Request $request)
    {        
        QuizAnswer::where(['id' => $request->ans_id])->update([
            'custom_answer' => $request->custom_ans,        
            'points' => $request->points,        
        ]);

        return true;
    }

    public function checkResults($id)
    {  
        $auth = Auth::user();
        $topic = QuizTopic::where('id',$id)->get();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics=QuizTopic::where('id',$id)->first();
        $ans = QuizAnswer::where('topic_id',$id)->get(); /* where('user_id',$auth->id)
              ->where('topic_id',$id)->get();  */
        $ans_ans = array();

        $user_answer_array = array();
        $ca_answer_array = array();
        foreach ($ans as $key => $value) {
            $row = array();
            $row['answer'] = $value->answer;
            $row['id'] = $value->question_id;
            $row['user_answer'] = $value->user_answer;
            $q = Quiz::where('id', $value->question_id)->first();
            $row['type'] = $q->type;
            $row['ans_id'] = $value->id;
            $row['question'] = $q->question;
            if($q->type=="cb"){
                if($value->ans1){
                    $user_answer_array[] = $value->ans1;
                }
                if($value->ans2){
                    $user_answer_array[] = $value->ans2;
                }
                if($value->ans3){
                    $user_answer_array[] = $value->ans3;
                }
                if($value->ans4){
                    $user_answer_array[] = $value->ans4;
                }  
                
                if($q->ans1){
                    $ca_answer_array[] = $q->a;
                }
                if($q->ans2){
                    $ca_answer_array[] = $q->b;
                }
                if($q->ans3){
                    $ca_answer_array[] = $q->c;
                }
                if($q->ans4){
                    $ca_answer_array[] = $q->d;
                }  
            }
            $row['ans1'] = $value->ans1;
            $row['ans2'] = $value->ans2;
            $row['ans3'] = $value->ans3;
            $row['ans4'] = $value->ans4;
            
            $row['cans1'] = $q->ans1;
            $row['cans2'] = $q->ans2;
            $row['cans3'] = $q->ans3;
            $row['cans4'] = $q->ans4;
            $row['custom_answer'] = $value->custom_answer;
            $row['points'] = $value->points;
            $ans_ans[] = $row;
        }
        return view('admin.course.quiz.finish', compact('auth','ca_answer_array','user_answer_array','topic','questions','count_questions','ans_ans','topics','ans'));
    }

    public function getCourseClass($id)
    { 
        $data_cc = CourseClass::where(['coursechapter_id' => $id])->orderBy('sort','ASC')->get();      
        $data = array();
        foreach ($data_cc as $value) {
            if($value->is_archive==0)
            {
                $row = array();
                $row['id'] = $value->id;
                $row['title'] = $value->title;
                $row['status'] = $value->status==1? 'Active':'Inactive';
                $btn = '';
                $btn .= '<a class="btn btn-success btn-sm" href="'.URL::to('/courseclass').'/'.$value->id.'"><i class="glyphicon glyphicon-pencil"></i></a>';
                $btn .= '<a class="btn btn-danger btn-sm" href="'.URL::to('/courseclass_delete').'/'.$value->id.'"><i class="glyphicon glyphicon-trash"></i></a> ';
                $btn .= '<button type="button" class="btn btn-warning btn-sm" onclick="archiveThisLesson(1,'.$value->id.')">Archive</button>';
            
                $row['action'] = $btn;
                $data[] = $row;
            }
        }
        $output = array("data" => $data,);
		echo json_encode($output);
    }

    public function getCourseClassArchive($id)
    { 
        $data_cc = CourseClass::where(['coursechapter_id' => $id])->get();      
        $data = array();
        foreach ($data_cc as $value) {
            if($value->is_archive==1)
            {
                $row = array();
                $row['id'] = $value->id;
                $row['title'] = $value->title;
                $row['status'] = $value->status==1? 'Active':'Inactive';
                $btn = '';
                $btn .= '<a class="btn btn-success btn-sm" href="'.URL::to('/courseclass').'/'.$value->id.'"><i class="glyphicon glyphicon-pencil"></i></a>';
                $btn .= '<a class="btn btn-danger btn-sm" href="'.URL::to('/courseclass_delete').'/'.$value->id.'"><i class="glyphicon glyphicon-trash"></i></a> ';
                $btn .= '<button type="button" class="btn btn-warning btn-sm" onclick="archiveThisLesson(0,'.$value->id.')">Archive</button>';
            
                $row['action'] = $btn;
                $data[] = $row;
            }
        }
        $output = array("data" => $data,);
		echo json_encode($output);
    }

    

    public function archive(Request $request)
    {
        $q = CourseClass::find($request->id);
        if($request->archive==1){
            $q->is_archive = 1;
        }else{
            $q->is_archive = 0;
        }
        $q->save();
        echo 1;
    }

    public function getCourseChapters($id)
    { 
        $data= CourseChapter::where(['course_id' => $id])->get();      
		echo json_encode($data);
    }

    public function myCourses($user)
    {
        $q = Order::where(['user_id'=>$user,'status'=>1])->get();
        return $q;
    }

    public function joinNowView()
    {  
        return view('join');    
    }

    /* public function SavePartner(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new User;
        $c->fname = $request->fname;
        $c->lname = $request->lname;
        $c->email = $request->email;
        $c->password =Hash::make($request->password);
        $c->role = "Employer";        
        $c->save();
        return true;   
    } */

    protected function SavePartner(Request $request)
    {
        $setting = Setting::first();

        
        if($setting->verify_enable == 0)
        {
            $verified = \Carbon\Carbon::now()->toDateTimeString();
        }
        else
        {
            $verified = NULL;
        }
        
        
        $user = User::create([

            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'role' => 'employer',
            'email_verified_at'  => $verified,
            'password' => Hash::make($request->password),
        ]);
        

        if($setting->w_email_enable == 1){
            try{
               
                Mail::to($request->email)->send(new WelcomeUser($user));
               
            }
            catch(\Swift_TransportException $e){

            }
        }

        Auth::loginUsingId($user->id);
        return Redirect::to('/');

        //return $user;
    }
}
