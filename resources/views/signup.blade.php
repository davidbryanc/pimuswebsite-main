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
                    <form action="" class="form-login-register">
                        <input type="text" name="txtNama" placeholder="Nama Lengkap">
                        <input type="text" name="txtNRP" placeholder="NRP">
                        <input type="text" name="txtIDLine" placeholder="ID Line">
                        <input type="text" name="txtWA" placeholder="Nomor WA">
                        <input type="text" name="txtsNRP" placeholder="sNRP">
                        <input type="password" name="txtPassword" placeholder="Password">
                        <input type="password" name="txtRePassword" placeholder="Retype Password">
                        <button class="btnLogin">Sign Up</button>
                        <p class="register">Already have an account? <a href="{{url('/login')}}"> Login</a></p>
                    </form>
                </div>
                <div class="col-lg-4 col-md-12 col-12"></div>
            </div>
        </div>
    </section>
@endsection