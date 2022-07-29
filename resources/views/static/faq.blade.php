@extends('layouts.app')

@section('title', "FAQ")

@section('content')
<main id="faq">
  <div class="container">
    @if(session()->has('message'))
    <div class="alert alert-success">
      {{ session()->get('message') }}
    </div>
    @endif
    @if(auth()->user() == null)
        <h2 class="text-header pt-4">Frequently Asked Questions</h2>
      @elseif(auth()->user()->is_admin)
    <div class="row pt-4">
      <div class="col">
        <h2 class="text-header">Frequently Asked Questions</h2>
      </div>

      <div class="col d-flex align-items-center justify-content-end">
        <button type="button" class="btn btn-accent btn-lg" data-toggle="modal" data-target="#exampleModal"><i
            class="far fa-edit"></i>
          Add FAQ
        </button>
      </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-card">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Add FAQ</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form method="POST" action="{{ route('faq.create') }}">
              {{ csrf_field() }}
              <div class="form-group mt-3 text-card-text{{ $errors->has('question') ? ' has-error' : '' }}">
                <label for="question">Question</label>
                <input type="text" class="form-control" name="question" id="question" placeholder="" required>

              </div>
              <div class="form-group mt-3 text-card-text{{ $errors->has('answer') ? ' has-error' : '' }}">
                <label for="answer">Answer</label>
                <input type="text" class="form-control" name="answer" id="answer" placeholder="" required>
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
    @else
    <h2 class="text-header pt-4">Frequently Asked Questions</h2>
    @endif
    <div class="accordion mt-4" id="accordionExample">
      @foreach($faqs as $key => $faq)
      @if ($key == 0)
      <div class="card bg-card" id="first-question">
        <div class="card-header" id="headingOne">
          <div class="row d-flex align-items-center">
            <div class="col">
              <button class="btn btn-link text-accent" type="button" data-toggle="collapse"
                data-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                {{ $faq->question }}
              </button>
            </div>
            @if(auth()->user() == null)
            @elseif (auth()->user()->is_admin)
            <div class="col-3 text-right">
              <button type="button" class="btn btn-accent btn px-3" data-toggle="modal" data-target="#exampleModal2"><i
                  class="far fa-edit"></i>
              </button>

              <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $key }}"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content bg-card">
                    <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel{{ $key }}">Edit FAQ</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form method="POST" action="{{ route('faq.update', $faq) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="form-group mt-3 text-left text-card-text{{ $errors->has('question') ? ' has-error' : '' }}">
                          <label for="question">Question</label>
                          <input type="text" class="form-control" name="question" id="question{{ $key }}"
                            value="{{ $faq->question }}" required>

                        </div>
                        <div class="form-group text-left mt-3 text-card-text{{ $errors->has('answer') ? ' has-error' : '' }}">
                          <label for="answer">Answer</label>
                          <input type="text" class="form-control" name="answer" id="answe{{ $key }}" value=" {{ $faq->answer }}"
                            required>
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
            @endif
          </div>
        </div>
        <div id="collapseOne{{$key}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body text-card-text">
            {{ $faq->answer }}
          </div>
        </div>
      </div>
      @else
      <div class="card bg-card">
        <div class="card-header" id="headingTwo{{ $key }}">
          <div class="row d-flex align-items-center">
            <div class="col">
              <button class="btn btn-link text-accent collapsed" type="button" data-toggle="collapse"
                data-target="#collapseTwo{{ $key }}" aria-expanded="false" aria-controls="collapseTwo{{ $key }}">
                {{ $faq->question }}
              </button>
            </div>
            @if(auth()->user() == null)
            @elseif (auth()->user()->is_admin)
            <div class="col-3 text-right">
              <button type="button" class="btn btn-accent btn px-3" data-toggle="modal"
                data-target="#exampleModal2{{ $key}}"><i class="far fa-edit"></i>
              </button>

              <div class="modal fade" id="exampleModal2{{ $key}}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel{{ $key }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content bg-card">
                    <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel{{ $key }}">Edit FAQ</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form method="POST" action="{{ route('faq.update', $faq) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="form-group mt-3 text-left text-card-text{{ $errors->has('question') ? ' has-error' : '' }}">
                          <label for="question{{ $key }}">Question</label>
                          <input type="text" class="form-control" name="question" id="question{{ $key }}"
                            value="{{ $faq->question }}" required>

                        </div>
                        <div class="form-group mt-3 text-left text-card-text{{ $errors->has('answer') ? ' has-error' : '' }}">
                          <label for="answer{{ $key }}">Answer</label>
                          <input type="text" class="form-control" name="answer" id="answer{{ $key }}" value=" {{ $faq->answer }}"
                            required>
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
            @endif

          </div>
        </div>
        <div id="collapseTwo{{ $key }}" class="collapse" aria-labelledby="headingTwo{{ $key }}" data-parent="#accordionExample">
          <div class="card-body text-card-text">
            {{ $faq->answer }}
          </div>
        </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</main>
@endsection