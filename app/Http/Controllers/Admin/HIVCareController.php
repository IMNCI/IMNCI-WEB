<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HIVCare;
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
	    }else{
	    	$this->validate($request, ['title'=>'required']);
	    	$hivCare = HIVCare::findOrFail($request->id);

	    	$hivCare->title = $request->title;
	    	if ($request->thumb != "") {
	    		$hivCare->thumbnail = $request->thumb;
	    		$hivCare->image_path = $request->hiv_care_screenshot->store('hiv_care');
	    	}
	    }

	    $hivCare->save();

    	return redirect('hiv-care')->with('status', 'Successfully saved !');
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
