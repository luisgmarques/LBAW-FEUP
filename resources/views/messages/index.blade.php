@extends('layouts.app')

@section('title', "Messages")

@section('content')

<main id="messages">
  <div class="container">
    <div class="row">
      <div class="col">
        <h2 class="text-header pt-4">Messages</h2>
      </div>
      <div class="col pt-4 d-flex align-items-center justify-content-end">
        <button type="button" id="button-admin" class="btn btn-accent btn-lg" data-toggle="modal"
          data-target="#exampleModal"><i class="fas fa-plus"></i> Add
          Message</button>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content bg-card">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Add Message</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form method="POST" action="{{ route('messages.create') }}">
                {{ csrf_field() }}
                <div class="form-group mt-3 text-card-text{{ $errors->has('receiver_id') ? ' has-error' : '' }}">
                  <label for="message">To</label>
                  <input type="text" class="form-control" name="receiver_id" id="receiver_id" placeholder="" required>
                </div>
                <div class="form-group mt-3 text-card-text{{ $errors->has('message') ? ' has-error' : '' }}">
                  <label for="message">Message</label>
                  <input type="text" class="form-control" name="message" id="message" placeholder="" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-accent" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-accent">Save changes</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="accordion mt-4" id="accordionExample">
      <div class="card bg-card" id="first-question">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link text-accent" type="button" data-toggle="collapse" data-target="#collapseOne"
              aria-expanded="true" aria-controls="collapseOne">
              Messages Sent
            </button>
          </h2>
        </div>

        @foreach($messages_sender as $message_sender)

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body text-card-text">

            <div class="row d-flex align-items-center justify-content-between">
              <div class="col">
                <a class="ml-3">{{ $message_sender->getUser($message_sender->receiver_id)->username }}</a>
              </div>
              <div class="col text-right">
                <a>{{$message_sender->date}}</a>
              </div>
              <div class="col-4 text-right">
                <a href="/messages/{{ $message_sender->id }}" class="btn btn-accent"><i class="far fa-envelope"></i> See
                  message</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="card bg-card" id="second-question">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link text-accent collapsed" type="button" data-toggle="collapse"
              data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Messages Received
            </button>
          </h2>
        </div>

        @foreach($messages_receiver as $message_receiver)
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body text-card-text">
            <div class="row d-flex align-items-center">
              <div class="col">
                <a class="ml-3"> {{ $message_receiver->getUser($message_receiver->sender_id)->username }}</a>
              </div>
              <div class="col text-right">
                <a>{{$message_receiver->date}}</a>
              </div>
              <div class="col-4 text-right">
                <a href="/messages/{{ $message_receiver->id }}" class="btn btn-accent"><i class="far fa-envelope"></i>
                  See message</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</main>

@endsection