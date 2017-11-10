<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CounselTitles extends Model
{
    protected $fillable = ["title", "is_parent", "content", "age_group_id"];
}
