<?php

namespace Modules\Report\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\AuthLog;
use Exception;
class LogreportController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:Report');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $columns = ['login_ip','name', 'address', 'lat', 'time_zone', 'created_at', 'logout_time', 'device_information', 'attempt_count', 'failure_reason'];

            $lenght = $request->input('length');
            $column = $request->input('column');
            $searchByColumn = $request->input('searchColumnVal');
            $searchColumn = $request->input('searchColumn');
            $dir = $request->input('dir');
            $searchValue = $request->input('search');
            
            $query = AuthLog::leftjoin('users', 'auth_logs.user_id', '=', 'users.id')
            ->select('auth_logs.id','auth_logs.login_ip','auth_logs.user_id', 'auth_logs.mac_id','users.name', 'users.id','auth_logs.address', 'auth_logs.lat', 'auth_logs.lon','auth_logs.time_zone','auth_logs.login_time','auth_logs.logout_time','auth_logs.device_information','auth_logs.attempt_count','auth_logs.failure_reason', 'auth_logs.created_at')
                ->orderBy($columns[$column],
                    $dir);
            if($searchByColumn) {
                $query->where(function ($query) use ($searchByColumn, $searchColumn) {
                    $query->where($searchColumn, 'like', '%' . $searchByColumn . '%');
                });
            }
            if ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('login_ip', 'like', '%' . $searchValue . '%')
                        ->orWhere('mac_id', 'like', '%' . $searchValue . '%')
                        ->orWhere('address', 'like', '%' . $searchValue . '%')
                        ->orWhere('lat', 'like', '%' . $searchValue . '%')
                        ->orWhere('lon', 'like', '%' . $searchValue . '%')
                        ->orWhere('time_zone', 'like', '%' . $searchValue . '%')
                        ->orWhere('login_time', 'like', '%' . $searchValue . '%')
                        ->orWhere('device_information', 'like', '%' . $searchValue . '%');
                });
            }
            $logs = $query->paginate($lenght);
            return ['data' => $logs, 'draw' => $request->input('draw')];
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
