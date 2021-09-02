<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsApplicationConvo extends Model
{
    protected $table = 'job_applied_convo';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'job_id',
    	'sender',
    	'message',
    	'sent_dt',
    ];
}
