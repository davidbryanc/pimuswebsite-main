@extends('layout.admin', ['title'=>'Admin'])

@section('content')
<div class="card bg-info">
    <div class="card-body">
        <h5>Welcome,</h5>
        <h2><b>{{ Auth::user()->name }}</b></h2>
    </div>
</div>
@endsection