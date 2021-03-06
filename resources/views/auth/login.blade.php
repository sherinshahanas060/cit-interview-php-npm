@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- latitude and longitude values -->
                        <input type="hidden" name="ipaddress" id="ipaddress">
                        <!-- <input type="hidden" name="latitude" id="location_latitude">
                        <input type="hidden" name="longitude" id="location_longitude"> -->
                        <!-- ---------------------------------- -->
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-8 offset-md-4">
                            <span class="text-danger">
                                <strong id="geolocation_error"></strong>
                             </span>
                             </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('jquery/jquery.js') }}"></script>
<script>
//======= set the latitude and longitude into form field==============//

$(document).ready(function () {
    $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
        function (json) {
        $("#ipaddress").val(json.ip);
        }
    );

      var device = "";
      if (navigator.userAgent.match(/iPad/i)) {
        device = "Tablet";
      } else if (navigator.userAgent.match(/Android|webOS|iPhone|iPod|Blackberry/i)) {
        device = "Mobile";
      } else {
        device = "Desktop";
      }

    });




// $(document).ready(function(){
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(showPosition, showError);
//     }

// });
// function showPosition(position) {
//     $("#location_latitude").val(position.coords.latitude);
//     $("#location_longitude").val(position.coords.longitude);
// }
// function showError(error) {
//     $(".login_submit").attr('disabled',true);
//     var x = document.getElementById("geolocation_error");
//   switch(error.code) {
//     case error.PERMISSION_DENIED:
//       x.innerHTML = "User denied the request for Geolocation. Please allow the browser location permission."
//       break;
//     case error.POSITION_UNAVAILABLE:
//       x.innerHTML = "Location information is unavailable."
//       break;
//     case error.TIMEOUT:
//       x.innerHTML = "The request to get user location timed out."
//       break;
//     case error.UNKNOWN_ERROR:
//       x.innerHTML = "An unknown error occurred."
//       break;
//   }
// }
</script>
