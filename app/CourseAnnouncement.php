<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseAnnouncement extends Model
{
	protected $table = 'course_announcement';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','text', 'status', 'created_by', 'created_dt' ];
}
