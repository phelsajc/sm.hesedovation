<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseJournal;
use App\Course;
use App\CourseChapter;
use App\Order;
use App\User;
use Auth;

//my perosnal controller
class ApiCustomController extends Controller
{
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
        return view('admin.course.progressDetailStudent',compact('course_data', 'course_journal', 'user_id' ));    
    }
}
