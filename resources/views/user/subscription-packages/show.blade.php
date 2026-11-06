@extends('layout.app')

@section('content')
    <div class="container py-4">
        {{-- Package header card --}}
        <div class="card mb-4"
            style="background: linear-gradient(135deg, #ffffff 0%, {{ $subscriptionPackage->color }} 200%);">
            <div class="card-body row">
                <div class="col-4"></div>
                <div class="col-6 text-center text-dark">
                    <h2 style="font-weight: bold;">{{ $subscriptionPackage->name }}</h2>
                    <p class="text-secondary" style="font-weight: bold; margin: 0 !important;">
                        {{ $subscriptionPackage->description }}</p>
                    <div>
                        <span style="font-size: 2rem; font-weight: bold;" class="text-warning">Rp
                            {{ number_format($subscriptionPackage->prices, 0, ',', '.') }}</span>
                        <br />
                        <span style="font-weight: bold; margin: 0 !important;" class="text-secondary">/30
                            Days</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search bar --}}
        <div class="d-flex py-4 gap-3">
            <form method="GET" action="{{ route('subscription-packages.show', $subscriptionPackage->id) }}"
                class="input-icon w-100 mb-4">
                <input type="text" value="{{ request('search') }}" name="search"
                    class="form-control form-control-rounded" placeholder="Cari buku berdasarkan judul..." />
            </form>

            <a href="{{ route('subscription-packages.checkout.page', $subscriptionPackage->id) }}" class="btn btn-primary">Langganan Sekarang</a>
        </div>

        {{-- Books list --}}
        <div class="row g-4 mt-2">
            @forelse ($books as $book)
                <div class="col-md-4">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-4">
                                <img src="{{ asset($book->Book->cover) }}" class="w-100 h-100 object-cover"
                                    style="border-radius: 8px 0 0 8px;" alt="{{ $book->Book->title }}">
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <span class="badge bg-info mb-2" style="width: fit-content;"><i
                                            class="fa-solid fa-mobile"></i> PDF</span>
                                    <div class="text-secondary">
                                        {{ $book->Book->writer }}
                                        <br><span class="text-dark fw-bold">{{ $book->Book->title }}</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3
                                            class="fw-bold {{ $book->Book->price == 0 ? 'text-success' : 'text-primary' }}">
                                            {{ $book->Book->price == 0 ? 'Gratis' : 'Rp ' . number_format($book->Book->price, 0, ',', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-secondary">Tidak ada buku yang tersedia pada paket langganan ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($books->hasPages())
            <div class="mt-4">
                {{ $books->appends(['search' => request('search')])->links() }}
            </div>
        @endif
    </div>
@endsection
