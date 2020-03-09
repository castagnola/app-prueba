@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-center h-75">
            <div class="card">
                <div class="card-header">
                    <h3>Sign In</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <a href="{{url("login/facebook")}}"><span class="fab fa-facebook-square"></span></a>
                        <a href="{{url("login/google")}}"><span class="fab fa-google-plus-square"></span></a>
                        <a href="{{url("login/github")}}"><span class="fab fa-github-square"></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" placeholder="Email" required
                                   autocomplete="email" autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   placeholder="Password" required autocomplete="current-password">
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <div class="row align-items-center remember">
                            <input type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                        </div>
                        <div class="form-group">
                            <input type="submit" value="{{ __('Login') }}" class="btn btn-outline-warning float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<style>

    html, body {
        background-image: url('https://www.portada-online.com/wp-content/uploads/2019/01/laptop-with-glasses.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        font-family: 'Numans', sans-serif;
    }

    .container {
        height: 100%;
        align-content: center;
    }

    .card {
        height: 370px;
        margin-top: auto;
        margin-bottom: auto;
        width: 400px;
        background-color: rgba(0, 0, 0, 0.5) !important;
    }

    .social_icon span {
        font-size: 60px;
        margin-left: 10px;
        color: #FFC312;
    }

    .social_icon span:hover {
        color: white;
        cursor: pointer;
    }

    .card-header h3 {
        color: white;
    }

    .social_icon {
        position: absolute;
        right: 20px;
        top: -45px;
    }

    .input-group-prepend span {
        width: 50px;
        background-color: #FFC312;
        color: black;
        border: 0 !important;
    }

    input:focus {
        outline: 0 0 0 0 !important;
        box-shadow: 0 0 0 0 !important;

    }

    .remember {
        color: white;
    }

    .remember input {
        width: 20px;
        height: 20px;
        margin-left: 15px;
        margin-right: 5px;
    }

    .login_btn {
        color: black;
        background-color: #FFC312;
        width: 100px;
        display: inline-block;

    }

    .login_btn:hover {
        color: black;
        background-color:#FFC312;
    }

    .links {
        color: white;
    }

    .links a {
        margin-left: 4px;
    }


</style>
