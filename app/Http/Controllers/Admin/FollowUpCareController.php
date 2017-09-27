<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgeGroup;
use App\FollowUpCareAdvice;

class FollowUpCareController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	function index(){
		$age_groups = AgeGroup::get();
		$age_groups_select = [];
		foreach ($age_groups as $group) {
			$age_groups_select[$group->id] = $group->age_group;
		}
		$data['age_groups'] = $age_groups_select;
		return view('dashboard/followup/index')->with($data);
	}
}
