<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HIVCare;
use App\HIVCareParent;
use App\Http\Requests\UploadImageRequest;

class HIVCareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    function index(){
		$data['hivcare'] = HIVCare::all();
		$data['parents'] = HIVCare::select('parent')->groupBy('parent')->get();

		// echo "<pre>";print_r(HIVCareParent::pluck('parent_name', 'id'));die;
		
    	return view('dashboard.hiv_care.index')->with($data);
    }

    function store(Request $request){
    	$this->validate($request, ['title'=>'required', 'parent' => "required", 'content' => 'required']);
    	if($request->id == 0){
    		$this->validate($request, ['title'=>'required', 'parent' => "required", 'content' => 'required']);
	    	$hivCare = new HIVCare();

	    	$hivCare->title = $request->title;
	    	$hivCare->parent = $request->parent;
			$hivCare->content = $request->content;
	    }else{
	    	$this->validate($request, ['title'=>'required']);
	    	$hivCare = HIVCare::findOrFail($request->id);

			$hivCare->title = $request->title;
	    	$hivCare->parent = $request->parent;
			$hivCare->content = $request->content;
	    }

	    $hivCare->save();

    	return redirect('hiv-care')->with('status', 'Successfully saved !');
	}
	
	function storeParent(Request $request){
		$this->validate($request, ['name'=>'required']);
		if($request->parent_id == 0)
			$parent = new HIVCareParent();
		else
			$parent = HIVCareParent::findOrFail($request->parent_id);

		$parent->parent_name = $request->name;

		$parent->save();

		return redirect('hiv-care')->with('status', 'Successfully added HIV Care Parent!');
	}

    function destroy(Request $request){
    	if ($request->id != "") {
    		HIVCare::destroy($request->id);
    		return redirect('hiv-care')->with('status', 'Successfully deleted !');
    	}else{
    		abort(404);
    	}
    }
}
