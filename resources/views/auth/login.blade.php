@extends('app')

@section('content')
    
    <div class="login-container">
        <img src="{{ asset('img/logo.png') }}">
        <h4>Claims Login</h4>
        @if( $errors->has('email') )
            <div style="text-align: center;"><span class="error" style="padding: 5px;">Incorrect email/password</span></div>
        @endif
        <form method="post" action="/login">
            <input type="text" name="email" placeholder="email...">
            <input type="password" name="password" placeholder="password...">

            {!! csrf_field() !!}
            <input type="submit" value="Login" class="button" />
        </form>
    </div>
@stop