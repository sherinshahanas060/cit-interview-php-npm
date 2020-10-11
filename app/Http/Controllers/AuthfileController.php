<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Storage;
use Auth;
use File;
/**
 * TODO :
 * - Download from disk
 * - Default disk config
 * - Optional disk paramter in request
 */
class AuthfileController
{
	public function getFile(Request $request)
	{
        try {
            $file = $request->name;
            $disk = $request->disk;
            if(Auth::check()){
                $ext =File::extension($file);
                // check file exist and name is a file
                if(Storage::disk($disk)->exists($file) && $ext){
                    
                    if($ext=='pdf'){
                        $content_types='application/pdf';
                    }elseif ($ext=='doc') {
                        $content_types='application/msword';  
                    }elseif ($ext=='docx') {
                        $content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';  
                    }elseif ($ext=='xls') {
                        $content_types='application/vnd.ms-excel';  
                    }elseif ($ext=='xlsx') {
                        $content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';  
                    }elseif ($ext=='txt') {
                        $content_types='application/octet-stream';  
                    } else {
                        return response()->download(Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file));
                    }
                    
                    return response(file_get_contents(Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file)),200)
                            ->header('Content-Type',$content_types);
                    
                }else{
                    return response()->download(public_path("img/noimage.png"), null, [], null);
                }
            }else{
                return response()->download(public_path("img/noimage.png"), null, [], null);
            }
        } catch ( Exception $e ) {
            return response()->download(public_path("img/noimage.png"), null, [], null);
        }
        
	}
}