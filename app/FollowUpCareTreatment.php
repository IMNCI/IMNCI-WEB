<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowUpCareTreatment extends Model
{
    protected $fillable = ["ailment_id", "treatment"];
}
