@extends('layouts.app')

@section('title', "Modal")

@section('content')

<main>
  <div class="container">
    <div class="row">

      <div class="col-md-12">

        <div class="modal fade" id="mymodal">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Your Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h6>Rating: </h6>
                <div class="rating my-2">
                  <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
                <form id="feedback">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Your title">
                  </div>
                  <div class="form-group">
                    <label for="review">Your review</label>
                    <textarea class="form-control" id="review" rows="3" placeholder="Your review"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
        <a href="#" data-toggle="modal" data-target="#mymodal"> Open Modal</a>
      </div>
    </div>
  </div>
</main>

@endsection