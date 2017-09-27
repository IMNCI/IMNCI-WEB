<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowUpCareAdvice extends Model
{
    protected $fillable = ["ailment_id", "advice"];
}
