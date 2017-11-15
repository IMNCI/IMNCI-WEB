<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CounselSubContent extends Model
{
    //
    protected $fillable = ["sub_content_title", "content", "counsel_titles_id"];

    public function title(){
    	return $this->belongsTo('App\CounselTitles');
    }
}
