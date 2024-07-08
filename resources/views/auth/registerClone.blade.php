@extends('layouts.auth.auth')

@section('content')
<div class="widget blue">
    <div class="widget-title">
        <h4>{{ __('Register User') }}</h4>
                <span class="tools">

                </span>
    </div>
    <div class="widget-body">

                    <form method="POST" action="{{ route('register') }}" class='form-horizontal'>
                        @csrf
                        <div class="control-group">
                            <label class="control-label">{{ __('Username') }}</label>
                            <div class="controls">
                                <input id="username" type="text" class="input-large @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>



                        <div class="control-group">
                            <label class="control-label" >{{ __('Email') }}</label>
                            <div class="controls">
                                <input id="email" type="email" class="input-large @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
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
                                {{ __('Register') }}
                            </button>

                          </div>
                    </form>
    </div>

@endsection
