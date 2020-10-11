<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\Otp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $attempt = 1;

        // return $request->only($this->username(), 'password');
        $ip = $this->getUserIpAddr();
        $location_result = $this->validation("https://maps.googleapis.com/maps/api/geocode/json?latlng=$request->latitude,$request->longitude&key=AIzaSyCbfMjco6LRNimffgKp7E06Qax7MQ_VONg");
        $timestamp = time();
        $time_stamp = $this->validation("https://maps.googleapis.com/maps/api/timezone/json?location=$request->latitude,$request->longitude&timestamp=$timestamp&key=AIzaSyBvx4Wz0BNEZ7xyY8lUlCJwOfyzxC6aukk");
        if (!$request->session()->has('auth_logID')) {
            $attempt = 1;
        } else {
            $auth_logID = session('auth_logID');
            $count = AuthLog::select('attempt_count')
                ->where('id', $auth_logID)
                ->first();
            if ($count) {
                $attempt = $count->attempt_count + 1;
            }

        }

        /*
        |--------------------------------------------------------------------------
        | Save login location and device information to database
        |--------------------------------------------------------------------------
         */
        if ($location_result != "false" && $time_stamp != "false") {
            $address = json_decode($location_result);
            $time_zone = json_decode($time_stamp);
            $auth_logID = AuthLog::create([
                // 'user_id' => "",
                'login_ip' => $ip,
                // 'mac_id' => "",
                'address' => $address->results[0]->formatted_address,
                'lat' => $request->latitude,
                'lon' => $request->longitude,
                'time_zone' => $time_zone->timeZoneId,
                // 'login_time' => Carbon::now(),
                // 'logout_time' => "",
                'device_information' => $request->header('User-Agent'),
                'attempt_count' => $attempt,
                'failure_reason' => "Credentials do not match",
            ])->id;
            session(['auth_logID' => $auth_logID]);
        }
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'user_status' => 1, 'status' => 1];
    }

    protected function authenticated(Request $request, $user)
    {
        $sendOtp = false;
        $logs = AuthLog::select('id', 'device_information')
            ->where('user_id', $user->id)
            ->where('failure_reason', 'Success')
            ->latest()
            ->take(2)
            ->get();

        ## check mobile number validated status
        if ($user->mobile_validated == 0) {
            $sendOtp = true;
        }
        ## compare last 2 login devices
        if ($logs && $logs->count() > 1) {
            $vals = array_column(json_decode($logs), 'device_information');
            if ($vals[0] != $vals[1]) {
                $sendOtp = true;
            }
        }

        ## send verification otp if required
        if ($sendOtp) {
            Otp::where('user_id', $user->id)->update(['status' => 0]);
            $user->update(['mobile_validated' => 0, 'email_validated' => 0]);
            return redirect('/otp');
        }
    }

    public function validation($request)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        if (!curl_errno($curl)) {
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($status_code != 200) {
                $data = "false";
            }
        } else {
            $data = "false";
        }
        curl_close($curl);
        return $data;
    }

    public function getUserIpAddr()
    {

        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $auth_logID = session('auth_logID');
        if ($auth_logID != null) {
            AuthLog::where('id', $auth_logID)
                ->update(array('logout_time' => Carbon::now()));
        }
        session()->forget('auth_logID');
        Auth::logout();
        return redirect('/login');
    }
}
