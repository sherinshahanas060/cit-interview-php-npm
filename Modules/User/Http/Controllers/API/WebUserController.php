<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:User');
        $this->middleware('permission:webuser-list', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $columns = ['id', 'firstName', 'lastName', 'email', 'mobile', 'userName'];

            $lenght = $request->input('length');
            $column = $request->input('column');
            $dir = $request->input('dir');
            $searchValue = $request->input('search');

            $query = DB::connection('mysql_web')
                ->table('Users')
                ->select('id', 'firstName', 'lastName', 'email', 'mobile', 'userName')
                ->orderBy($columns[$column],
                    $dir);

            if ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('email', 'like', '%' . $searchValue . '%')
                        ->orWhere('firstName', 'like', '%' . $searchValue . '%')
                        ->orWhere('lastName', 'like', '%' . $searchValue . '%');
                });
            }

            $users = $query->paginate($lenght);

            return ['data' => $users, 'draw' => $request->input('draw')];
        } catch (Exception $e) {
            return $e->getMessage();
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
