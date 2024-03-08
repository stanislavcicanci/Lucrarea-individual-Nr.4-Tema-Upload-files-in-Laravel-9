<?php

use ErlandMuchasaj\LaravelFileUploader\FileUploader;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// visualize the form
Route::get('/files', function (Request $request) {
    return view('files');
})->name('files');

// handle the post request
Route::post('/files', function (Request $request) {

    $max_size = (int) ini_get('upload_max_filesize') * 1000;

    $extensions = implode(',', FileUploader::images());

    $request->validate([
        'file' => [
            'required',
            'file',
            'image',
            'mimes:' . $extensions,
            'max:'.$max_size,
        ]
    ]);

    $file = $request->file('file');

    $response = FileUploader::store($file);

    return redirect()
            ->back()
            ->with('success','File has been uploaded.')
            ->with('file', $response);
})->name('files.store');