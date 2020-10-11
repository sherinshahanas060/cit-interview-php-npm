<?php

namespace Modules\Cms\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Entities\BlogBlog;
use Carbon\Carbon;
use Storage;

class BlogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Cms');
        $this->middleware('permission:blog-list', ['only' => ['index']]);
        $this->middleware('permission:blog-create', ['only' => ['store']]);
        $this->middleware('permission:blog-edit', ['only' => ['update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
        $this->middleware('permission:blog-view', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $columns = ['id', 'title', 'created_at'];

            $lenght = $request->input('length');
            $column = $request->input('column');
            $searchByColumn = $request->input('searchColumnVal');
            $searchColumn = $request->input('searchColumn');
            $dir = $request->input('dir');
            $searchValue = $request->input('search');

            $query = BlogBlog::select('id', 'title', 'created_at')
                ->where('status', \Config::get('utils_constants.STATUS_ACTIVE'))
                ->orderBy($columns[$column],
                    $dir);
            if($searchByColumn) {
                $query->where(function ($query) use ($searchByColumn, $searchColumn) {
                    $query->where($searchColumn, 'like', '%' . $searchByColumn . '%');
                });
            }
            if ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('title', 'like', '%' . $searchValue . '%');
                });
            }

            $data = $query->paginate($lenght);
            return ['data' => $data, 'draw' => $request->input('draw')];
        } catch (Exception $e) {
            return [
                'message' => 'error',
                'data' => $e->getMessage(),
                'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR')
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
        $this->validate($request, [
            'title' => ['required'],
            'content' => 'required',
            'image' => 'required',
        ]);
        try {

            $data = $request->all();
            $data['created_by'] = $request->user()->id;
            $blogImageName = '';

            // upload file if form has logo large file
            if ($request->get('image')) {
                $file = $request->get('image');
                $blogImageName = Carbon::now()->timestamp . '_' . $file;
                if (Storage::disk('file_temp')->exists('uploads/' . $file)) {

                    // move file from temp to phone book upload disk
                    Storage::disk('blog_uploads')->writeStream('image/' . $blogImageName, Storage::disk('file_temp')->readStream('uploads/' . $file));

                }
            }
            $data['image'] = $blogImageName;

            $blogId = BlogBlog::create($data)->id;
            return [
                'message' => 'Success',
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
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try{
            if ($id) {
                $blog = BlogBlog::where('id', $id)
                            ->first();
                return [
                    'data' => $blog,
                    'status' => \Config::get('utils_constants.SUCCESS')
                ];
            }
        } catch (Exception $e) {
            return [
                'message' => 'error',
                'data' => $e->getMessage(),
                'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR')
            ];
        }
    }

     /**
     * @author 
     * @data 
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function view($id)
    {
        try{
            if ($id) {
                $data = BlogBlog::where('id', $id)
                ->first();
                return [
                    'data' => $data,
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
                ];
            }
        } catch (Exception $e) {
            return [
                'message' => 'error',
                'data' => $e->getMessage(),
                'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR')
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
        $blog = BlogBlog::findOrFail($id);

        // validation
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        try {
            $data = $request->all();
            $userId = $request->user()->id;
            if ($blog) {
                $data['updated_by'] = $userId;
                $blogImageName = '';

            // upload file if form has logo large file
            if ($request->get('image') && $request->get('image') != $blog['image']) {
                $file = $request->get('image');
                $blogImageName = Carbon::now()->timestamp . '_' . $file;
                if (Storage::disk('file_temp')->exists('uploads/' . $file)) {

                    // move file from temp to phone book upload disk
                    Storage::disk('blog_uploads')->writeStream('image/' . $blogImageName, Storage::disk('file_temp')->readStream('uploads/' . $file));

                }
                $data['image'] = $blogImageName;
            }
                $blog->update($data);
                return [
                    'message' => 'Success',
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE'),
                ];
            } else {
                return [
                    'message' => 'error',
                    'status' => \Config::get('utils_constants.ERROR_NO_CONTENT'),
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $blog = BlogBlog::findOrFail($id);
            // update employee status to 0
            if ($blog) {
                $blog->status = 0;
                $blog->save();
            }
            return [
                'message' => 'Success',
                'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
