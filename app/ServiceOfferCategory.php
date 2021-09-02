<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOfferCategory extends Model
{
    protected $table = 'service_offer_categories';

    protected $primaryKey = "id";

    public $timestamps = false;
	
    protected $fillable = [ 
    	'service_id',
    	'category',
    ];
}
