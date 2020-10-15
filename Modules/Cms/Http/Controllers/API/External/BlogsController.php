<?php

namespace Modules\Cms\Http\Controllers\API\External;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Entities\BlogBlog;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $blogs = BlogBlog::select('id', 'title', 'created_at','image')
                ->where('status', \Config::get('utils_constants.STATUS_ACTIVE'))
                // ->with('tags.tag')
                ->get();
            return [
                'message' => 'Success',
                'data' => $blogs,
                'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE'),
            ];
        } catch (Exception $e) {
            return [
                'message' => 'error',
                'data' => $e->getMessage(),
                'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR'),
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            if ($id) {
                $blog = BlogBlog::where('id', $id)
                    // ->with('tags.tag')
                    ->first();
                return [
                    'data' => $blog,
                    'status' => \Config::get('utils_constants.SUCCESS'),
                ];
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
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
