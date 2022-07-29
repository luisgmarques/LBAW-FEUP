@extends('layouts.app')

@section('title', "Admin")

@section('content')

<main id="admin">
    <div class="container">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif

        <div class="row pt-4">
            <div class="col">
                <h2 class="text-header">Administration</h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end">
                <a href="{{ route('faq') }}" type="button" class="btn mr-3 btn-accent btn-lg"><i
                        class="far fa-edit"></i> Edit FAQ</a>
                <button type="button" id="button-admin" class="btn btn-accent btn-lg" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add
                    Category</button>


            </div>
            </div>

        <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-card">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="{{ route('category.create') }}">
                            @csrf
                            <div class="form-group mt-3 text-card-text{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
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

        <div class="row mt-5 bg-card" id="admin-table">
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                            aria-controls="nav-home" aria-selected="true">Users</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Auctions</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                            role="tab" aria-controls="nav-contact" aria-selected="true">Reports</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade in show active table-responsive-xl" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="text-center">
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @switch($user->user_status)
                                    @case('Good')
                                    <td style="color:green">{{  $user->user_status }}
                                    </td>
                                    @break

                                    @case('Warned')
                                    <td style="color:orange">{{  $user->user_status }}</td>
                                    @break

                                    @case('Banned')
                                    <td style="color:red">{{  $user->user_status }}</td>
                                    @break

                                    @endswitch
                                    <td>
                                        <div class="d-flex flex-row justify-content-around">
                                            <button type="button"
                                                class="btn btn-outline-secondary mr-5">Contact</button>
                                            <form action="{{ route('user.updateBan', $user) }}" method="post">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="user_status" value="Good">
                                                <button type="submit" class="btn btn-outline-success mr-5">Good</button>
                                            </form>
                                            <form action="{{ route('user.updateBan', $user) }}" method="post">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="user_status" value="Warned">
                                                <button type="submit" class="btn btn-outline-warning mr-5">Warn</button>
                                            </form>
                                            <form action="{{ route('user.updateBan', $user) }}" method="post">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="user_status" value="Banned">
                                                <button type="submit" class="btn btn-outline-danger mr-5">Ban</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade table-responsive-xl" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auctions as $auction)
                                <tr>
                                    <td><a href="/auction/{{ $auction->id }}">{{ $auction->item_name }}</a></td>
                                    <td>{{ $auction->description }}</td>

                                    @php $found = false @endphp
                                    @foreach ($photos as $photo)
                                        @if ($photo != null)
                                            @if ($photo->auction_id == $auction->id)
                                                @php $found = true @endphp
                                                <td><img src="{{ $photo->photoPath() }}" alt="..." class="img-fluid" width="200"></td>
                                        
                                                @php break @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    @if(!$found)
                                        <td><img src="../images/blue-hero-desktop.jpg" alt="..." class="img-fluid" width="200"></td>
                                    @endif
                                    
                                    @switch($auction->auction_status)
                                    @case('Open')
                                    <td style="color:green">{{  $auction->auction_status }}</td>
                                    @break

                                    @case('Disabled')
                                    <td style="color:orange">{{  $auction->auction_status }}</td>
                                    @break

                                    @case('Ended')
                                    <td style="color:red">{{  $auction->auction_status }}</td>
                                    @break
                                    @endswitch

                                    <td>
                                        <div class="d-flex flex-row justify-content-around">
                                            <button type="button" class="btn btn-outline-danger">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                        aria-labelledby="nav-contact-tab">
                        <table class="table-responsive">
                            <div class="accordion my-3" id="accordionExample">
                                @foreach($reports as $report)
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link text-accent collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseOne{{$report->id}}" aria-expanded="true"
                                                aria-controls="collapseOne">Report {{$report->id}}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne{{$report->id}}" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body text-card-text">
                                            <h5>User reported:</h5>
                                            <p>{{$report->getUserName()}}</p>
                                            <h5>Reported by:</h5>
                                            <p>{{$report->getAuthenticatedName()}}</p>
                                            <h5>Title:</h5>
                                            <p>{{$report->title}}</p>
                                            <h5>Description:</h5>
                                            <p>{{$report->content}}</p>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-6 col-7">
                                                    <div class="d-flex justify-content-around">

                                                        <form action="{{ route('user.updateBan', $report->toUser) }}" method="post">
                                                            <input type="hidden" name="_method" value="PUT">
                                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="user_status" value="Warned">
                                                            <button type="submit" class="btn btn-outline-warning mx-auto">Warn</button>
                                                        </form>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary mx-auto">Contact</button>
                                                        <form action="{{ route('user.updateBan', $report->toUser) }}" method="post">
                                                            <input type="hidden" name="_method" value="PUT">
                                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="user_status" value="Banned">
                                                            <button type="submit" class="btn btn-outline-danger mx-auto">Ban</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-right">
                                                        <button type="button"
                                                            class="btn btn-outline-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection