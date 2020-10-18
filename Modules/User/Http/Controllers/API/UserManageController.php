<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

class UserManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:User', ['except' => ['getUsers', 'showMyProfile', 'viewMyProfile', 'updateMyProfile']]);
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-view', ['only' => ['showUserDetailsByUserId', 'show']]);
    }
   
    /**
     * @author
     * @date
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $columns = ['name', 'role', 'user_details.user_status', 'user_details.mobile_number', 'email'];

            $lenght = $request->input('length');
            $column = $request->input('column');
            $dir = $request->input('dir');
            $searchValue = $request->input('search');

            $query = User::leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->select('users.id', 'users.name', 'user_details.title', 'user_details.first_name', 'user_details.middle_name', 'user_details.second_name', 'user_details.user_status', 'user_details.mobile_number', 'users.email', 'user_details.profile_image', 'users.is_user')
                ->with('roles')
                ->where('users.email', '!=', 'admin@eap.com')
                ->where('users.email', '!=', 'info@aizov.com')
                ->where('users.status', 1)
            // ->where('users.is_user', 1);
                ->whereNotNull('users.password')
                ->orderBy($columns[$column],
                    $dir);

            if ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('user_details.email', 'like', '%' . $searchValue . '%')
                        ->orWhere('users.name', 'like', '%' . $searchValue . '%');
                });
            }

            $users = $query->paginate($lenght);

            return ['data' => $users, 'draw' => $request->input('draw')];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @author Iqbal
     * @date 
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // validation
        $this->validate($request, [
            'email' => 'required|email|unique:user_details|unique:users',
            'password' => 'required',
            'role' => 'required',
            'employee_id_number' => 'max:191',
            'join_date' => 'nullable',
            'user_status' => 'required',
            'first_name' => 'required',
            'second_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'nullable',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            // 'nationality' => 'required',
            'department' => 'string|nullable',
            'profession' => 'string|nullable',
        ]);

        try {
            $data = $request->all();
            if ($data['join_date']) {
                $data['join_date'] = Carbon::createFromFormat('d-m-Y', $data['join_date'])
                    ->format('Y-m-d');
            }

            if ($data['date_of_birth']) {
                $data['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $data['date_of_birth'])
                    ->format('Y-m-d');
            }

            # register login user
            $userInput['name'] = $request->get('first_name') . " " . $request->get('middle_name') . " " . $request->get('second_name');
            $userInput['password'] = Hash::make($request->get('password'));
            $userInput['email'] = $request->get('email');
            $userInput['user_status'] = $request->get('user_status');
            $userInput['is_user'] = 1;

            $user = User::create($userInput);

            # push notification to database
            // $notificationData = [
            //     'type' => 2,
            //     'notify_type' => \Config::get('utils_constants.GENARAL'),
            //     'text' => 'New user ' . $data["first_name"] . ' ' . $data['middle_name'] . ' ' . $data['second_name'] . ' created',
            //     'path' => '/user/viewuser/' . $user['id'],
            //     'created_by' => $request->user()->id,
            // ];
            // CreateNotification::store($notificationData);

            $user->assignRole($request->get('role'));

            # save into user_details table
            $data['user_id'] = $user['id'];
            # upload file if form has file
            if ($request->get('profile_image')) {
                $file = $request->get('profile_image');
                $fileName = Carbon::now()->timestamp . '_' . $user["id"] . '_' . $file;
                if (Storage::disk('file_temp')->exists('uploads/' . $file)) {

                    # move file from temp to upload disk
                    Storage::disk('user_uploads')->writeStream('profile/' . $fileName, Storage::disk('file_temp')->readStream('uploads/' . $file));

                }

                # add file name to form data
                $data['profile_image'] = $fileName;
            }

            $userCreate = UserDetail::create($data);
            if ($userCreate) {
                #send user created mail
                // SendUserCreatedMail::dispatch($data['first_name'], $data['email']);
                return [
                    'message' => 'success',
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE'),
                ];
            }

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
                $user = User::where('id', $id)
                    ->with('userDetails')
                    ->with('roles')
                    ->first();

                return [
                    'data' => $user,
                    'message' => 'success',
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE'),
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        exit;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function showMyProfile(Request $request, $id)
    {
        try {
            if ($id && $request->user()->id == $id) {
                $user = User::where('id', $request->user()->id)
                    ->with('userDetails')
                    ->with('roles')
                    ->first();

                if ($user->userDetails['join_date']) {
                    $user->userDetails['join_date'] = Carbon::createFromFormat('Y-m-d', $user->userDetails['join_date'])
                        ->format('d-m-Y');
                }
                if ($user->userDetails['date_of_birth']) {
                    $user->userDetails['date_of_birth'] = Carbon::createFromFormat('Y-m-d', $user->userDetails['date_of_birth'])
                        ->format('d-m-Y');
                }

                return [
                    'data' => $user,
                    'message' => 'success',
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE'),
                ];
            } else {
                return [
                    'message' => 'not found',
                    'status' => \Config::get('utils_constants.ERROR_NO_CONTENT'),
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        exit;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function viewMyProfile(Request $request, $id)
    {
        try {
            if ($id && $request->user()->id == $id) {
                $user = User::where('id', $request->user()->id)
                    ->with('userDetails')
                    ->with('roles')
                    ->first();

                return [
                    'data' => $user,
                    'message' => 'success',
                    'status' => \Config::get('utils_constants.SUCCESSWITHMESSAGE'),
                ];
            } else {
                return [
                    'message' => 'not found',
                    'status' => \Config::get('utils_constants.ERROR_NO_CONTENT'),
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        exit;
    }

    /**
     * @author Iqbal
     * @date 
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function showUserDetailsByUserId($userId)
    {
        try {
            if ($userId) {
                $userDetails = User::where('id', $userId)
                    ->with('roles')
                    ->with('userDetails')
                    ->first();

                if ($userDetails->userDetails['join_date']) {
                    $userDetails->userDetails['join_date'] = Carbon::createFromFormat('Y-m-d', $userDetails->userDetails['join_date'])
                        ->format('d-m-Y');
                }
                if ($userDetails->userDetails['date_of_birth']) {
                    $userDetails->userDetails['date_of_birth'] = Carbon::createFromFormat('Y-m-d', $userDetails->userDetails['date_of_birth'])
                        ->format('d-m-Y');
                }

                return [
                    'data' => $userDetails,
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
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
        // validation
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            'role' => 'required',
            'employee_id_number' => 'max:191',
            'join_date' => 'required',
            'user_status' => 'required',
            'first_name' => 'required',
            'second_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'nationality' => 'required',
            'department' => 'string|nullable',
            'profession' => 'string|nullable',
        ]);
        try {
            $user = User::find($id);
            $data = $request->all();
            $data['join_date'] = Carbon::createFromFormat('d-m-Y', $data['join_date'])
                ->format('Y-m-d');
            $data['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $data['date_of_birth'])
                ->format('Y-m-d');
            // update login user
            $userInput['name'] = $request->get('first_name') . " " . $request->get('last_name');
            if (!empty($request->get('password'))) {
                $userInput['password'] = Hash::make($request->get('password'));
            }
            $userInput['email'] = $request->get('email');
            $userInput['user_status'] = $request->get('user_status');

            $userUpdate = $user->update($userInput);

            // assign role into user
            $user->roles()->detach();
            $user->assignRole($request->get('role'));

            if ($request->get('profile_image') && $request->get('profile_image') != $user['profile_image']) {
                $file = $request->get('profile_image');
                $fileName = $request->get('profile_image');
                if (Storage::disk('file_temp')->exists('uploads/' . $file)) {
                    $fileName = Carbon::now()->timestamp . '_' . $id . '_' . $file;
                    // move file from temp to phone book upload disk
                    Storage::disk('user_uploads')->writeStream('profile/' . $fileName, Storage::disk('file_temp')->readStream('uploads/' . $file));

                }

                // add file name to form data
                $data['profile_image'] = $fileName;
            }

            // remove role key from data for user_details table
            unset($data['role']);
            unset($data['password']);
            $data['user_id'] = $id;
            $ud = UserDetail::where('user_id', $id)
            ->first();
            if ($ud) {
                $data['id'] = $ud->id;
                UserDetail::where('id', $ud->id)->update($data);
            } else {
                UserDetail::create($data);
            }
            // UserDetail::updateOrCreate([
            //     'id' => $data['id']],
            //     $data);
            return [
                'message' => 'success',
                'status' => '100',
            ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateMyProfile(Request $request, $id)
    {
        // echo '<pre>'; print_r($request->all());exit;

        // validation
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'password' => 'nullable',
            // 'role' => 'required',
            'employee_id_number' => 'max:191',
            'join_date' => 'required',
            'user_status' => 'required',
            'first_name' => 'required',
            'second_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            // 'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'nationality' => 'required',
            'department' => 'string|nullable',
            'profession' => 'string|nullable',
        ]);
        try {
            if ($id && $request->user()->id == $id) {
                $user = User::find($request->user()->id);
                $data = $request->all();
                $data['join_date'] = Carbon::createFromFormat('d-m-Y', $data['join_date'])
                    ->format('Y-m-d');
                $data['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $data['date_of_birth'])
                    ->format('Y-m-d');
                // update login user
                $userInput['name'] = $request->get('first_name') . " " . $request->get('last_name');
                if (!empty($request->get('password'))) {
                    $userInput['password'] = Hash::make($request->get('password'));
                }
                $userInput['email'] = $request->get('email');
                $userInput['user_status'] = $request->get('user_status');

                $userUpdate = $user->update($userInput);

                if ($request->get('profile_image')) {
                    $file = $request->get('profile_image');
                    $fileName = $request->get('profile_image');
                    if (Storage::disk('file_temp')->exists('uploads/' . $file)) {
                        $fileName = Carbon::now()->timestamp . '_' . $id . '_' . $file;
                        // move file from temp to phone book upload disk
                        Storage::disk('user_uploads')->writeStream('profile/' . $fileName, Storage::disk('file_temp')->readStream('uploads/' . $file));

                    }

                    // add file name to form data
                    $data['profile_image'] = $fileName;
                }

                // remove role key from data for user_details table
                unset($data['role']);
                unset($data['password']);
                $data['user_id'] = $request->user()->id;
                $ud = UserDetail::where('user_id', $request->user()->id)
                ->first();
                if ($ud) {
                    $data['id'] = $ud->id;
                    UserDetail::where('id', $ud->id)->update($data);
                } else {
                    UserDetail::create($data);
                }
                return [
                    'message' => 'success',
                    'status' => '100',
                ];
            } else {
                return [
                    'message' => 'not found',
                    'status' => \Config::get('utils_constants.ERROR_NO_CONTENT'),
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @author Iqbal
     * @date 
     * get all users.
     * @param int $id
     * @return Response
     */
    public function getUsers()
    {
        try {
            $users = User::where('status', 1)
                ->where('password', '!=', '')
                ->where('is_user', 1)
                ->where('email', '!=', 'admin@eap.com')
                ->get();
            return [
                'data' => $users,
                'status' => \Config::get('utils_constants.SUCCESS'),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @author Iqbal
     * @date 
     * get all users.
     * @return Response
     */
    public function userOptions()
    {
        try {
            $users = User::select('users.id', 'users.name')
                ->with('image')
                ->where('users.status', 1)
                ->where('users.password', '!=', '')
                ->where('users.is_user', 1)
                ->where('users.email', '!=', 'admin@eap.com')
                ->get()->map->userBaseFormat();
            return [
                'data' => $users,
                'status' => \Config::get('utils_constants.SUCCESS'),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @author Iqbal
     * @date 
     * get all delegate users.
     * @param int $id
     * @return Response
     */
    public function getDelegates()
    {
        try {
            $users = User::where('status', 1)
                ->where('is_delegate', 1)
                ->get();
            return [
                'data' => $users,
                'status' => \Config::get('utils_constants.SUCCESS'),
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            $user->status = 0;
            $user->save();
        }
        return ['message' => 'Success'];
    }
}
