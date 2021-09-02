<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'service_request';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'service_id',
    	'employer_id',
    	'applied_dt',
    	'message',
    	'subject',
    ];
}
