<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    //
    protected $fillable = ['email', 'phone', 'gender', 'age_group', 'county', 'profession', 'cadre', 'sector', 'phone_id'];
}
