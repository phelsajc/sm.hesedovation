<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
	protected $table = 'quiz_answers';

    protected $fillable = ['course_id', 'topic_id', 'user_id', 'question_id', 'user_answer', 'answer', 'ans1', 'ans2', 'ans3', 'ans4', 'points', 'custom_answer'];

    public function quiz()
    {
        return $this->belongsTo('App\Quiz','question_id','id');
    } 
}
