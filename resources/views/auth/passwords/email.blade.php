@extends('layouts.auth.auth')

@section('title', 'Send Email')

@section('content')
<div class='row-fluid'>




            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> {{ __('Reset Password') }}</h4>
                            <span class="tools">

                            </span>
                </div>
                <div class="widget-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <form method="POST" action="{{ route('password.email') }}" class="form-horizontal">
                        @csrf


                        <div class="control-group">
                            <label class="control-label" >{{ __('Email') }}</label>
                            <div class="controls">
                                <input id="email" type="email" class="input-large @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email') <span class="help-inline">  <strong>{{ $message }}</strong> </span>   @enderror
                            </div>
                        </div>

                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>

                      </div>


                    </form>
                </div>
            </div>
            <!-- END GRID PORTLET-->


</div>





@endsection

