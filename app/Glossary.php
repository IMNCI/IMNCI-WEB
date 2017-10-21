<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Glossary extends Model
{
    //
    protected $fillable = ["acronym", "description"];
}
