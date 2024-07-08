@extends('layouts.auth.auth')

@section('title', 'Confirm Password')

@section('content')


            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> {{ __('Please confirm your password before continuing.') }}</h4>
                            <span class="tools">

                            </span>
                </div>
                <div class="widget-body">
                    <form method="POST" action="{{ route('password.confirm') }}" class="form-horizontal">
                        @csrf


                        <div class="control-group">
                            <label class="control-label">{{ __('Password') }}</label>
                            <div class="controls">
                                <input id="password" type="password" class="input-large @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>

                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm Password') }}
                        </button>
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                       @endif
                      </div>


                    </form>
                </div>
            </div>
            <!-- END GRID PORTLET-->


</div>





@endsection
