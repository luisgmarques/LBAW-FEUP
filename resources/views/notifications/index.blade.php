@extends('layouts.app')

@section('title', "Notification")

@section('content')
<main id="notifications">
  <div class="container">
    <h2 class="text-header pt-4">Notifications</h2>
    <div class="accordion mt-4" id="accordionExample">
      <div class="card bg-card" id="first-question">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link text-accent" type="button" data-toggle="collapse" data-target="#collapseOne"
              aria-expanded="true" aria-controls="collapseOne">
              Unread notifications
            </button>
          </h2>
        </div>

        
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          @foreach($unread_notifications as $unread)
          <div class="card-body text-card-text">

            <div class="row d-flex align-items-center justify-content-between">
              <div class="col">
                <b class="ml-3"> {{ $unread->subject }}</b>
                <a> - </a>
                <a>{{ $unread->description }}</a>
              </div>
              <div class="col-1">
                <form action="{{ route('notifications.update', $unread) }}" method="post">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                  <input type="hidden" name="was_read" value="true">
                  <button class="btn text-accent" type="submit"><i class="fas fa-times"></i></button>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="card bg-card" id="second-question">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link text-accent collapsed" type="button" data-toggle="collapse"
              data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Read notifications
            </button>
          </h2>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          @foreach($read_notifications as $read)
          <div class="card-body text-card-text">
            <div class="row d-flex align-items-center">
              <div class="col">
                <b class="ml-3"> {{ $read->subject }}</b>
                <a> - </a>
                <a>{{ $read->description }}</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</main>
@endsection