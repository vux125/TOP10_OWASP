<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function viewFileUpload()
    {
        return view('fileuploads.index');
    }

    public function fileUpload(Request $req)
    {
        $file = $req->file('image');
        $type = $file->getClientMimeType();
        if ($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/jpg' && $type != 'image/gif') {
            return view('fileuploads.index', ['error' => 'File type not allowed ']);
        }
        $filePath = $file->getRealPath();
        $fileContent = file_get_contents($filePath, false, null, 0, 8);
        if (substr($fileContent, 0, 3) != "\xFF\xD8\xFF" || substr($fileContent, 0, 4) != "GIF8" || substr($fileContent, 0, 8) != "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A") {
            return view('fileuploads.index', ['error' => 'Not a valid image file']);
        }
        $filename = $file->getClientOriginalName() . time();
        $file->move('uploads', $filename);
        $url = url('uploads/' . $filename);
        return view('fileuploads.index', ['success' => 'File uploaded successfully', 'url' => $url]);
    }
}
