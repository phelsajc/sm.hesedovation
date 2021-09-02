<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseJournal;
use App\Course;
use App\CourseChapter;
use Auth;

//my perosnal controller
class ApiCustomController extends Controller
{
    public function SaveJournal(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        //dd($request->cid);exit;
        $checkJournal = CourseJournal::where(['id' => $request->jid])->first();
        if($checkJournal){
            CourseJournal::where(['id' => $request->jid])->update([
                'content' => $request->content,        
                'update_dt' => time(),
            ]);
            echo $request->jid; 
        }else{
            //echo true;exit;
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
        $data = CourseJournal::where(['class_id' => $id])->first();
        echo json_encode($data);
    }

    public function progressPage()
    {
        $course = Course::all();
        $coursechapter = CourseChapter::all();           
        return view('admin.course.progress',compact("course",'coursechapter'));
    }

    public function courseClassProgress()
    {   
        /* $course = Course::all();
        
        $cor = Course::findOrFail($id);
       
        $courseinclude = CourseInclude::where('course_id','=',$id)->get();
        $coursechapter = CourseChapter::where('course_id','=',$id)->orderBy('position','ASC')->get();
        $whatlearns = WhatLearn::where('course_id','=',$id)->get();
        $coursechapters = CourseChapter::where('course_id','=',$id)->orderBy('id','ASC')->get();
        $relatedcourse = RelatedCourse::where('main_course_id','=',$id)->get();
        $courseclass = CourseClass::where('course_id','=',$id)->orderBy('position','ASC')->get();
        $announsments = Announcement::where('course_id','=',$id)->get();
        $reports = ReportReview::where('course_id','=',$id)->get();
        $questions = Question::where('course_id','=',$id)->get();
        $answers = Answer::where('course_id','=',$id)->get();
        $quizes = Quiz::where('course_id','=',$id)->get();
        $topics = QuizTopic::where('course_id','=',$id)->get();
        $appointment = Appointment::where('course_id','=',$id)->get();
        return view('admin.course.show',compact('cor','course','courseinclude','whatlearns','coursechapters','coursechapter',
        'relatedcourse','courseclass', 'announsments', 'answers', 'reports', 'questions', 'quizes', 'topics', 'appointment' )); */
        return view('admin.course.progressDetail');
    
    }
}
