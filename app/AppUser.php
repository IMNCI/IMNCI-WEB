<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $fillable = ["phone_id", "opened_at", "brand", "model", "device", 'android_version', 'display_no', 'android_sdk', 'android_release', 'device_model'];
}
