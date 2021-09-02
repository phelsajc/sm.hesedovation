<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsSkills extends Model
{
    protected $table = 'job_skills';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'job_id',
    	'skills',
    ];
}
