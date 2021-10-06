<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseLessonProgress;
use App\CourseChapter;
use Auth;

class CourseLessonProgressController extends Controller
{
    public function checked(Request $request, $lid, $cid)
	{

		$progress = CourseLessonProgress::where(['lesson_id'=>$lid,'course_id'=>$cid,'user_id'=>Auth::User()->id])->first();

		if(!$progress){
			CourseLessonProgress::create([
				'course_id' => $cid,
				'lesson_id' => $lid,
				'user_id' => Auth::User()->id,
				'completed_dt' => date("Y-m-d H:i"),
				]
			);
		}		    
		echo true;
        //return back(); 
	}
}
