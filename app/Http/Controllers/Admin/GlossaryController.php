<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlossaryController extends Controller
{
    //
    public function index()
    {
    	return view('dashboard/glossary/index');
    }
}
