<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DocumentationController extends Controller
{
    function index(){
        return view('dashboard/documentation/index');
    }

    function thumbnailTest(){
        $files = Storage::files('gallery');
        $file_url = Storage::url($files[0]);
        
        $im = new \Imagick($file_url[0]);

        $im->setImageFormat('jpeg');
        header('Content-Type: image/jpeg');
        echo $im;
    }
}
