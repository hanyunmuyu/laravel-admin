<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $dir = 'public/' . date('Y-m-d');
        $path = $request->file('file')->store($dir);
        return [
            'name' => '',
            'status' => 'done',
            'url' => asset('storage' . ltrim($path, 'public')),
            'thumbUrl' => ''
        ];
    }
}
