@extends('layouts.app')

@section('title', "Edit")

@section('content')
<main id="sell">
    <div class="container pt-4 pb-1 px-4">
        <div class="row justify-content-md-center bg-card shadow" id="sell-form">
            <div class="col-lg-8 p-4">
                <h2 class="text-center mt-3 text-card-text">Edit Auction</h2>
                <form class="text-header my-3" id="edit_auction" method="POST" action="/auction/{{ $auction->id }}"
                    enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="item_name">Title</label>
                        <input type="text" class="form-control" id="item_name" name="item_name"
                            value="{{ old('item_name') ?? $auction->item_name }}">
                        @if ($errors->has('item_name'))
                        <span style="color:red" class="help-block">
                            <strong>{{ $errors->first('item_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">Choose</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') ?? $auction->description }}</textarea>
                        @if ($errors->has('description'))
                        <span style="color:red" class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="end_date">End date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                        @if ($errors->has('end_date'))
                        <span style="color:red" class="help-block">
                            <strong>{{ $errors->first('end_date') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="payment">Payment method</label>
                        <select class="form-control" id="payment" name="payment" required>
                            <option value="">Choose</option>
                            <option value="Paypal">Paypal</option>
                            <option value="MBWay">MBWay</option>
                            <option value="Visa/Mastercard">Visa/Mastercard</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="shipping">Shipping to:</label>
                        <input type="text" class="form-control" id="shipping" name="shipping"
                            value="{{ old('shipping') ?? $auction->shipping }}" autocomplete="shipping">
                        @if ($errors->has('shipping'))
                        <span style="color:red" class="help-block">
                            <strong>{{ $errors->first('shipping') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="shipping_cost">Shipping Cost</label>
                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost"
                            value="{{ old('shipping_cost') ?? $auction->shipping_cost }}" min="0">
                        @if ($errors->has('shipping_cost'))
                        <span style="color:red" class="help-block">
                            <strong>{{ $errors->first('shipping_cost') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">
                        @foreach ($auction->getPhotos($auction->id) as $i => $photo)
                        @if ($photo != null)
                        <div class="col-lg-4">
                            <img class="img-fluid figure-img shadow-lg" src="{{$photo->photoPath()}}"
                                onclick="pictureClick{{$i+1}}()" style="height: 15rem; width: 15rem;" id="image{{$i+1}}" alt="">
                            <input type="file" class="form-control-file" onchange="displayImage{{$i+1}}(this)" id="photo{{$i+1}}"
                                name="photo{{$i+1}}" style="display:none;">

                        </div>
                        @endif
                        @endforeach
                    </div>

                <button type="submit" class="btn btn-accent btn-lg" form="edit_auction" value="Submit">Save
                    auction</button>
                </form>
            </div>
        </div>
    </div>
    <script src={{ asset('js/dates.js') }} defer></script>
</main>
@endsection