<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $table = 'job';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'title',
    	'level',
    	'time_frame',
    	'type_of_freelancers',
    	'freelnacers_language_lvl',
    	'cost',
    	'expiry_dt',
    	'details',
    	'location',
    	'is_featured',
    	'employer_id',
    	'created_dt',
    	'updated_dt',
    ];
}
