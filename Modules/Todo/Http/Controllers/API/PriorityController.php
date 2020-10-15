<?php

namespace Modules\Todo\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Todo\Entities\Priority;
use Exception;
class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $priorities = Priority::where('status',1)->get();
            return [
                'data' => $priorities,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];

        } catch ( Exception $e ) {
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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
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
