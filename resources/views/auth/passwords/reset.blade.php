@extends('layouts.auth.auth')

@section('title', 'Reset Password')

@section('content')


            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> {{ __('Please confirm your password before continuing.') }}</h4>
                            <span class="tools">

                            </span>
                </div>
                <div class="widget-body">
                    <form class="form-horizontal" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="control-group">
                            <label class="control-label">{{ __('Email') }}</label>
                            <div class="controls">
                                <input id="email" type="email" class="input-large @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email') <span class="help-inline" >  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">{{ __('Password') }}</label>
                            <div class="controls">
                                <input id="password" type="password" class="input-large @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">{{ __('Confirm Password') }}</label>
                            <div class="controls">
                                <input id="password-confirm" type="password" class="input-large" name="password_confirmation" required autocomplete="new-password">
                                @error('password-confirm') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>

                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>

                      </div>


                    </form>
                </div>
            </div>
            <!-- END GRID PORTLET-->
    

</div>





@endsection


