<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use App\Course;
use App\QuizTopic;
use App\QuizAnswer;
use File;
use Image;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cor = Course::all();
        $topics = QuizTopic::all();
        $questions = Quiz::all();
        return view('admin.course.quiz.index', compact('questions', 'topics', 'cor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $request->validate([
          'course_id' => 'required',
          'topic_id' => 'required',
          'question' => 'required',
          'a' => 'required',
          'b' => 'required',
          'c' => 'required',
          'd' => 'required',
          'answer' => 'required',
        ]); */

        $input = $request->all();
          //dd($request->file('question_img')==null);echo $request->file('question_img');exit;
          $image = '';
        if($request->file('question_img')!=null){
          if($file = $request->file('question_img')) 
          { 
            
            $path = 'images/quiz/';
  
            if(!file_exists(public_path().'/'.$path)) {
              
              $path = 'images/quiz/';
              File::makeDirectory(public_path().'/'.$path,0777,true);
            }    
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/quiz/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);
  
            //$input['question_img'] = $image;
            
          }
        }    
        
       // $input['answer_exp'] = $request->answer_exp;
        /* $input['type'] = $request->quiz_type;
        Quiz::create($input); */

        if($request->quiz_type=="mc")
        {
            $request->validate([
              'course_id' => 'required',
              'topic_id' => 'required',
              'mc_question' => 'required',
              'mc_a' => 'required',
              'mc_b' => 'required',
              'mc_c' => 'required',
              'mc_d' => 'required',
              'mc_answer' => 'required',
            ]);

            $q = new Quiz;
            $q->course_id = $request->course_id;
            $q->topic_id = $request->topic_id;
            $q->question = $request->mc_question;
            $q->a = $request->mc_a;
            $q->b = $request->mc_b;
            $q->c = $request->mc_c;
            $q->d = $request->mc_d;
            $q->answer = $request->mc_answer;
            $q->question_video_link = $request->question_video_link;
            $q->type = $request->quiz_type;
            $q->question_img = $image;
            $q->save();
        }

        if($request->quiz_type=="cb")
        {
            $request->validate([
              'course_id' => 'required',
              'topic_id' => 'required',
              'cb_question' => 'required',
              'cb_a' => 'required',
              'cb_b' => 'required',
              'cb_c' => 'required',
              'cb_d' => 'required',
              'cb_answer' => 'required',
            ]);

            $q = new Quiz;
            $q->course_id = $request->course_id;
            $q->topic_id = $request->topic_id;
            $q->question = $request->cb_question;
            $q->a = $request->cb_a;
            $q->b = $request->cb_b;
            $q->c = $request->cb_c;
            $q->d = $request->cb_d;
            $cnt = 1;
            for($i=0; $i < sizeof($request->cb_answer) ; $i++) { 
              if($i==0){
                $q->ans1 = $request->cb_answer[$i];
              }else if($i==1){
                $q->ans2 = $request->cb_answer[$i];
              }else if($i==2){
                $q->ans3 = $request->cb_answer[$i];
              }else if($i==3){
                $q->ans4 = $request->cb_answer[$i];
              }
              $cnt++;
            }
            $q->question_video_link = $request->question_video_link;
            $q->type = $request->quiz_type;
            $q->question_img = $image;
            $q->save();
        }

        if($request->quiz_type=="pg")
        {
            $request->validate([
              'course_id' => 'required',
              'topic_id' => 'required',
              'pg_question' => 'required',
            ]);

            $q = new Quiz;
            $q->course_id = $request->course_id;
            $q->topic_id = $request->topic_id;
            $q->question = $request->pg_question;
            $q->question_video_link = $request->question_video_link;
            $q->type = $request->quiz_type;
            $q->question_img = $image;
            $q->save();
        }

        if($request->quiz_type=="sa")
        {
            $request->validate([
              'course_id' => 'required',
              'topic_id' => 'required',
              'sa_question' => 'required',
            ]);

            $q = new Quiz;
            $q->course_id = $request->course_id;
            $q->topic_id = $request->topic_id;
            $q->question = $request->sa_question;
            $q->question_video_link = $request->question_video_link;
            $q->type = $request->quiz_type;
            $q->question_img = $image;
            $q->save();
        }

        if($request->quiz_type=="sc")
        {
            $request->validate([
              'course_id' => 'required',
              'topic_id' => 'required',
              'sc_question' => 'required',
            ]);

            $q = new Quiz;
            $q->course_id = $request->course_id;
            $q->topic_id = $request->topic_id;
            $q->question = $request->sc_question;
            $q->a = "True";
            $q->b = "False";
            $q->answer = $request->sc_answer;
            $q->question_video_link = $request->question_video_link;
            $q->type = $request->quiz_type;
            $q->question_img = $image;
            $q->save();
        }

        return back()->with('success', trans('flash.AddedSuccessfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = QuizTopic::findOrFail($id);
        $quizes = Quiz::where('topic_id', $topic->id)->get();
        return view('admin.course.quiz.index', compact('topic', 'quizes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = QuizTopic::findOrFail($id);
        $editquizes = Quiz::where('$id', $topic->id)->get();
        return view('admin.course.quiz.index', compact('topic', 'quizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Quiz::findOrFail($id);
        $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'a' => 'required',
          'b' => 'required',
          'c' => 'required',
          'd' => 'required',
          'answer' => 'required',
        ]);

        $input = $request->all();

        if($file = $request->file('question_img')) 
        { 
          
          $path = 'images/quiz/';

          if(!file_exists(public_path().'/'.$path)) {
            
            $path = 'images/quiz/';
            File::makeDirectory(public_path().'/'.$path,0777,true);
          }    
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/quiz/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $input['question_img'] = $image;
          
        }


        
        $input['answer_exp'] = $request->answer_exp;
        $question->update($input);
        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Quiz::findOrFail($id);
        $question->delete();

        QuizAnswer::where('question_id', $id)->delete();

        return back()->with('delete', trans('flash.DeletedSuccessfully'));
    }
}
