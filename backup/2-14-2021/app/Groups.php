<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = "tbl_groupings";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'course_id',
    ];
}
