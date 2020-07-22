
@extends('layouts.auth')

@section('content')

            <div class="form-container">
                <div class="text-box py-5 text-center">
                    <p class="text-uppercase">{{ __('Verify Your Email Address') }}</p>
                </div>
                <form class="form login-form" method="POST" action="{{ route('verification.resend') }}">
                    @csrf

                    <div class="text-box py-5 text-center">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                    </div>
                    <div class="button-container">
                        <button type="submit" class="submit-button">{{ __('click here to request another') }}</button>
                    </div>
                </form>
            </div>

@endsection
