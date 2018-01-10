<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\GalleryItem;
use App\GalleryAilment;
use App\Gallery;

use Illuminate\Http\Response;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    function index(Request $request){
    	$data = [];

    	if (isset($request->id)) {
    		$data['ailment_id'] = $request->id;
    		$data['ailment'] = GalleryAilment::findOrFail($request->id);
    		$gallery = Gallery::where('gallery_ailments_id', $request->id)->get();
    	}else{
    		$gallery = Gallery::all();
    	}
    	$data['gallery'] = $this->cleanGallery($gallery);
    	$data['galleryitems'] = GalleryItem::all();
    	$data['ailments'] = GalleryAilment::all();
    	return view('dashboard.gallery.index')->with($data);
    }

    function store(Request $request){
        $this->validate($request, [
            'gallery_items_id'      =>  'required',
            'gallery_ailments_id'   =>  'required',
            'title'                 =>  'required',
        ]);
        $input = $request->input();

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $thumbnail = "TBA";

        $destinationPath = public_path('gallery');

        $path = \Storage::disk('public')->put('gallery', $file);

        $gallery = new Gallery();

        $type = $this->getTypeFromMime($file->getMimeType());

        if (!$type) {
            $type = "N/A";
        }

        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->gallery_ailments_id = $request->input('gallery_ailments_id');
        $gallery->gallery_items_id = $request->input('gallery_items_id');
        $gallery->thumbnail = $thumbnail;
        $gallery->mime = $file->getMimeType();
        $gallery->link = $path;
        $gallery->size = $file->getSize();
        $gallery->type = $type;

        $gallery->save();

        return back()
                ->with('success', "Successfully uploaded file")
                ->with('url', route('getFile', $gallery->id));
    }

    function update(Request $request){
       $id = $request->input('gallery_id');
       $gallery = Gallery::findOrFail($id);
       $path = $gallery->link;
       $mime = $gallery->mime;
       $size = $gallery->size;
       $thumbnail = "TBA";
       $type = $gallery->type;
       $file = $request->file('file');
       if ($file) {
            $extension = $file->getClientOriginalExtension();

            $destinationPath = public_path('gallery');

            $path = \Storage::disk('public')->put('gallery', $file);

            $type = $this->getTypeFromMime($file->getMimeType());

            if (!$type) {
                $type = "N/A";
            }

            $size = $file->getSize();
            $mime = $file->getMimeType();
       }

        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->gallery_ailments_id = $request->input('gallery_ailments_id');
        $gallery->gallery_items_id = $request->input('gallery_items_id');
        $gallery->thumbnail = $thumbnail;
        $gallery->mime = $mime;
        $gallery->link = $path;
        $gallery->size = $size;
        $gallery->type = $type;

        $gallery->save();

        return back()
                ->with('success', "Successfully updated gallery item")
                ->with('url', route('getFile', $gallery->id));
    }

    function cleanGallery($gallery){
    	$cleaned_gallery = [];
    	$galleryitems = GalleryItem::all();
    	foreach ($galleryitems as $item) {
    		if (count($gallery)) {
    			foreach ($gallery as $g) {
                    if ($g->gallery_items_id == $item->id) {
                        $cleaned_gallery[$item->id][] = $g;
                    }
    			}

                if (!array_key_exists($item->id, $cleaned_gallery)) {
                    $cleaned_gallery[$item->id] = [];
                }
    		}else{
    			$cleaned_gallery[$item->id] = [];
    		}
    	}

    	return $cleaned_gallery;
    }

    function getFile(Request $request){
        $gallery = Gallery::findOrFail($request->id);

        $file = \Storage::disk('public')->get($gallery->link);

        return (new Response($file, 200))
                ->header('Content-Type', $gallery->mime);
    }

    function getTypeFromMime($mime){
        $mimeArray = [
            'Spreadsheet'   =>  [
                "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            ],
            "Word Document" =>  [
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/msword"
            ],
            "Presentation"  =>  [
                "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            ],
            "PDF"           =>  [
                "application/pdf"
            ]
        ];

        if (substr($mime, 0, 5) == "image") {
            return "Image";
        }else{
            foreach ($mimeArray as $type => $mimes) {
                if (array_search($mime, $mimes) !== false) {
                    return $type;
                }
            }
            return false;
        }
    }
}
