<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsApplication extends Model
{
    protected $table = 'job_applied';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'user_id',
    	'job_id',
    	'message',
    	'date_applied',
    	'subject',
    ];
}
