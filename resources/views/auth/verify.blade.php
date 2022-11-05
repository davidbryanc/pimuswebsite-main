@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Verify
@endsection

@section('content')
    <section id="login" class="mb-5" style="margin-top: 150px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-reset">
                        <div class="card-header text-lowercase">{{ __('Verify Your Email Address') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ 
                                        __('A fresh verification link has been sent to your email address.
                                            Sometimes it will appear in your email as SPAM, make sure to check it.') 
                                    }}
                                </div>
                            @endif
                            
                            <div class="text-center text-white" style="font-weight: 500;">                            
                                {{ __('Before proceeding, please check your email (wait for around 10-15 minutes) for a verification link.') }}
                                {{ __('If you did not receive the email') }} <br>
                                <form class="d-inline form-reset" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit"
                                        class="btn align-baseline btn-request-verivy mt-3">
                                        {{ __('click here to request another') }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
