@extends('layouts.app')

@section('title', "Sign In")

@section('content')
<main id="auth">
    <div class="container px-4">
        <div class="row pt-4 pb-1 shadow">
            <div class="col-lg-3 bg-secondary">
                <div class="contact-info text-header">
                    <i class="fas fa-sign-in-alt fa-5x"></i>
                    <h2>Sign In</h2>
                    <h4>So you don't miss the best auctions</h4>
                </div>
            </div>
            <div class="col-lg-9 bg-card px-5">
                <h2 class="text-center mt-3 text-card-text">Sign In</h2>
                <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="form-group mt-3 text-card-text{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                        @if ($errors->has('username'))
                            <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif

                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                    </div>
                    <div class="form-group mt-3 form-check text-card-text">
                        <input type="checkbox" class="form-check-input" id="exampleCheck">
                        <label class="form-check-label" for="exampleCheck">Remember me</label>
                    </div>
                    <div class="text-center mt-3 text-card-text">
                        <button type="submit" class="btn btn-outline-accent">Sign In</button>
                    </div>
                    <div class="text-center mt-3 text-card-text">Forgot your password?
                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Reset Password
                    </a>
                    </div>
                    <div class="text-center mt-3 text-card-text">
                        <label>Or sign in with:</label>
                    </div>
                    <div class="text-center mt-1 text-card-text">
                        <button type="submit" class="btn btn-secondary"><i
                                class="fab fa-google-plus-g fa-lg text-accent mr-2"></i>Google +</button>
                    </div>
                    <div class="text-center mt-3 mb-0 text-card-text">
                        Not a member?
                        <a href="{{ route('register') }}">Sign up now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
