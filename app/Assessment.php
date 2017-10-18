<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $fillable = ['age_group_id', 'category_id', 'title', 'assessment'];
}
