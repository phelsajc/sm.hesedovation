<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delete_messages extends Model
{
	protected $table = 'delete_messages';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','module', 'text', 'created_by', 'created_dt', ];
}
