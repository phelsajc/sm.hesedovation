<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobServiceCategory extends Model
{
    protected $table = 'job_services_category';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'category',
    ];
}
