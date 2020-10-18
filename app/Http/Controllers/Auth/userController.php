<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpMail;
use App\Models\Otp;
use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use \Validator;

class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate OTP and send it to mobile.
     *
     */
    public function otp()
    {
        $digits = 4;
        $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        if (Auth::user()->mobile_validated == 0) {
            $exOtp = Otp::where('status', 1)
                ->where('user_id', Auth::user()->id)
                ->where('verified', 0)
                ->where('type', 1)
                ->latest()->first();
            $number = UserDetail::where('user_id', Auth::user()->id)->value('mobile_number');
            if (!$exOtp) {

                Otp::create(['user_id' => Auth::user()->id, 'otp' => $otp]);

                $this->sendOtp($otp, $number);

            }
            return view('auth.verifymobile')->with('message', $this->otpLabel($number, null));
        }
        Auth::logout();
        return redirect('/login');

        // Otp::store('')

    }

    /**
     * Generate OTP content.
     *
     */
    private function otpLabel($number = null, $mail = null)
    {
        if ($number) {
            return 'We have send OTP to * * * * * * *' . substr($number, -3);
        }
        return 'We have emailed your OTP for verify your email !';
    }

    /**
     * Generate OTP message.
     *
     */
    private function otpMessage($otp)
    {
        return $otp . ' is your account verification code. Code valid for 1 minutes only. Please DO NOT share this OTP with anyone.';
    }

    /**
     * Send otp message through SMS country
     *
     */
    private function sendOtp($otp, $mobileNumber = null)
    {
        try {

            if ($mobileNumber) {
                $client = new \GuzzleHttp\Client();

                $response = $client->request('POST', 'http://www.smscountry.com/SMSCwebservice_Bulk.aspx', [
                    'form_params' => [
                        "user" => \Config::get('services')['smscountry']['user'],
                        "passwd" => \Config::get('services')['smscountry']['password'],
                        "mobilenumber" => $mobileNumber,
                        "message" => $this->otpMessage($otp),
                        "sid" => \Config::get('services')['smscountry']['sid'],
                        "mtype" => "N",
                        "DR" => "Y",
                    ],
                ]);
                if ($response->getStatusCode() === 200) {

                } else {

                }

            }

            return $mobileNumber;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generate OTP and resend.
     *
     */
    public function resendotp()
    {
        try {
            if (Auth::user()->id) {
                Otp::where('user_id', Auth::user()->id)
                    ->where('type', 1)
                    ->update(['status' => 0]);
                $number = UserDetail::where('user_id', Auth::user()->id)->value('mobile_number');

                $digits = 4;
                $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

                Otp::create(['user_id' => Auth::user()->id, 'otp' => $otp]);

                $this->sendOtp($otp, $number);
                return redirect('/otp')->with('message', $this->otpLabel($number, null));
            }
            return redirect('/login');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAttemptCount($id)
    {
        return true;
        // $attempt = AuthLog::where('user_id', $id)
        // ->latest()
        // ->first();

        // if($attempt->attempt_count > 3) {

        // }
    }

    /**
     * Verify otp entered by logind user.
     *
     */
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect('otp')
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($this->getAttemptCount($request->user()->id)) {
                $date = new \DateTime('NOW');
                $date->modify('-1 minutes');
                $formatted_date = $date->format('Y-m-d H:i:s');

                $otp = Otp::where('otp', $request->otp)
                    ->where('status', 1)
                    ->where('type', 1)
                    ->where('created_at', '>=', $formatted_date)
                    ->where('verified', 0)->first();

                if ($otp) {
                    $otp->update(['verified' => 1, 'status' => 0]);

                    User::where('id', Auth::user()->id)
                        ->update(['mobile_validated' => 1]);

                    return redirect('/mailotp');
                }

                $validator->errors()->add('otp', 'Invalid OTP');

                return redirect('otp')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $validator->errors()->add('email', 'User blocked !');
                return redirect('/login')
                    ->withErrors($validator)
                    ->withInput();
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Verify otp entered by logind user.
     *
     */
    public function verifymailotp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect('mailotp')
                    ->withErrors($validator)
                    ->withInput();
            }

            $date = new \DateTime('NOW');
            $date->modify('-1 minutes');
            $formatted_date = $date->format('Y-m-d H:i:s');

            $otp = Otp::where('otp', $request->otp)
                ->where('status', 1)
                ->where('type', 2)
                ->where('created_at', '>=', $formatted_date)
                ->where('verified', 0)->first();

            if ($otp) {
                $otp->update(['verified' => 1, 'status' => 0]);

                User::where('id', Auth::user()->id)
                    ->update(['email_validated' => 1]);

                return redirect('/admin/dashboard');
            }

            $validator->errors()->add('otp', 'Invalid OTP');

            return redirect('mailotp')
                ->withErrors($validator)
                ->withInput();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generate OTP and send to email.
     *
     */
    public function mailotp(Request $request)
    {
        try {
            // Otp::where('user_id', Auth::user()->id)
            //     ->where('type', 2)
            //     ->update(['status' => 0]);
            $exOtp = Otp::where('status', 1)
                ->where('user_id', Auth::user()->id)
                ->where('verified', 0)
                ->where('type', 2)
                ->latest()->first();
            if (!$exOtp) {
                $digits = 4;
                $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

                Otp::create(['user_id' => Auth::user()->id, 'otp' => $otp, 'type' => 2]);
                Mail::to(Auth::user()->email)->send(new EmailOtpMail($otp));

            }

            return view('auth.verifyemail')->with('message', $this->otpLabel(null, Auth::user()->email));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generate OTP and send to email.
     *
     */
    public function resendmailotp(Request $request)
    {
        try {
            Otp::where('user_id', Auth::user()->id)
                ->where('type', 2)
                ->update(['status' => 0]);
            $digits = 4;
            $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

            Otp::create(['user_id' => Auth::user()->id, 'otp' => $otp, 'type' => 2]);
            Mail::to(Auth::user()->email)->send(new EmailOtpMail($otp));

            return redirect('mailotp')->with('message', $this->otpLabel(null, Auth::user()->email));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
