@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Sign Up
@endsection

@section('content')
    <section id="login" class="mb-5" style="margin-top: 150px">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 col-md-12 col-12"></div>
                <div class="col-lg-4 col-md-12 col-12">
                    <img src="{{ url('/assets/images/logo/logo-pimus-text.png') }}" alt="PIMUS XI" class="mb-4">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                            @endif
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('register') }}" class="form-login-register">
                        @csrf
                        <input type="text" name="nama" placeholder="Nama Lengkap" class="@error('nama') is-invalid @enderror"
                            required autofocus autocomplete="name">
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="text" id="nrp" name="nrp" placeholder="NRP" class="@error('nrp') is-invalid @enderror" maxlength="9" required>
                        @error('nrp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <!-- <input type="email" id="email" name="email" placeholder="Email Gooaya" class="@error('email') is-invalid @enderror"
                            required readonly>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->
                        <input type="password" name="password" placeholder="Password"
                            class="@error('password') is-invalid @enderror" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="password" name="password_confirmation" placeholder="Retype Password"
                            class="@error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button class="btnLogin">Sign Up</button>
                        <p class="register">Already have an account? <a href="{{ url('/login') }}"> Login</a></p>
                    </form>
                </div>
                <div class="col-lg-4 col-md-12 col-12"></div>
            </div>
        </div>
    </section>
@endsection