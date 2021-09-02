<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custom_section extends Model
{
	protected $table = 'custom_section';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','title', 'display_by', 'created_by', 'created_by', 'updated_dt' ];
}
