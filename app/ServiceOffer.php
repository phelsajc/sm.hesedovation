<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOffer extends Model
{
	protected $table = 'service_offer';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','title', 'details', 'fee', 'user_id', 'created_dt', 'update_dt' ];
}
