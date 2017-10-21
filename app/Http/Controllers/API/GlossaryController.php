<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Glossary;

class GlossaryController extends Controller
{
    //
    public function store(Request $request){
    	$id = $request->input('id');

    	if ($id == 0) {
    		unset($_POST['id']);
    		return Glossary::create($request->all());
    	}

    	$glossary = Glossary::find($id);

    	$glossary->acronym = $request->input('acronym');
    	$glossary->description = $request->input('description');

    	$glossary->save();

    	return $glossary;
    }

    public function delete(Request $request){
    	$id = $request->id;

    	Glossary::destroy($id);

    	return [
    		'status'	=>	true
    	];
    }
}
