<div class="col-lg-4">
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