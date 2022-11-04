@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Reset Password
@endsection

@section('content')
    <section id="login" class="mb-5" style="margin-top: 150px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-reset">
                        <div class="card-header">{{ __('reset password') }}</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('email'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('email') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}" class="form-reset">
                                @csrf
                                <div class="form-group row">
                                    <!-- <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Email Gooaya') }}</label> -->
                                    <div class="col-md">
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="text" placeholder="sNRP" maxlength=10 autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
