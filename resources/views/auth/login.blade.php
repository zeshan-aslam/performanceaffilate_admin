<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Login</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/bootstrap/css/bootstrap-responsive.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/bootstrap/css/bootstrap-fileupload.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style-default.css')}}" rel="stylesheet" id="style_color" />

</head>

 <body class="lock">
    <div class="lock-header ">
        <!-- BEGIN LOGO -->

           <h1 class='text-warning' style="font-weight: bold" ><img src="{{asset('img/logo.png') }}" alt=""></h1>

        <!-- END LOGO -->
    </div>
    @if($errors->any())
    {!! implode('', $errors->all('<div class=" w-25 alert alert-danger mx-auto">:message</div>')) !!}
    @endif
    <div class="login-wrap">
        <div class="metro single-size red">
            <div class="locked">
                <i class="icon-lock"></i>
                <span>{{ __('Login') }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('login') }}">
        <div class="metro double-size green">

                 @csrf
                <div class="input-append lock-input">
                    <input class="" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address">

                </div>

        </div>
        <div class="metro double-size yellow">

                <div class="input-append lock-input">
                    <input id="password" type="password" class="" name="password" required autocomplete="current-password" placeholder="Password">

                </div>

        </div>
        <div class="metro single-size terques login">

                <button type="submit" class="btn login-btn">
                    Login
                    <i class=" icon-long-arrow-right"></i>
                </button>

        </div>
         </form>

        <div class="login-footer">
            <div class="remember-hint pull-left">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>


                                        {{ __('Remember Me') }}

            </div>
            <div class="forgot-hint pull-right">
                 @if (Route::has('password.request'))
                    <a  id="forget-password" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
            </div>
        </div>
    </div>
</body>
