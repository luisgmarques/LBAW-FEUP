@extends('layouts.app')

@section('title', "Profile")

@section('content')
<main id="profile">
    <div class="container">
        @if (session('status'))
        <div class="alert alert-success col-12 d-flex justify-content-center">
            {{ session('status') }}
        </div>
        @endif
        <div class="row pt-4">
            <div class="col">
                <h2 class="text-header">Profile</h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end">
                @can('update', $user)
                
                <a href="{{ route('profile.edit', $user) }}" class="btn btn-accent btn-lg mr-3"><i
                        class="far fa-edit"></i> Edit</a>

                @endcan

                @can('softDelete', $user)
                <a href="{{ route('profile.delete', $user) }}" class="btn btn-accent btn-lg"><i class="far fa-edit"></i>
                    Delete Account</a>
                @endcan

                @if(auth()->user()->id != $user->id)


                    <button type="button" class="btn mr-3 btn-accent btn-lg" data-toggle="modal" data-target="#exampleModalMlg"><i class="far fa-edit"></i>
                        Report
                      </button>
              
                      <div class="modal fade" id="exampleModalMlg" tabindex="-1" role="dialog" aria-labelledby="exampleModalMlgLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalMlgLabel">Report</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('report.add', $user) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <div class="form-group mt-3 text-card-text{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="" required>
                                    </div>
                                    <div class="form-group mt-3 text-card-text{{ $errors->has('content') ? ' has-error' : '' }}">
                                        <label for="content1">Content</label>
                                        <input type="text" class="form-control" name="content" id="content1" placeholder="" required>
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


                      <button type="button" class="btn btn-accent btn-lg" data-toggle="modal" data-target="#exampleModalMlg2"><i class="far fa-edit"></i>
                        Leave a review
                      </button>
              
                      <div class="modal fade" id="exampleModalMlg2" tabindex="-1" role="dialog" aria-labelledby="exampleModalMlgLabel2" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalMlgLabel2">Leave a review</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('review.add', $user) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="seller_id" value="{{$user->id}}">
                                    <div class="form-group mt-3 text-card-text{{ $errors->has('rating') ? ' has-error' : '' }}">
                                        <label for="rating">Rating (1-5)</label>
                                        <input type="number" class="form-control" min="1" max="5" name="rating" id="rating" placeholder="" required>
                                    </div>
                                        <div class="form-group mt-3 text-card-text{{ $errors->has('comment') ? ' has-error' : '' }}">
                                            <label for="comment">Tell us what you thought</label>
                                            <input type="text" class="form-control" name="comment" id="comment" placeholder="" required>
                                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-accent" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-accent">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                @endif



            </div>
        </div>
        <div class="row py-3">
            <div class="col-3">
                <img class="img-fluid rounded-circle" src="{{ $user->profilePicture() }}" alt="profile image">
            </div>

            <div class="col my-auto text-card">
                <h5>Name: {{ $user->first_name . ' ' . $user->last_name }}</h5>
                <h5>Username: {{ $user->username }}</h5>
                <h5>Email: {{ $user->email }}</h5>
                <h5>Address: {{ $user->address }}</h5>
                <h5>Zip Code: {{ $user->zip_code}}</h5>
            </div>
            <div class="col-lg my-auto text-card text-center">
                @switch($user->user_status)
                @case('Good')
                <h5 style="color:green">{{ $user->user_status }}</h5>
                @break

                @case('Warned')
                <h5 style="color:orange">{{ $user->user_status }}</h5>
                @break

                @case('Banned')
                <h5 style="color:red">{{ $user->user_status }}</h5>
                @break

                @endswitch
                @if($user->getRating() == 0)
                        <h6>No reviews yet</h6>
                    @endif
                @for($i=0; $i<$user->getRating();$i++)
                    <i class="fa fa-star text-accent"></i>
                    @endfor
            </div>
        </div>
        <div class="row bg-card" id="profile-table">
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                            aria-controls="nav-home" aria-selected="true">Reviews</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Auctions</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @foreach($user->myReviews as $review)

                        <div class="row mt-3">
                            <div class="col-lg-3 text-center image-size">
                                <img class="img-fluid rounded-circle h-50" src="{{ $review->buyer->profilePicture() }}"
                                    alt="admin_image">
                            </div>
                            <div class="col-lg-9">
                                @for($i=0; $i<$review->rating; $i++)
                                    <i class="fas fa-star text-accent"></i>
                                    @endfor
                                    <p class="mt-1">{{ $review->comment }}</p>
                                    <h4 class="text-right">{{ '@'.$review->buyer->username }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table-responsive">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->auctions as $auction)
                                <tr>
                                    <td>
                                        <a href="/auction/{{ $auction->id }}">
                                            @if ($auction->getPhotos($auction->id)->first() != null)
                                            <img src="{{ $auction->getPhotos($auction->id)->first()->photoPath() }}" alt="..."
                                                class="img-fluid rounded"
                                                style="max-width: 100px;">
                                            @else
                                            <img src="storage/uploads/banana.jpg" alt="..."
                                                class="img-fluid rounded"
                                                style="max-width: 100px;">
                                            @endif
                                        </a>

                                    </td>
                                    <td><a class="ml-3">{{ $auction->description }}</a></td>
                                    <td><a href="#" class="btn btn-outline-danger">Delete</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection