<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnIns extends Model
{
    protected $table = " ann_ins";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'announcement',
        'status',
    ];
}
