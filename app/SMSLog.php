<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    protected $table = 'sms_logs';
    
    protected $fillable = [
        'phonenumber',
        'name',
        'time_sent',
        'status'
    ];
}
