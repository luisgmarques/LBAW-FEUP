@extends('layouts.app')

@section('title', "Wishlist")

@section('content')

<main id="wishlist">
    <div class="container">
        <h2 class="text-header pt-4">Wishlist</h2>
        <div class="accordion mt-4" id="accordionExample1">
            @foreach($auctions as $auction)
            @php
            $id = strval($auction->id);
            $dab = "#dabnation".$id;
            $dab2 = "dabnation".$id;
            $hone = "heading".$id;
            @endphp
            <div class="card bg-card">
                <div class="card-header">
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <button class="btn btn-link text-accent" type="button" data-toggle="collapse"
                                data-target={{$dab}} aria-expanded="true" aria-controls={{$dab2}}>
                                {{ $auction->item_name }}
                            </button>
                        </div>

                        <div class="col text-right">
                            <a>{{ $auction->auction_status }}</a>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/auction/{{ $auction->id }}" class="btn btn-accent"><i
                                    class="fas fa-gavel fa-lg"></i> Go to auction</a>
                        </div>
                    </div>
                </div>

                <div id={{$dab2}} class="collapse" aria-labelledby={{$dab2}} data-parent="#accordionExample">
                    <div class="card-body text-card-text">
                        {{ $auction->description }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <h2 class="text-header pt-4">Currently bidding</h2>
        <div class="accordion mt-4" id="accordionExample2">
            @foreach($auctions_2 as $auction_2)
            @php
            $id = strval($auction_2->id);
            $dab = "#dabnation".$id;
            $dab2 = "dabnation".$id;
            $hone = "heading".$id;
            @endphp
            <div class="card bg-card">
                <div class="card-header">
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <button class="btn btn-link text-accent" type="button" data-toggle="collapse"
                                data-target={{$dab}} aria-expanded="true" aria-controls={{$dab2}}>
                                {{ $auction_2->item_name }}
                            </button>
                        </div>

                        <div class="col text-right">
                            <a>{{ $auction_2->auction_status }}</a>
                        </div>
                        <div class="col-3 text-right">
                            <a href="/auction/{{ $auction_2->id }}" class="btn btn-accent"><i
                                    class="fas fa-gavel fa-lg"></i> Go to auction</a>
                        </div>
                    </div>
                </div>

                <div id={{$dab2}} class="collapse" aria-labelledby={{$dab2}} data-parent="#accordionExample">
                    <div class="card-body text-card-text">
                        {{ $auction_2->description }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</main>


@endsection