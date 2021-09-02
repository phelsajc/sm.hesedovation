<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobMasterSkills extends Model
{
    protected $table = 'job_master_skills';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'skills',
    ];
}
