@extends('layouts.app')

@section('title', "Create")

@section('content')
<main id="sell">
    <div class="container pt-4 pb-1 px-4">
        <div class="row justify-content-md-center bg-card shadow" id="sell-form">
            <div class="col-lg-8 p-4">
                <h2 class="text-center mt-3 text-card-text">Create Auction</h2>
                <form class="text-header my-3" id="sell_form" method="POST" action="{{ route('auction.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label for="item_name">Title</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Your title" required>
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
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Your description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="starting_price">Initial price</label>
                        <input type="number" class="form-control" id="starting_price" name="starting_price" placeholder="€1.00"
                            min="1" required>
                           
                    </div>
                    <div class="form-group">
                        <label for="end_date">End date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                            
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
                        <input type="text" class="form-control" id="shipping" name="shipping" placeholder="Worldwide" required>
                    </div> 
                    <div class="form-group">
                        <label for="shipping_cost">Shipping Cost</label>
                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost" placeholder="€1.00"
                            min="1" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <img class="img-fluid figure-img shadow-lg" src="../images/photo.png" onclick="pictureClick1()" style="height: 15rem; width: 15rem;" id="image1" alt="">
                            <input type="file" class="form-control-file" onchange="displayImage1(this)" id="photo1" name="photo1" style = "display:none;" required>

                        </div>
                        <div class="col-lg-4">
                            <img class="img-fluid figure-img shadow-lg" src="../images/photo.png" onclick="pictureClick2()" style="height: 15rem; width: 15rem;" id="image2" alt="">
                            <input type="file" class="form-control-file" onchange="displayImage2(this)" id="photo2" name="photo2" style = "display:none;">

                        </div>
                        <div class="col-lg-4">
                            <img class="img-fluid figure-img shadow-lg" src="../images/photo.png" onclick="pictureClick3()" style="height: 15rem; width: 15rem;" id="image3" alt="">
                            <input type="file" class="form-control-file" onchange="displayImage3(this)" id="photo3" name="photo3" style = "display:none;">

                        </div>
                    </div>
                </form>

                <button type="submit" class="btn btn-accent btn-lg" form="sell_form" value="Submit">Submit</button>

            </div>
        </div>
    </div>
    <script src={{ asset('js/dates.js') }} defer></script>
</main>
@endsection
