@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Home
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
@endsection

@section('content')
<div class="container" style="margin-top:150px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
