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
                        <a href="{{ route('subscription-packages.show', $package->id) }}" class="text-decoration-none">
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
                                            <span style="font-weight: bold; margin: 0 !important;"
                                                class="text-secondary">/30
                                                Days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- buku baru --}}
        <div class="mt-4" id="buku-baru">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-yellow text-yellow-fg p-2"><i class="fa-solid fa-crown fs-3"></i></span>
                <h2 class="mt-3 text-dark">Buku Baru Di Rilis</h2>
            </div>
            <div id="wrapper-slider">
                @forelse ($latestBooks as $book)
                    <div class="px-2">
                        <div class="card" style="padding: 0.75rem; border-radius: 16px;">
                            <div class="card-body">
                                <img class="d-block mx-auto w-40 h-50" alt="{{ $book->title }}"
                                    src="{{ asset($book->cover) }}" />
                                <div class="d-flex gap-2 mt-2">
                                    <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                    <p class="badge">3+</p>
                                </div>
                                <div>
                                    <h5><span style="font-size: 0.8rem;" class="text-secondary">{{ $book->writer }}</span>
                                        <br><a href="{{ route('books.show', $book->id) }}" style="font-size: 1rem;">{{ $book->title }}</a>
                                    </h5>
                                    <h4 style="font-size: 1.2rem; font-weight: bold">Rp
                                        {{ number_format($book->price, 0, ',', '.') }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Tidak ada buku baru yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- gratis --}}
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">Buku Gratis</h2>
            </div>
            <div class="row g-4">
                @forelse ($freeBooks as $book)
                    <div class="col-md-4">
                        <div class="card d-flex flex-column h-100">
                            <div class="row row-0 flex-fill">
                                <div class="col-4">
                                    <img src="{{ asset($book->cover) }}" class="w-100 h-100 object-cover"
                                        style="border-radius: 8px 0 0 8px;" alt="{{ $book->title }}">
                                </div>
                                <div class="col">
                                    <div class="card-body h-full d-flex flex-column">
                                        <span class="badge bg-success mb-2" style="width: fit-content;"><i
                                                class="fa-solid fa-mobile"></i> PDF</span>
                                        <div class="text-secondary">
                                            {{ $book->writer }}
                                            <br><span class="text-dark fw-bold">{{ $book->title }}</span>
                                        </div>
                                        <div class="d-flex align-items-center pt-4 mt-auto">
                                            <h3 class="text-success fw-bold">Gratis</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-secondary">Belum ada buku gratis yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $('#wrapper-slider').slick({
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
