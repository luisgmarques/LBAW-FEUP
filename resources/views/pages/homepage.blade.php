@extends('layouts.app')

@section('title', "Homepage")

@section('content')

@php    
$AUCTIONS_PER_LINE = 3
@endphp

<main id="homepage">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

        @php
        $auctions = app('app\Http\Controllers\HomeController')->get_random_auction_card(3);
        @endphp
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <a href="/auction/{{ $auctions[0]->id }}">
                    @if ($auctions[0]->getPhotos($auctions[0]->id)->first() != null)
                    <img class="d-block w-100 h-5" src="{{$auctions[0]->getPhotos($auctions[0]->id)->first()->photoPath()}}" alt="First slide">
                    @endif
                    <div class="carousel-caption d-none d-md-block ">
                        <h5>{{ $auctions[0]->item_name }}</h5>
                        <p>{{ $auctions[0]->description }}</p>
                    </div>
                </a>
            </div>
            <div class="carousel-item">
                <a href="/auction/{{ $auctions[1]->id }}">
                    @if ($auctions[1]->getPhotos($auctions[1]->id)->first())
                    <img class="d-block w-100" src="{{$auctions[1]->getPhotos($auctions[1]->id)->first()->photoPath()}}" alt="Second slide">
                    @endif
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $auctions[1]->item_name }}</h5>
                        <p>{{ $auctions[1]->description }}</p>
                    </div>
                </a>
            </div>
            <div class="carousel-item">
                <a href="/auction/{{ $auctions[2]->id }}">
                    @if ($auctions[2]->getPhotos($auctions[2]->id)->first())
                    <img class="d-block w-100" src="{{$auctions[2]->getPhotos($auctions[2]->id)->first()->photoPath()}}" alt="Third slide">
                    @endif
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $auctions[2]->item_name }}</h5>
                        <p>{{ $auctions[2]->description }}</p>
                    </div>
                </a>
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

    <div class="container mt-4">
        <div class="row text-left">
            <h4 class="text-header mt-3 pl-3">Most Recent</h4>
        </div>
        <hr class="bg-card">
        <div class="row text-center mb-3">

            @php
            $recent_auctions = app('app\Http\Controllers\HomeController')->get_recent_auction_card($AUCTIONS_PER_LINE);
            @endphp
            @each('partials.auction_card', $recent_auctions, 'auction')
            
        </div>
        <div class="row text-left">
            <h4 class="text-header mt-3 pl-3">Ending soon</h4>
        </div>
        <hr class="bg-card">
        <div class="row text-center mb-3">
            
            @php
            $bids_auctions = app('app\Http\Controllers\HomeController')->get_soon_auction_card($AUCTIONS_PER_LINE);
            @endphp
            @each('partials.auction_card', $bids_auctions, 'auction')

        </div>
        <div class="row text-left">
            <h4 class="text-header mt-3 pl-3">Cheapest</h4>
        </div>
        <hr class="bg-card">
        <div class="row text-center mb-3">
            
            @php
            $active_auctions = app('app\Http\Controllers\HomeController')->get_cheapest_auction_card($AUCTIONS_PER_LINE);
            @endphp
            @each('partials.auction_card', $active_auctions, 'auction')

        </div>
    </div>
</main>

@endsection
