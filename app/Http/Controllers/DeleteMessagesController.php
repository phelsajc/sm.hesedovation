<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Delete_messages;
use Auth;

class DeleteMessagesController extends Controller
{
    public function Save(Request $request)
    {
        if($request->aid){
            Delete_messages::where(['id' => $request->aid])->update([    
                'text' => $request->text,
            ]);
        }else{
            $c = new Delete_messages;
            $c->module = $request->module;
            $c->text = $request->text;
            $c->created_by = Auth::user()->id;
            $c->created_dt = date("Y-m-d H:i");
            $c->save();
        }  
        return redirect('deleted_messages');
    }

    public function show($id)
    {
       return Delete_messages::where(['id'=>$id])->first();
    }

    public function loadView()
    {
        $topic = Delete_messages::all();
        return view('admin.deleted_messages.index', compact('topic'));
    }

    
}
