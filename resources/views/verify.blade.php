@extends('layout.mainweb')

@section('content')
    <section id="login" class="mb-5" style="margin-top: 150px">
        <div class="container">
            <div class="row justify-content-center">
                <h1>Verify email</h1>
                <p>Please verify your email address by clicking the link in the mail we just sent you. Thanks!</p>
                <form action="{{ route('verification.request') }}" method="post">
                    <button type="submit">Request a new link</button>
                </form>
            </div>
        </div>
    </section>
@endsection
