<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom_section;
use Auth;
use App\Categories;
use App\Course;
use App\Blog;

class CustomSectionController extends Controller
{
    public function Save(Request $request)
    {
        $getCat = '';
        if($request->cat){
            foreach ($request->cat as $key => $value) {
                $getCat .= $value.'|';
            }
        }
        if($request->aid){
            Custom_section::where(['id' => $request->aid])->update([
                'title' => $request->section,        
                'display_by' => substr($getCat, 0, -1),
                'created_dt' => date("Y-m-d H:i"),
                'created_by' => Auth::user()->id,
                'category' => $request->filterby,
                'status' => $request->status,
            ]);
        }else{
            $c = new Custom_section;
            $c->title = $request->section;
            $c->display_by = substr($getCat, 0, -1);
            $c->created_by = Auth::user()->id;
            $c->created_dt = date("Y-m-d H:i");
            $c->category =$request->filterby;
            $c->status =$request->status;
            $c->save();
        }  
        return redirect('custom_section');
    }

    public function show($id)
    {
       return Custom_section::where(['id'=>$id])->first();
    }

    public function getJournal($id)
    { 
        $data = Custom_section::where(['id' => $id])->first();      
        echo json_encode($data);
    }

    public function loadView()
    {
        $topic = Custom_section::all();
        return view('admin.custom_section.index', compact('topic'));
    }

    public function loadinstructorView()
    {
        $topic = Custom_section::all();
        return view('instructor.announcement_board.index', compact('topic'));
    }
}
