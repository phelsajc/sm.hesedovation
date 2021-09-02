<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuizTopic;
use App\QuizAnswer;
use Auth;
use App\Quiz;

class QuizStartController extends Controller
{
    public function quizstart($id)
    {
    	$topic = QuizTopic::findOrFail($id);
		$answers = QuizAnswer::where('topic_id','=',$topic->topic_id)->first();
		return view('front.quiz.main_quiz', compact('topic','answers'));
    }

    public function store(Request $request, $id)
    {
    	$topics=QuizTopic::where('id',$id)->first();
        $unique_question = array_unique($request->question_id);
      
        for ($i = 1; $i <= count($request->answer); $i++) {    

            if($request->type[$i]=="mc"){
                $answers[] = [
                    'user_id' => Auth::user()->id,
                    'user_answer' => $request->answer[$i],
                    'question_id' => $unique_question[$i],
                    'course_id'=>$topics->course_id,
                    'topic_id'=>$topics->id,
                    'answer'=>$request->canswer[$i],
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ];

                $qa = new QuizAnswer;
                $qa->user_id = Auth::user()->id;
                $qa->user_answer = $request->answer[$i];
                $qa->question_id = $unique_question[$i];
                $qa->course_id = $topics->course_id;
                $qa->topic_id = $topics->id;
                $qa->answer = $request->canswer[$i];
                $qa->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $qa->save();
            } 
            
            if($request->type[$i]=="cb")
            {
                $ans1 = null;
                $ans2 = null;
                $ans3 = null;
                $ans4 = null;
                for($j=0; $j < sizeof($request->answer[$i]) ; $j++) { 
                    if($j==0){
                        $ans1 = $request->answer[$i][$j];
                    }else if($j==1){
                        $ans2 = $request->answer[$i][$j];
                    }else if($j==2){
                        $ans3 = $request->answer[$i][$j];
                    }else if($j==3){
                        $ans4 = $request->answer[$i][$j];
                    }
                }
                /* $answers[] = [
                    'user_id' => Auth::user()->id,
                    'user_answer' => '',
                    'question_id' => $unique_question[$i],
                    'course_id'=>$topics->course_id,
                    'topic_id'=>$topics->id,
                    'answer'=>'',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    'ans1'=>$ans1,
                    'ans2'=>$ans2,
                    'ans3'=>$ans3,
                    'ans4'=>$ans4,
                ];   */              

                $qa = new QuizAnswer;
                $qa->user_id = Auth::user()->id;
                $qa->user_answer = '';
                $qa->question_id = $unique_question[$i];
                $qa->course_id = $topics->course_id;
                $qa->topic_id = $topics->id;
                $qa->answer = '';
                $qa->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $qa->ans1 = $ans1;
                $qa->ans2 = $ans2;
                $qa->ans3 = $ans3;
                $qa->ans4 = $ans4;
                $qa->save();
            } 
            
            if($request->type[$i]=="pg"){
                /* $answers[] = [
                    'user_id' => Auth::user()->id,
                    'user_answer' => $request->answer[$i],
                    'question_id' => $unique_question[$i],
                    'course_id'=>$topics->course_id,
                    'topic_id'=>$topics->id,
                    'answer'=>'',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]; */
                $qa = new QuizAnswer;
                $qa->user_id = Auth::user()->id;
                $qa->user_answer = $request->answer[$i];
                $qa->question_id = $unique_question[$i];
                $qa->course_id = $topics->course_id;
                $qa->topic_id = $topics->id;
                $qa->answer = '';
                $qa->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $qa->save();
            }

            if($request->type[$i]=="sa"){
                /* $answers[] = [
                    'user_id' => Auth::user()->id,
                    'user_answer' => $request->answer[$i],
                    'question_id' => $unique_question[$i],
                    'course_id'=>$topics->course_id,
                    'topic_id'=>$topics->id,
                    'answer'=>'',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]; */
                $qa = new QuizAnswer;
                $qa->user_id = Auth::user()->id;
                $qa->user_answer = $request->answer[$i];
                $qa->question_id = $unique_question[$i];
                $qa->course_id = $topics->course_id;
                $qa->topic_id = $topics->id;
                $qa->answer = '';
                $qa->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $qa->save();
            } 

            if($request->type[$i]=="sc"){
                /* $answers[] = [
                    'user_id' => Auth::user()->id,
                    'user_answer' => $request->answer[$i],
                    'question_id' => $unique_question[$i],
                    'course_id'=>$topics->course_id,
                    'topic_id'=>$topics->id,
                    'answer'=>'',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]; */
                $qa = new QuizAnswer;
                $qa->user_id = Auth::user()->id;
                $qa->user_answer = $request->answer[$i];
                $qa->question_id = $unique_question[$i];
                $qa->course_id = $topics->course_id;
                $qa->topic_id = $topics->id;
                $qa->answer = $request->canswer[$i];
                $qa->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $qa->save();
            } 
            
        }
        //QuizAnswer::insert($answers);
        
        
        return redirect()->route('start.quiz.show', $id);
           
    }

    public function show($id)
	{
        $auth = Auth::user();
        $topic = QuizTopic::where('id',$id)->get();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics=QuizTopic::where('id',$id)->first();
        $ans = QuizAnswer::where('user_id',$auth->id)
              ->where('topic_id',$id)->get(); 
        $ans_ans = array();

        $user_answer_array = array();
        $ca_answer_array = array();
        foreach ($ans as $key => $value) {
            $row = array();
            $row['answer'] = $value->answer;
            $row['user_answer'] = $value->user_answer;
            $q = Quiz::where('id', $value->question_id)->first();
            $row['type'] = $q->type;
            $row['ans_id'] = $value->id;
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
            $ans_ans[] = $row;
        }

        return view('front.quiz.finish', compact('auth','ca_answer_array','user_answer_array','topic','questions','count_questions','ans_ans','topics'));

	}

    public function tryagain($id)
    {
        QuizAnswer::where('topic_id',$id)->where('user_id', Auth::User()->id)->delete();

        return redirect()->route('start_quiz', $id);
    }
}
