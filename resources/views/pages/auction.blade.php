@extends('layouts.app')

@section('title', "Auction")

@section('content')

<main id="auction">

    <div class="container">
        <div class="text-header py-3">

        </div>
        <div class="row py-3">
            <div class="col-lg-5">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner shadow">
                        <div class="carousel-item active">
                            <img src="../images/banana.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/banana.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/banana.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="content-center">
                    <div class="text-card">
                        <h3 id="title-auction">Banana</h3>
                    </div>
                    <div class="my-5">

                        <h5 id="price-auction" class="text-center card text-accent" id="price-holder">€9000</h5>
                    </div>

                    <form class="mb-3">
                        <div class="form-row">
                            <div class="col-lg-9">
                                <input type="number" id="bet-auction" class="form-control">
                            </div>
                            <div class="col-lg-2">

                                <button type="submit" id="button-auction" class="btn btn-accent btn"><i
                                        class="fas fa-gavel fa-lg"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 text-header">
                <img id="seller-picture" src="../images/placeholder.jpg" alt="profile_img"
                    class="mx-auto d-block shadow rounded-circle" style="height:10rem">
                <h5 class="text-center mt-3">João Brandão</h5>
                <div class="text-center">

                    <i class="fas fa-star text-accent"></i>
                    <i class="fas fa-star text-accent"></i>
                    <i class="fas fa-star text-accent"></i>
                    <i class="fas fa-star text-accent"></i>
                    <i class="far fa-star text-accent"></i>
                </div>
            </div>
        </div>
        <div class="row text-header text-center">
            <div class="col-lg-5">
                <i class="fas fa-stopwatch fa-lg"></i>

                <div class="progress bg-card mt-1" style="height: 1rem;">
                    <div class="progress-bar bg-accent" role="progressbar" style="width: 80%;" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="col-lg-2 my-4">

            </div>

        </div>
        <div class="row bg-card mt-3" id="auction-table">
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs nav-fill mb-3" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Payment Methods</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                            role="tab" aria-controls="nav-contact" aria-selected="false">Ships To</a>
                    </div>
                </nav>
                <div class="tab-content bg-card" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <p class="text-card-text">A standard banana for measuring all kinds of stuff!</p>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <ul class="text-header text-card-text">
                            <li>MBWay</li>
                            <li>Paypal</li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <ul class="text-card-text">
                            <li>Worldwide</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

@endsection