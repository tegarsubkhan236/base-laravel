<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename =  $file->getClientOriginalName();
            $folder = uniqid('', false) . '-' . now()->timestamp;
            $file->storeAs('/public/avatars/tmp'. $folder , $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename
            ]);

            return $file;
        }
        return '';
    }
}