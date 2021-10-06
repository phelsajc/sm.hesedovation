<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseLessonProgress extends Model
{
    protected $table = 'course_lesson_progress';

    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [ 
    	'id',
    	'user_id',
    	'lesson_id',
    	'course_id',
    	'completed_dt',
    ];
}
