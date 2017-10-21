<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Glossary;

class GlossaryController extends Controller
{
    //
    public function index()
    {
    	$data['glossary'] = Glossary::all();
    	return view('dashboard/glossary/index')->with($data);
    }

    public function delete(Request $request){

    }
}
