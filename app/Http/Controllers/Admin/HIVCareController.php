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
		$data['parents'] = HIVCareParent::all(['id', 'parent_name']);

		// echo "<pre>";print_r(HIVCareParent::pluck('parent_name', 'id'));die;
		
    	return view('dashboard.hiv_care.index')->with($data);
    }

    function store(Request $request){
    	if($request->id == 0){
    		$this->validate($request, ['title'=>'required', 'hiv_care_screenshot' => "required|image|mimes:jpeg,bmp,png"]);
	    	$filename = $request->hiv_care_screenshot->store('hiv_care');
	    	$hivCare = new HIVCare();

	    	$hivCare->title = $request->title;
	    	$hivCare->thumbnail = $request->thumb;
			$hivCare->image_path = $filename;
			$hivCare->parent_id = $request->parent_id;
	    }else{
	    	$this->validate($request, ['title'=>'required']);
	    	$hivCare = HIVCare::findOrFail($request->id);

			$hivCare->title = $request->title;
			$hivCare->parent_id = $request->parent_id;
	    	if ($request->thumb != "") {
	    		$hivCare->thumbnail = $request->thumb;
	    		$hivCare->image_path = $request->hiv_care_screenshot->store('hiv_care');
	    	}
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
