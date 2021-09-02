<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseAnnouncement;
use Auth;

class AnnouncementTblController extends Controller
{
    public function Save(Request $request)
    {

    //dd($request);exit;
        if($request->aid){
            CourseAnnouncement::where(['id' => $request->aid])->update([
                'text' => $request->announcement,        
                'status' => $request->status,
            ]);
         //   echo 1;
        }else{
            $c = new CourseAnnouncement;
            $c->text = $request->announcement;
            $c->status = $request->status;
            $c->created_by = Auth::user()->id;
            $c->created_dt = date("Y-m-d H:i");
            $c->save();
        }  

        return redirect('announcement_instructor');
    }

    public function getJournal($id)
    { 
        $data = CourseAnnouncement::where(['id' => $id])->first();      
        echo json_encode($data);
    }

    public function loadView()
    {
        $topic = CourseAnnouncement::all();
        //$quizes = Quiz::where('topic_id', $topic->id)->get();
        return view('admin.announcement.index', compact('topic'));
    }

    public function loadinstructorView()
    {
        $topic = CourseAnnouncement::all();
        return view('instructor.announcement_board.index', compact('topic'));
    }

    
}
