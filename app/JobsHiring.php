<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsHiring extends Model
{
    protected $table = 'jobs_hired';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'user_id',
    	'job_id',
    	'remarks',
    	'hired_dt',
    	'employer_id',
    ];
}
