@extends('layouts.app')

@section('title', "Edit profile")

@section('content')
<main id="auth">
    <div class="container px-4">
        <div class="row pt-4 pb-1 shadow">
            <div class="col-lg-3 bg-secondary">
                    <div class="contact-info text-header">
                        <i class="fas fa-sign-in-alt fa-5x"></i>
                        <h2></h2>
                        <h4></h4>
                    </div>
                </div>
            <div class="col-lg-9 bg-card px-5">
                <h2 class="text-center mt-3 text-card-text">Edit profile</h2>
                <form method="POST" action="/profile/{{ $user->id }}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="row text-center">
                        <div class="col-lg-4"></div>
                        <div class=" col-lg-4 col-lg-offset-4">
                            <img class="img-fluid rounded-circle shadow-lg" src="{{ $user->profilePicture() }}" onclick="pictureClick()" style="height: 15rem; width: 15rem;" id="profileDisplay" alt="profile_image">
                            <input type="file" class="form-control-file" onchange="displayImage(this)" id="profilePicture" name="profile_pic" style = "display:none;">

                            @if ($errors->has('profile_pic'))
                                <strong>{{ $errors->first('profile_pic') }}</strong>
                            @endif
                        </div>
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') ?? $user->first_name }}"
                           autocomplete="first_name" >
                        @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') ?? $user->last_name }}"
                           autocomplete="last_name" >
                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') ?? $user->username }}"
                           autocomplete="username" >
                        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? $user->email }}"
                           autocomplete="email" >
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') ?? $user->address }}"
                               autocomplete="address" >
                        @if ($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 text-card-text{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') ?? $user->zip_code }}"
                               autocomplete="zip_code" >
                        @if ($errors->has('zip_code'))
                            <span class="help-block">
                            <strong>{{ $errors->first('zip_code') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="text-center mt-3 text-card-text">
                        <button type="submit" class="btn btn-outline-accent">Save Profile</button>
                        <button class="btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
