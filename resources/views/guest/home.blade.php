@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-12">
                <h1>You are not logged</h1>
                <div class="d-grid gap-4 align-items-center">
                    <a href="{{ route('register') }}" class="btn btn-primary color-white">Get Started</a>
                    <a href="{{ route('login') }}" class="btn btn-primary color-white">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
