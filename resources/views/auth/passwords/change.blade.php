@extends('layouts.auth.auth')

@section('title', 'Change Password')

@section('content')


            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> {{ __('Change Password.') }}</h4>
                      
                </div>
                <div class="widget-body">
                    <form class="form-horizontal" method="POST" action="{{ route('password.changePassword') }}">
                        @csrf

                        <div class="control-group">
                            <label class="control-label">{{ __('Email') }}</label>
                            <div class="controls">
                                <input id="email" type="email" class="input-large @error('email') is-invalid @enderror" name="email" value="{{Auth::user()->email}}" required autocomplete="email" autofocus>
                                @error('email') <span class="help-inline" >  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">{{ __('Old Password') }}</label>
                            <div class="controls">
                                <input id="oldpassword" type="password" class="input-large @error('oldpassword') is-invalid @enderror" name="oldpassword" required autocomplete="current-password">
                                @error('oldpassword') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
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
                            {{ __('Change Password') }}
                        </button>

                      </div>


                    </form>
                </div>
            </div>
            <!-- END GRID PORTLET-->


</div>





@endsection


