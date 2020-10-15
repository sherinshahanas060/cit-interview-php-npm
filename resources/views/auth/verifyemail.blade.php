@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Veify Account</div>

                <div class="card-body">
                <div class="col-md-12 text-center pb-5">
                   <b>{{$message}}</b>
                </div>

                    <form method="POST" action="{{ route('verifymailotp') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">OTP</label>

                            <div class="col-md-6">
                            <input type="otp" class="form-control @error('otp') is-invalid @enderror"  id="otp" placeholder="Enter OTP" name="otp">
                            @error('otp')
                                <div class="alert alert-danger">{{ $errors->first('otp') }}</div>
                            @enderror

                           
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- <a class="float-right" href="{{ url('/resendotp') }}">Resend OTP</a> -->
                    <a class="float-right" href="{{ url('/resendmailotp') }}">Resend OTP</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
