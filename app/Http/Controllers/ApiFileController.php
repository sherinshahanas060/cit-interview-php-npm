<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

class ApiFileController
{
    public function getFile(Request $request)
    {
        try {
            $file = $request->name;
            $diskName = $request->d;

            switch ($diskName) {
                case 'blog':
                    $disk = 'blog_uploads';
                    break;
                case 'course':
                    $disk = 'eventcourse_uploads';
                    break;
                case 'news':
                    $disk = 'cms_uploads';
                    break;
                case 'user':
                    $disk = 'user_uploads';
                    break;
                case 'gallery':
                    $disk = 'gallery_uploads';
                    break;
                default:
                    $disk = '';
                    break;
            }

            $ext = File::extension($file);
            // check file exist and name is a file
            if (Storage::disk($disk)->exists($file) && $ext) {
                if ($ext == 'pdf') {
                    $content_types = 'application/pdf';
                } elseif ($ext == 'doc') {
                    $content_types = 'application/msword';
                } elseif ($ext == 'docx') {
                    $content_types = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                } elseif ($ext == 'xls') {
                    $content_types = 'application/vnd.ms-excel';
                } elseif ($ext == 'xlsx') {
                    $content_types = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                } elseif ($ext == 'txt') {
                    $content_types = 'application/octet-stream';
                } else {
                    return response()->download(Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file));
                }

                return response(file_get_contents(Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file)), 200)
                    ->header('Content-Type', $content_types);

            } else {
                return response()->download(public_path("img/noimage.png"), null, [], null);
            }

        } catch (Exception $e) {
            return response()->download(public_path("img/noimage.png"), null, [], null);
        }

    }

    
}
