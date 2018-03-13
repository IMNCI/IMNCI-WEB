<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HCWWorkers extends Model
{
    protected $table = 'hcw_workers';
    
    protected $fillable = [
        'hcw_name', 'county', 'mobile_number'
    ];
}
