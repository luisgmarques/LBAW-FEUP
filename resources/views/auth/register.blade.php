@extends('layouts.app')

@section('title', "Register")

@section('content')
<main id="auth">
    <div class="container px-4">
        <div class="row pt-4 pb-1 shadow">
            <div class="col-lg-3 bg-secondary">
                <div class="contact-info text-header">
                    <i class="fas fa-sign-in-alt fa-5x"></i>
                    <h2>Join Us</h2>
                    <h4>For the best bidding experience!</h4>
                </div>
            </div>
            <div class="col-lg-9 bg-card px-5">
                <h2 class="text-center mt-3 text-card-text">Sign Up</h2>
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="form-group mt-3 text-card-text">

                        <img class="img-fluid rounded-circle mx-auto d-block shadow-lg" src="../images/placeholder.jpg" style= "height: 15rem; width: 15rem;" onclick="pictureClick()" id="profileDisplay" alt="profile_image">
                        <input type="file" class="form-control-file" onchange="displayImage(this)" id="profilePicture" name="profilePicture" style = "display:none;">

                        @if ($errors->has('profilePicture'))
                            <strong>{{ $errors->first('profilePicture') }}</strong>
                        @endif

                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
                        @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="username" required>
                        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="email" required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="address" required>
                        @if ($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="zip code" required>
                        @if ($errors->has('zip_code'))
                            <span class="help-block">
                            <strong>{{ $errors->first('zip_code') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="password" required>
                    </div>
                    <div class="text-center mt-3 text-card-text">
                        <h6>By registering in our website your accepting our terms and conditions!</h6>
                        <button type="submit" class="btn btn-outline-accent"> Sign Up</button>
                    </div>
                    <div class="text-center mt-3 text-card-text">
                        <label>Or sign up with:</label>
                    </div>
                    <div class="text-center mt-1">
                        <button type="submit" class="btn btn-secondary"><i
                                class="fab fa-google-plus-g fa-lg text-accent mr-2"></i>Google +</button>
                    </div>
                    <div class="text-center mt-3 mb-0 text-card-text">
                        <a href="{{ route('login') }}">Already have an account?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
