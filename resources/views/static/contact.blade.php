@extends('layouts.app')

@section('title', "Contact")

@section('content')
<main id="contact">
    <div class="container">
        <div class="row my-4"> </div>
        <div class="row shadow">
            <div class="col-lg-3 bg-secondary">
                <div class="contact-info text-header">
                    <i class="fas fa-envelope fa-5x"></i>
                    <h2>Contact Us</h2>
                    <h4>We would love to hear from you!</h4>
                </div>
            </div>
            <div class="col-lg-9 bg-card">
                <div class="contact-form">
                    <div class="form-group">
                        <label class="control-label col-sm-3 text-card-text" for="fname">First Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fname" placeholder="Enter First Name"
                                name="fname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 text-card-text" for="lname">Last Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"
                                name="lname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-card-text" for="email">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-card-text" for="comment">Comment:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                    </div>
                    <div class="form-group my-auto">
                        <div class="col-sm-offset-2 col-sm-10">
                            <form class="" style="display: inline" action="#" method="GET">
                                <button type="submit" class="btn btn-accent">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection