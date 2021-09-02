<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembers extends Model
{
    protected $table = "tbl_grp_members";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'type',
        'grp_id',
        'user_id',
        'course_id',
    ];
}
