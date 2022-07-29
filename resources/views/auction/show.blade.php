@extends('layouts.app')

@section('title', "Auction")

@section('content')

<main id="auction">

    <div class="container">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="row py-4">
            <div class="col-md">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner shadow">
                        @if (count($auction_photos) == 0)
                        <div class="carousel-item active">
                            <img src="../storage/uploads/banana.jpg" class="d-block w-100" alt="...">
                        </div>
                        @else
                        @for($i = 0; $i < count($auction_photos); $i++) @if ($i==0) <div class="carousel-item active">
                            <img src="{{ $auction_photos[$i]->photoPath() }}" class="d-block w-100" alt="...">
                    </div>
                    @else
                    <div class="carousel-item">
                        <img src="{{ $auction_photos[$i]->photoPath() }}" class="d-block w-100" alt="...">
                    </div>
                    @endif
                    @endfor
                    @endif
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

        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <div class="text-header">

                <a href="{{ route('profile.show', $auction->seller) }}"><img id="seller-picture"
                        src="{{ $auction->seller->profilePicture() }}" alt="profile_img"
                        class="mx-auto d-block shadow rounded-circle" style="height:12rem">
                </a>
                <h5 class="text-center mt-3">{{ $auction->seller->first_name . ' ' . $auction->seller->last_name }}
                </h5>
                <div class="text-center">
                    @for($i=0; $i<$auction->seller->rating;$i++)
                        <i class="fa fa-star text-accent"></i>
                        @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md">
            <div class="content-center">
                <div class="row">
                    <div class="col">
                        <div class="text-card">
                            <h1 id="title-auction">{{ $auction->item_name }}</h1>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        @auth
                        @if($auction->seller_id != Auth::user()->id)
                        @if((Auth::user()->itemOnWishlist($auction)))
                        <form method="POST" action="{{action('AuctionController@removeFromWishlist', [$auction->id])}}">
                            {{ csrf_field() }}
                            <fieldset>
                                <label for="wishlist-button" class="col-form-label"></label>
                                <button type="submit" id="wishlist-button" class="btn btn-lg" title="Add to Wishlist"><i
                                        class="fas fa-heart text-accent"></i></button>
                            </fieldset>
                        </form>
                        @else
                        <form method="POST" action="{{action('AuctionController@addToWishlist', [$auction->id])}}">
                            {{ csrf_field() }}
                            <fieldset>
                                <legend hidden>Add to Wishlist</legend>
                                <button type="submit" id="wishlist-button" class="btn btn-lg" title="Add to Wishlist"><i
                                        class="far fa-heart text-accent"></i></button>
                            </fieldset>
                        </form>
                        @endif
                        @endif
                        @endauth
                    </div>

                </div>
                <div class="row text-header">
                    <div class="col mt-1">
                        <p class="justify">{{ $auction->description }}</p>
                    </div>
                </div>



            </div>
        </div>

        <div class="col-md-4 text-header text-center">
            <div class="row mt-2">
                <div class="col">
                    <h5 class="text-header">Status: </h5>
                </div>
                <div class="col">
                    <h5 class="text-center card text-accent value-holder" id="status-holder">
                        {{ $auction->auction_status }}</h5>
                </div>
            </div>

            @php
                $state = "";
                $date = "";
                $show = true;
                $open = false;

                $format = 'd-m-Y';

                if(!strcmp($auction->auction_status, "Open")){
                    $open = true;
                    $state = "Ends at:";
                    $date = $auction->end_date->toDateString();
                } elseif (!strcmp($auction->auction_status, "Ended")) {
                    $state = "Closed at:";
                    $date = $auction->end_date->toDateString();
                }
                else{
                    # aka status is disabled
                    $now = date($format);
                    $auction_start = $auction->beginning_date->toDateString();

                    if($now < $auction_start){
                        $state = "Starts at";
                        $date = $auction_start;
                    }
                    else{
                        $show = false;
                    }
                }
            @endphp

            @if ($show)
                <div class="row">
                    <div class="col">
                        <h5 class="text-header">{{ $state }}</h5>
                    </div>
                    <div class="col">
                        <h5 class="text-center card text-accent value-holder" id="date-holder">
                            {{ $date }}</h5>
                    </div>
                </div>
            @endif


            <div class="row">
            <div class="col">
                <h5 class="text-header">Last bid: </h5>
            </div>
            <div class="col">
                <h5 class="text-center card text-accent value-holder" id="last-bid-holder">{{ $auction->current_price }}</h5>
            </div>
        </div>

        @if ($open)
                @if(auth()->user() == null)
        @elseif(Auth::id() != $auction->seller_id && !$auction->getBid())
        <form id="bid" action="{{ route('auction.makeBid', $auction) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="input-group form-row mx-2 my-2">

                <input type="hidden" id="auction_id" name="auction_id" value="{{ $auction->id }}">
                <input type="hidden" id="authenticated_id" name="authenticated_id" value="{{ Auth::id() }}">

                <input id="amount" name="amount" type="number" value="{{ $auction->current_price + 1 }}" placeholder="{{ $auction->current_price + 1 }} " readonly
                    class="form-control">
                <div class="input-group-append">
                    <button type="submit" id="make-bid" class="btn btn-accent btn"><i class="fas fa-gavel fa-lg"></i> Bid</button>
                </div>
            </div>
        </form>
                @elseif(Auth::id() != $auction->seller_id)
                    <div class="row">
                        <div class="col">
                            <h5 class="text-header">Currently highest bidder.</h5>
                        </div>
                    </div>
        @endif
        @can('update', $auction)
        <a href="{{ route('auction.edit', $auction) }}" type="button" class="btn mt-3 mr-1 btn-accent btn-lg"><i
                class="far fa-edit"></i> Edit</a>

        @endcan

        @endif

    </div>

    </div>

    <div class="row bg-card mt-5" id="auction-table">
        <div class="col-lg-12">
            <nav>
                <div class="nav nav-tabs nav-fill mb-3" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                        role="tab" aria-controls="nav-profile" aria-selected="true">Payment Methods</a>
                    <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#nav-user" role="tab"
                        aria-controls="nav-user" aria-selected="false">Shipping Cost</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                        aria-controls="nav-contact" aria-selected="false">Ships To</a>
                    <a class="nav-item nav-link" id="nav-bidding-tab" data-toggle="tab" href="#nav-bidding" role="tab"
                        aria-controls="nav-bidding" aria-selected="false">Bidding history</a>
                </div>
            </nav>
            <div class="tab-content bg-card" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-profile" role="tabpanel"
                    aria-labelledby="nav-profile-tab">
                    <ul class="text-header text-card-text">
                        <li>{{ $auction->payment }}</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab">
                    <ul class="text-card-text">
                        <li>{{ $auction->shipping_cost }} €</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <ul class="text-card-text">
                        <li>{{ $auction->shipping }}</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="nav-bidding" role="tabpanel" aria-labelledby="nav-bidding-tab">
                    <div class="text-card-text ml-3 mb-2">
                        <h5>Last 5 bids:</h5>
                        @foreach($bids as $bid)
                        <div class="row">
                            <h6>
                                <a class="text-accent ml-3">-</a>
                                {{ $bid->amount }}
                                <a class="text-card-text"> - </a>
                                {{$bid->date}}
                            </h6>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


</main>

@endsection