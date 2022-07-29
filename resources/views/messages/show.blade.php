@extends('layouts.app')

@section('title', "Messages")

@section('content')

<main id="message">
    <div class="container">
        <div class="row my-4"> </div>
        <div class="row shadow">
            <div class="col-lg-3 bg-secondary">
                <div class="contact-info text-header">
                    <i class="fas fa-envelope fa-5x"></i>
                </div>
            </div>
            <div class="col-lg-9 bg-card">
                <div class="contact-form">
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-card-text">From:</label>
                        <div class="col-sm-10">
                            <p>{{ $message->getUser($message->sender_id)->username }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-card-text">To:</label>
                        <div class="col-sm-10">
                            <p>{{ $message->getUser($message->receiver_id)->username }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-card-text">Date:</label>
                        <div class="col-sm-10">
                            <p>{{ $message->date }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-card-text">Message:</label>
                        <div class="col-sm-10">
                            <p>{{ $message->message }}</p>
                        </div>
                    </div>
                    @if(auth()->user()->id != $message->sender_id)
                    <div class="form-group my-auto">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-accent" data-toggle="modal" data-target="#exampleModal">Reply</button>
                        </div>
                    </div>
                    @endif
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content bg-card">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">Reply Message</h4>
                                    <div class="col-1 text-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-body">

                                    <form method="POST" action="{{ route('messages.create') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group mt-3 text-card-text{{ $errors->has('message') ? ' has-error' : '' }}">
                                            <label for="message_send">Message</label>
                                            <input type="hidden" name="receiver_id" value="{{$message->sender_id}}">
                                            <input type="text" class="form-control" name="message" id="message_send" placeholder="" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-accent" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-accent">Send</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 

@endsection
