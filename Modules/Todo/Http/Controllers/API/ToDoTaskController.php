<?php

namespace Modules\Todo\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Todo\Events\ToDoTaskCreated;
use Modules\Todo\Events\ToDoTaskRemoved;
use Modules\Todo\Events\ToDoTaskCompleted;
use Modules\Todo\Events\ToDoTaskForward;
use Modules\Todo\Entities\ToDoStatusList;
use Modules\Todo\Entities\ToDoTask;
use Modules\Todo\Entities\ToDoTaskAssign;
use Modules\Todo\Entities\ToDoTaskAction;
use Modules\Todo\Entities\Priority;
use Carbon\Carbon;
use Exception;
class ToDoTaskController extends Controller
{
    /**
     * @author Job
     * @date 31-08-19
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $searchQuery = json_decode($request->input('query', ''));
            if (is_object($searchQuery)) {
                $keyword = $searchQuery->keyword;
            } else {
                $keyword = "";
            }

            $query = ToDoTask::leftJoin('to_do_task_assigns', 'to_do_tasks.id', "=", "to_do_task_assigns.to_do_task_id")
                ->select('to_do_tasks.id', 'to_do_tasks.title', 'to_do_tasks.task_date', 'to_do_tasks.about', 'to_do_tasks.to_do_status_id', 'to_do_tasks.company_id', 'to_do_tasks.created_by', 'to_do_tasks.completed', 'to_do_tasks.type', 'to_do_tasks.priority_id', 'to_do_tasks.status', 'to_do_tasks.created_at', 'to_do_task_assigns.assigned_to')
                ->where('to_do_tasks.completed', 0)
                ->where('to_do_tasks.status', 1)
                ->where('to_do_task_assigns.assigned_to', $userId)
                ->where('to_do_tasks.title', 'LIKE', "%{$keyword}%")
                ->with('assigned.user.userDetails')
                ->with('toDoStatus')
                ->with('user.userDetails')
                ->with('priority')
                ->groupBy('to_do_tasks.id')
                ->groupBy('to_do_tasks.title')
                ->groupBy('to_do_tasks.about')
                ->groupBy('to_do_tasks.to_do_status_id')
                ->groupBy('to_do_tasks.company_id')
                ->groupBy('to_do_tasks.created_by')
                ->groupBy('to_do_tasks.completed')
                ->groupBy('to_do_tasks.type')
                ->groupBy('to_do_tasks.priority_id')
                ->groupBy('to_do_tasks.status')
                ->groupBy('to_do_tasks.task_date')
                ->groupBy('to_do_task_assigns.assigned_to')
                ->groupBy('to_do_tasks.created_at');

            $todoList = $query->orderBy('to_do_tasks.id', 'desc')
                ->get();
            $priorities = Priority::where('status', 1)->get();
            $sortedArray = array();
            $today = new \DateTime("now");
            $sortedArray['Totalcount'] = count($todoList);
            foreach ($priorities as $keypr => $valuepr) {
                $sortedArray[$valuepr->id] = array();
            }
            foreach ($todoList as $key => $value) {
                $taskdate = new \DateTime($value->task_date);
                $interval = $today->diff($taskdate);
                foreach ($priorities as $keypr => $valuepr) {
                    if ($interval->format("%r%a") <= $valuepr->days) {
                        $sortedArray[$valuepr->id][] = $value;
                        break;
                    }
                }
            }
            return [
                'data' => $sortedArray,
                // 'completedCount' => $completedCount,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function teamtaskIndex(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $query = ToDoTask::leftJoin('to_do_task_assigns', 'to_do_tasks.id', "=", "to_do_task_assigns.to_do_task_id")
                ->select('to_do_tasks.id', 'to_do_tasks.title', 'to_do_tasks.task_date', 'to_do_tasks.about', 'to_do_tasks.to_do_status_id', 'to_do_tasks.company_id', 'to_do_tasks.created_by', 'to_do_tasks.completed', 'to_do_tasks.type', 'to_do_tasks.priority_id', 'to_do_tasks.status', 'to_do_tasks.created_at', 'to_do_task_assigns.assigned_to')
                ->where('to_do_tasks.completed', 0)
                ->where('to_do_tasks.status', 1)
                ->where('to_do_tasks.type', '!=', 1)
                ->with('assigned.user.userDetails')
                ->with('toDoStatus')
                ->with('user.userDetails')
                ->with('priority')
                ->groupBy('to_do_tasks.id')
                ->groupBy('to_do_tasks.title')
                ->groupBy('to_do_tasks.about')
                ->groupBy('to_do_tasks.to_do_status_id')
                ->groupBy('to_do_tasks.company_id')
                ->groupBy('to_do_tasks.created_by')
                ->groupBy('to_do_tasks.completed')
                ->groupBy('to_do_tasks.type')
                ->groupBy('to_do_tasks.priority_id')
                ->groupBy('to_do_tasks.status')
                ->groupBy('to_do_tasks.task_date')
                ->groupBy('to_do_task_assigns.assigned_to')
                ->groupBy('to_do_tasks.created_at');
            $searchQuery = json_decode($request->input('query', ''));
            if (is_object($searchQuery)) {
                $query->where('to_do_tasks.title', 'LIKE', "%{$searchQuery->keyword}%");
                $asignedUser = array();
                foreach ($searchQuery->asignedUser as $key => $value) {
                    $asignedUser[] = $value->id;
                }
                if (count($asignedUser)) {
                    $query->whereIn('to_do_task_assigns.assigned_to', $asignedUser);
                }
            }

            $todoList = $query->orderBy('to_do_tasks.id', 'desc')
                ->get();
            $priorities = Priority::where('status', 1)->get();
            $sortedArray = array();
            $today = new \DateTime("now");
            $sortedArray['Totalcount'] = count($todoList);
            foreach ($priorities as $keypr => $valuepr) {
                $sortedArray[$valuepr->id] = array();
            }
            foreach ($todoList as $key => $value) {
                $taskdate = new \DateTime($value->task_date);
                $interval = $today->diff($taskdate);
                foreach ($priorities as $keypr => $valuepr) {
                    if ($interval->format("%r%a") <= $valuepr->days) {
                        $sortedArray[$valuepr->id][] = $value;
                        break;
                    }
                }
            }
            return [
                'data' => $sortedArray,
                // 'completedCount' => $completedCount,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function todoCompletedIndex(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $searchQuery = json_decode($request->input('query', ''));
            // $userId = $request->
            $query = ToDoTask::leftJoin('to_do_task_assigns', 'to_do_tasks.id', "=", "to_do_task_assigns.to_do_task_id")
                ->select('to_do_tasks.id', 'to_do_tasks.title', 'to_do_tasks.about', 'to_do_tasks.to_do_status_id', 'to_do_tasks.company_id', 'to_do_tasks.created_by', 'to_do_tasks.completed', 'to_do_tasks.type', 'to_do_tasks.priority_id', 'to_do_tasks.status', 'to_do_tasks.created_at')
                ->where('to_do_tasks.type', 2)
                ->where('to_do_tasks.completed', 1);
            if (is_object($searchQuery)) {
                $query->where('to_do_tasks.title', 'LIKE', "%{$searchQuery->keyword}%");
                $asignedUser = array();
                foreach ($searchQuery->asignedUser as $key => $value) {
                    $asignedUser[] = $value->id;
                }
                if (count($asignedUser)) {
                    $query->whereIn('to_do_task_assigns.assigned_to', $asignedUser);
                }
            }
            $query->orWhere('to_do_tasks.type', 1)
                ->where('to_do_tasks.completed', 1)
                ->where('to_do_tasks.created_by', $userId);
            if (is_object($searchQuery)) {
                $query->where('to_do_tasks.title', 'LIKE', "%{$searchQuery->keyword}%");
                $asignedUser = array();
                foreach ($searchQuery->asignedUser as $key => $value) {
                    $asignedUser[] = $value->id;
                }
                if (count($asignedUser)) {
                    $query->whereIn('to_do_task_assigns.assigned_to', $asignedUser);
                }
            }
            $query->with('assigned.user.userDetails')
                ->with('toDoStatus')
                ->with('user.userDetails')
                ->with('priority')
                ->groupBy('to_do_tasks.id')
                ->groupBy('to_do_tasks.title')
                ->groupBy('to_do_tasks.about')
                ->groupBy('to_do_tasks.to_do_status_id')
                ->groupBy('to_do_tasks.company_id')
                ->groupBy('to_do_tasks.created_by')
                ->groupBy('to_do_tasks.completed')
                ->groupBy('to_do_tasks.type')
                ->groupBy('to_do_tasks.priority_id')
                ->groupBy('to_do_tasks.status')
                ->groupBy('to_do_tasks.created_at')
                ->take(20);

            $todoList = $query->orderBy('to_do_tasks.id', 'desc')
                ->get();
            // echo $query->toSql();
            // exit;
            return [
                'data' => $todoList,
                // 'completedCount' => $completedCount,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @author Job
     * @date 31-08-19
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $scheduledID = \Config::get('utils_constants.SCHEDULED');
            $userId = $request->user()->id;
            $data = $request->all();
            if ($data['priority_id'] == $scheduledID) {
                $data['task_date'] = Carbon::createFromFormat('d-m-Y H:i:s', $data['task_date'] . '23:59:59');
            } else {
                $priorities = Priority::where('status', 1)->get();
                $priorityDays = array();
                foreach ($priorities as $key => $value) {
                    $priorityDays["{$value->id}"] = $value->days;
                }
                $data['task_date'] = Carbon::today()->endOfDay()->addDay($priorityDays[$data['priority_id']]);
            }
            $data['created_by'] = $userId;
            $toDoTask = ToDoTask::create($data);
            if ($toDoTask) {
                $assigns = [];

                // if team task
                if ($request->get('type') == 2) {
                    if ($request->get('assigned')) {
                        foreach ($request->get('assigned') as $key => $value) {
                            $assignTemp = [
                                'to_do_task_id' => $toDoTask['id'],
                                'assigned_to' => $value['id'],
                                'created_by' => $userId,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                            $assigns[] = $assignTemp;
                        }
                        if ($assigns) {
                            $assigns = ToDoTaskAssign::insert($assigns);
                        }
                    }
                } else { // own task
                    $assignOwnData = [];
                    $assignOwnData['to_do_task_id'] = $toDoTask['id'];
                    $assignOwnData['assigned_to'] = $userId;
                    $assignOwnData['created_by'] = $userId;

                    ToDoTaskAssign::create($assignOwnData);
                }

                $returnData = ToDoTask::where('id', $toDoTask['id'])
                    ->with('assigned.user.userDetails')
                    ->with('toDoStatus')
                    ->with('user.userDetails')
                    ->with('priority')
                    ->first();

                broadcast(new ToDoTaskCreated($returnData));
                return [
                    'data' => $returnData,
                    'message' => 'Success',
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
                ];
            } else {
                return [
                    'reason' => 'error',
                    'message' => $e->getMessage(),
                    'status' => \Config::get('utils_constants.ERROR_INTERNAL_SERVER_ERROR')
                ];
            }
            // return response()->json("added");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * @author job
     * Show the specified resource.
     * @param int $id
     * @return Response
     */

    public function forwardTodo(Request $request)
    {
        try {
            // if team task
            if ($request->get('type')  == 2) {
                $assigns = [];
                $userId = $request->user()->id;
                $todoTaskId = $request->get('to_do_id');
                if ($request->get('assigned')) {
                    $forwardNames = '';
                    foreach ($request->get('assigned') as $key => $value) {
                        $assignTemp = [
                            'to_do_task_id' => $todoTaskId,
                            'assigned_to' => $value['id'],
                            'created_by' => $userId,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        $assigns = ToDoTaskAssign::updateOrCreate(['to_do_task_id' => $todoTaskId, 'assigned_to' => $value['id']], $assignTemp);
                        $forwardNames .= $value['name'] . ', ';
                    }

                    // record forward actions
                    $actions = [
                        'to_do_task_id' => $todoTaskId,
                        'action' => 'forward',
                        'comment' => $request->user()->name . ' forwarded to ' . $forwardNames,
                        'created_by' => $userId
                    ];
                    ToDoTaskAction::create($actions);
                }
            } else { // if own task
                $userId = $request->user()->id;
                $todoTaskId = $request->get('to_do_id');
                $toDoTaskOwnAssign = ToDoTaskAssign::where('to_do_task_id', $todoTaskId)
                    ->first();

                if ($toDoTaskOwnAssign) {
                    $toDoTaskOwnAssign->assigned_to = $request->get('assigned')[0]['id'];
                    $toDoTaskOwnAssign->save();

                    // record forward actions
                    $actions = [
                        'to_do_task_id' => $todoTaskId,
                        'action' => 'forward',
                        'comment' => $request->user()->name . ' forwarded to ' . $request->get('assigned')[0]['name'],
                        'created_by' => $userId
                    ];
                    ToDoTaskAction::create($actions);
                }
            }

            $returnData = ToDoTask::where('id', $todoTaskId)
                ->with('assigned.user.userDetails')
                ->with('toDoStatus')
                ->with('user.userDetails')
                ->with('priority')
                ->first();

            broadcast(new ToDoTaskForward($returnData));
            return [
                'data' => $returnData,
                'message' => 'Success',
                'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
                $toDo = ToDoTask::where('id', $id)
                    ->with('assigned.user')
                    ->with('toDoStatus')
                    ->first();
                return [
                    'data' => $toDo,
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
     * @author Job
     * @data 16-08-19
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function view($id)
    {
        try {
            if ($id) {
                $toDo = ToDoTask::where('id', $id)
                    ->with('assigned.user')
                    ->with('toDoStatus')
                    ->first();
                return [
                    'data' => $toDo,
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

    public function removeToDoUser($id)
    {
        try {
            $toDoUser = ToDoTaskAssign::find($id);

            if ($toDoUser) {
                $toDoUser->status = 0;
                $toDoUser->save();
            }

            return [
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
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
        try {
            // echo '<pre>'; print_r($request->all());exit;
            $userId = $request->user()->id;
            $toDoTask = ToDoTask::find($id);
            if ($toDoTask) {
                $toDoTask->title = $request->get('title');
                $toDoTask->about = $request->get('about');
                $toDoTask->to_do_status_id = $request->get('status')['id'];
                $toDoTask->updated_by = $userId;

                $toDoTask->save();

                $assigns = [];
                if ($request->get('assigned')) {
                    foreach ($request->get('assigned') as $key => $value) {
                        if (!$value['map_id']) {
                            $assignTemp = [
                                'to_do_task_id' => $toDoTask['id'],
                                'assigned_to' => $value['id'],
                                'to_do_task_id' => $toDoTask['id'],
                                'created_by' => $userId,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                            $assigns[] = $assignTemp;
                        }
                    }
                    if ($assigns) {
                        $assigns = ToDoTaskAssign::insert($assigns);
                    }
                }
            }

            $returnData = ToDoTask::where('id', $id)
                ->with('assigned.user')
                ->with('toDoStatus')
                ->first();

            broadcast(new ToDoTaskCreated($returnData));
            return [
                'data' => $returnData,
                'message' => 'Success',
                'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @author Job
     * @date 31-08-19
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $toDoTask = ToDoTask::findOrFail($id);
            $toDoTask->status = 0;
            $toDoTask->save();
            broadcast(new ToDoTaskRemoved($toDoTask));
            return [
                'message' => 'Success',
                'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
            ];
            // return response()->json("deleted");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * @author Job
     * @date 31-08-19
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function updateCompleted(Request $request, $id)
    {
        try {
            $toDoTask = ToDoTask::findOrFail($id);
            $toDoTask->load('assigned.user.userDetails');
            $toDoTask->load('toDoStatus');
            $toDoTask->load('user.userDetails');
            $toDoTask->load('priority');
            broadcast(new ToDoTaskCompleted($toDoTask));
            $toDoTask->completed = 1;
            $toDoTask->save();
            $ActionArray=[
                "to_do_task_id"=>$id,
                "action"=>"Completed",
                "comment"=>"Completed By ".$request->user()->name,
                "created_by"=>$request->user()->id,
                "updated_by"=>$request->user()->id,
                "status"=>1
            ];
            ToDoTaskAction::create($ActionArray);
            return [
                'message' => 'Success',
                'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE')
            ];
            // return response()->json("deleted");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * @author Job
     * @date 31-08-19
     * get all todo status.
     * @param int $id
     * @return Response
     */
    public function getStatus()
    {
        try {
            $statusList = ToDoStatusList::where('status', 1)->get();
            return [
                'data' => $statusList,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * @author Job
     * @date 31-08-19
     * get all todo status.
     * @param int $id
     * @return Response
     */
    public function addToDoStatus($status)
    {
        try {
            $data = [
                'name' => $status
            ];
            $newStatus = ToDoStatusList::create($data);
            return [
                'data' => $newStatus,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getuserCount()
    {
        try {
            return [
                'data' => \Auth::user()->userCount->count,
                'status' => \Config::get('utils_constants.SUCCESS')
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
