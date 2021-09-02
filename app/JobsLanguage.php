<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsLanguage extends Model
{
    protected $table = 'job';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'job_id',
    	'language',
    ];
}
