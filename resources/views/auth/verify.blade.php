

@extends('layouts.auth.auth')

@section('title', 'Verify Email')

@section('content')

            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4>{{ __('Verify Your Email Address') }}</h4>
                            <span class="tools">

                            </span>
                </div>
                <div class="widget-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf



                      <div class="form-actions">
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.


                      </div>


                    </form>
                </div>
            </div>
            <!-- END GRID PORTLET-->


</div>





@endsection


