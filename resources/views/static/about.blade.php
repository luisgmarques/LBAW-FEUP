@extends('layouts.app')

@section('title', "About")

@section('content')

<main id="about">
    <div class="container">
        <div class="row">
            <h2 class="text-header m-3 mt-4"> About UP Auctions</h2>

        </div>

        <div class="row text-header px-3">
            <p>UP auctions is an online auction application, that allows users to auction and bid on a wide variety of
                goods worldwide. <br> Our main purpose is helping people find the products they need with a safe
                experience and a user-friendly interface. </p>

        </div>
        <div class="row">
            <h3 class="text-header my-3 mx-3"> The Team: </h3>

        </div>
        <div class="row text-center mb-3">
            <div class="col-lg-3 my-2">
                <div class="card shadow bg-card">
                    <img class="card-img-top" src="../images/brandao.jpg" alt="brandao">
                    <div class="card-img-overlay">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-secondary">João Brandão</h5>
                        <p class="card-text text-card-text">João Francisco de Pinho Brandão
                            up201705573@fe.up.pt</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 my-2">
                <div class="card shadow bg-card">
                    <img class="card-img-top" src="../images/mota.jpg" alt="mota">
                    <div class="card-img-overlay">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-secondary">João Mota</h5>
                        <p class="card-text text-card-text">João Pedro Pinto Mota
                            up201704567@fe.up.pt</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 my-2">
                <div class="card shadow bg-card">
                    <img class="card-img-top" src="../images/luis.jpg" alt="luis">
                    <div class="card-img-overlay">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-secondary">Luís Marques</h5>
                        <p class="card-text text-card-text">Luís Miguel Guimas Marques
                            ei11159@fe.up.pt</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 my-2">
                <div class="card shadow bg-card">
                    <img class="card-img-top" src="../images/pedro.jpg" alt="pedro">
                    <div class="card-img-overlay">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-secondary">Pedro Teixeira</h5>
                        <p class="card-text text-card-text">Pedro Miguel Afonso Teixeira
                            up201505916@fe.up.pt</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection