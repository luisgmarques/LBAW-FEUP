@extends('layouts.app')

@section('title', "Searchpage")

@section('content')

<main id="searchpage">
    <div class="container">
        <div class="row text-left">
            <div class="col-3 text-header mt-3 pt-3">
                <h4>Auctions</h4>
            </div>
            <div class="col-6 text-header mt-3 pt-3">
                <h5>{{ count($auctions) }} auctions</h5>
            </div>
            <div class="col-lg-3 mt-3 pt-1">
                <select class="custom-select">
                    <option selected>Sort by:</option>
                    <option value="1">Initial Price</option>
                    <option value="2">Ending time</option>
                    <option value="3">Type</option>
                </select>
            </div>
        </div>
        <hr class="bg-card mt-0 mb-3">
        <div class="row mb-3">
            <div class="row px-3">
                <div class="col-lg-3 text-header">
                    <h5 class="">Categories:</h5>
                    <div class="my-3"></div>
                    @foreach ($categories as $category)    
                        <div class="form-check ">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1{{ $category->name }}" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1{{ $category->name }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-9 col-6">
                    <div class="row">
                    @foreach($auctions as $key => $auction)
                    @if($key % 3 == 0)
                    </div>
                    <div class="row">
                    @endif
                    <div class="col-lg-3">
                        <div class="card shadow mb-3 bg-card">
                            @if($auction->getPhotos($auction->id)->first() != null)
                                <img class="card-img-top" src="{{ $auction->getPhotos($auction->id)->first()->photoPath() }}" alt="Picture 1">
                            @else 
                                <img class="card-img-top" src="storage/uploads/banana.jpg" alt="No images avaiable for this auction">
                            @endif
                            <div class="card-body">
                                <h5 style="height:2rem; text-overflow:ellipsis; overflow: hidden; white-space: nowrap;" class="card-title text-secondary">{{ $auction->item_name }}</h5>
                                <p style="height:2rem; text-overflow:ellipsis; overflow: hidden; white-space: nowrap;" class="card-text text-card-text">{{ $auction->description }}</p>
                                <a href="/auction/{{ $auction->id }}" class="btn btn-accent mt-3"><i class="fas fa-gavel fa-lg"></i> Bid</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection