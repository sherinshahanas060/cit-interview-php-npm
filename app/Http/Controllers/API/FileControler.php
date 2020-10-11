<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    // use WithoutMiddleware;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo '<pre>'; print_r(Storage::disk("file_temp"));
        // exit;
        if ($request->file('file')) {
            $file = $request->file('file');
            $name = str_replace(' ', '_', $file->getClientOriginalName());
            $mime = $file->getMimeType();
            Storage::disk("file_temp")->put('uploads/' . $name, File::get($file));

            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        } else {
            return response()->json(['error' => 'Failed to store file']);
        }
    }

    public function templateFileUpload(Request $request)
    {
        try {
            // echo '<pre>'; print_r($request->file('file'));exit;
            // $files = $request->file('file');
            // forEach($files as $file) {
            //     $name = str_replace(' ','_',$file->getClientOriginalName());
            //     Storage::disk("public_uploads")->put('grape/campaign/'.$name, File::get($file));
            //     // Storage::disk('public_uploads')->writeStream('grape/campaign/' .$file, Storage::disk('file_temp')->readStream('uploads/' . $file));
            // }
            $resultArray = array();
            $files = $request->file('files');
            if ($files) {
                foreach ($files as $file) {
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    Storage::disk("public_uploads")->put('grape/campaign/' . $name, File::get($file));
                    $path = Storage::disk('public_uploads')->path('grape/campaign/' . $name);
                    // url('/').'/uploads/grape/campaign/' .$name
                    $result = array(
                        'name' => $name,
                        'type' => 'image',
                        'src' => url('/') . '/uploads/grape/campaign/' . $name,
                        'height' => 350,
                        'width' => 250,
                    );
                    array_push($resultArray, $result);
                }
                return array('data' => $resultArray);
                // return response()->json(['success' => 'You have successfully uploaded an image'], 200);
            } else {
                return response()->json(['error' => 'Failed to store file']);
            }

        } catch (Exception $e) {
            return [
                'message' => 'error',
                'data' => $e->getMessage(),
                'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR'),
            ];
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}