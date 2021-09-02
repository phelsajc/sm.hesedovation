<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseJournal extends Model
{
	protected $table = 'course_journal';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','content', 'class_id', 'user_id', 'course_id', 'created_dt', 'update_dt' ];
}
