<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobsAttatchments extends Model
{
    protected $table = 'job_attachments';

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [ 
    	'job_id',
    	'location',
    	'file',
    ];
}
