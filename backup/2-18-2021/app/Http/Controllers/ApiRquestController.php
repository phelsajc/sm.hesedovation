<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseJournal;

class ApiRquestController extends Controller
{
    public function SaveJournal(Request $request)
    {
        if($request->jid){
            CourseJournal::where(['id' => $request->jid])->update([
                'content' => $request->content,        
                'update_dt' => time(),
            ]);
            echo $request->jid;
        }else{
            $c = new CourseJournal;
            $c->content = $request->content;
            $c->lesson_id = $request->lid;
            $c->user_id = $request->userid;
            $c->course_id = $request->cid;
            $c->created_dt = time();
            $c->save();
            echo $c->id;
        }  
    }

    public function getJournal($id)
    { 
        $data = CourseJournal::where(['id' => $id])->first();      
        echo json_encode($data);
    }
}
