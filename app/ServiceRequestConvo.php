<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestConvo extends Model
{
    protected $table = 'service_offer_convo';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'service_id',
    	'sender',
    	'message',
    	'sent_dt',
    ];
}
