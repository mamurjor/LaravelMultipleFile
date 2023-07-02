<?php

namespace App\Http\Controllers;
use App\MOdels\File;

use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function index()
    {
        return view('fileUpload');
    }

 public function store(Request $request)
    {
        $request->validate([
            'files' => 'required',
           'files.*' => 'required|mimes:jpeg,jpg,gif|max:2048',
        ]);
      
        $files = [];

        if ($request->file('files')){

            foreach($request->file('files') as $key => $file)
            {

                $fileName = time().rand(1,99).'.'.$file->extension();  
                $file->move(public_path('uploads'), $fileName);
                $files[]['name'] = $fileName;

            }
        }
  
        foreach ($files as $key => $file) {
            File::create($file);
        }
     
        return back()
                ->with('success','You have successfully upload file.');
   
    }
}
