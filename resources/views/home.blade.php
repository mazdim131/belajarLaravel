@extends('layout.app')

@push('style')
    <style>
        .slick-prev::before,
        .slick-next::before {
            color: #333
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        @if (Session::get('success'))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('success') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('error') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div id="carousel-sample" class="carousel slide rounded-3 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt=""
                        src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
            </div>
            <a class="carousel-control-prev" data-bs-target="#carousel-sample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" data-bs-target="#carousel-sample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        <div class="mt-5">
            <div class="d-flex align-text-center gap-3">
                <span class="badge bg-primary text-yellow-fg p-3"><i class="fa-solid fa-crown fs-3"></i></span>
                <h1 class="mt-2 text-dark">Paket Langganan</h1>
            </div>
            <div class="row g-4">
                @foreach ($subscriptionPackages as $package)
                    <div class="col-md-4">
                        <div class="card mt-3 h-100"
                            style="background: linear-gradient(135deg, #ffffff 0%, {{ $package->color }} 200%);">
                            <div class="card-body row">
                                <div class="col-4"></div>
                                <div class="col-6 text-center text-dark">
                                    <h2 style="font-weight: bold;">{{ $package->name }}</h2>
                                    <p class="text-secondary" style="font-weight: bold; margin: 0 !important;">
                                        {{ $package->description }}</p>
                                    <div>
                                        <span style="font-size: 2rem; font-weight: bold;" class="text-warning">Rp
                                            {{ number_format($package->prices, 0, ',', '.') }}</span>
                                        <br />
                                        <span style="font-weight: bold; margin: 0 !important;" class="text-secondary">/30
                                            Days</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- buku baru rilis --}}
            <div class="mt-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary text-primary-fg p-3"><i class="fa-solid fa-history fs-3"></i></span>
                    <h1 class="mt-2 text-dark" style="">Buku Baru Di Rilis</h1>
                </div>

                <div id="wrapper-slide">
                    <div class="px-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="d-block mx-auto w-75 h-50" alt=""
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMDAMNOHEIzaKm-TtY6DhAEUzle3KRbOVrLYEC_VTaxg&s=10">

                                <div class="gap-2 mt-4 px-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i></p>
                                    <p class="badge">13+</p>
                                </div>

                                <div>
                                    <p><span style="font-size: 0.8rem" class="text-secondary">Damar Setyo</span></p>
                                    <h5><span style="font-size: 1rem" class="text-secondary">Mengenal Sahabat
                                            Lautan</span></h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp 49.000</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="px-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="d-block mx-auto w-75 h-50" alt=""
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSCaqe9qotVc7tHOzMUX1BUa8ThbRCR4WgQErBC4994w&s=10">

                                <div class="gap-2 mt-4 px-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i></p>
                                    <p class="badge">23+</p>
                                </div>

                                <div>
                                    <p><span style="font-size: 0.8rem" class="text-secondary">Maksum An-nur</span>
                                    </p>
                                    <h5><span style="font-size: 1rem" class="text-secondary">Tentang Cinta</span></h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp 89.000</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="px-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="d-block mx-auto w-75 h-50" alt=""
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwXLPHwC1S9ZNxHMhX5Hj9tDAz3ptqkld4lkaJq3QDkQ&s=10">

                                <div class="gap-2 mt-4 px-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i></p>
                                    <p class="badge">23+</p>
                                </div>

                                <div>
                                    <p><span style="font-size: 0.8rem" class="text-secondary">Noufal Kisyah</span>
                                    </p>
                                    <h5><span style="font-size: 1rem" class="text-secondary">Kala Senja Menyapa</span>
                                    </h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp 100.000</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="px-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="d-block mx-auto w-75 h-50" alt=""
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2YGgfZ_MLkkIXjwto96afP2L94K13M8EZRQ52SN2UAw&s=10">

                                <div class="gap-2 mt-4 px-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i></p>
                                    <p class="badge">23+</p>
                                </div>

                                <div>
                                    <p><span style="font-size: 0.8rem" class="text-secondary">Eka pradana</span>
                                    </p>
                                    <h5><span style="font-size: 1rem" class="text-secondary">Gerimis Pagi</span></h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp 69.000</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="px-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="d-block mx-auto w-75 h-50" alt=""
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFvItXmZlB0IZPpXJO3Ku_jT6ssoQdlWN73Cswh5lO3g&s=10">

                                <div class="gap-2 mt-4 px-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i></p>
                                    <p class="badge">23+</p>
                                </div>

                                <div>
                                    <p><span style="font-size: 0.8rem" class="text-secondary">Andrea Hirata</span>
                                    </p>
                                    <h5><span style="font-size: 1rem" class="text-secondary">Laskar Pelangi</span></h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp 70.000</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="px-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="d-block mx-auto w-75 h-50" alt=""
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB8eB0qIPB1g4N3PL2L9FdsOgrRL1Muxnsu8QvOUkX5g&s=10">

                                <div class="gap-2 mt-4 px-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i></p>
                                    <p class="badge">23+</p>
                                </div>

                                <div>
                                    <p><span style="font-size: 0.8rem" class="text-secondary">Sukatni Almunaroh</span>
                                    </p>
                                    <h5><span style="font-size: 1rem" class="text-secondary">Mengurai Benang Merah
                                            Cinta</span></h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold;">Rp 70.000</h4>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

        {{-- buku gratis --}}
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">Buku Gratis</h2>
            </div>
            <div class="row">
                <div class="col-4">

                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLDoCbUt2ijeK_WvtKYCCD6w8R3AvJRmdRWvcha6tWg&s=10"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>

                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-tittle">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary text-dark">Rp
                                                50.000</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-4">

                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLDoCbUt2ijeK_WvtKYCCD6w8R3AvJRmdRWvcha6tWg&s=10"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>

                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-tittle">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary text-dark">Rp
                                                50.000</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-4">

                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLDoCbUt2ijeK_WvtKYCCD6w8R3AvJRmdRWvcha6tWg&s=10"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>

                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-tittle">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary text-dark">Rp
                                                50.000</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-4">

                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLDoCbUt2ijeK_WvtKYCCD6w8R3AvJRmdRWvcha6tWg&s=10"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>

                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-tittle">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary text-dark">Rp
                                                50.000</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-4">

                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLDoCbUt2ijeK_WvtKYCCD6w8R3AvJRmdRWvcha6tWg&s=10"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>

                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-tittle">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary text-dark">Rp
                                                50.000</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-4">

                    <div class="card d-flex flex-column">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-3">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTLDoCbUt2ijeK_WvtKYCCD6w8R3AvJRmdRWvcha6tWg&s=10"
                                        class="w-100 h-100 object-cover" alt="card side image">
                                </a>
                            </div>

                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-tittle">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Penulis
                                        <br><span class="text-dark">Judul Buku</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary text-dark">Rp
                                                50.000</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $('#wrapper-slide').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    </script>
@endpush
