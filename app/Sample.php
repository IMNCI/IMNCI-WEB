<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Sample extends Model
{
    //
    public $incrementing = false;
    protected $fillable = ['sample'];
}
