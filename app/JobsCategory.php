<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsCategory extends Model
{
    protected $table = 'job_categories';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'job_id',
    	'categories',
    ];
}
