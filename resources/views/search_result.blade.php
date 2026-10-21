@extends('layout.app')

@section('content')
    <div class="container py-4">
        <h2>Hasil Pencarian: {{ $query }}</h2>

        <div class="row mt-3">
            @forelse ($books as $book)
                <div class="col-md-4 mb-3">
                    <div class="card d-flex flex-column h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-4">
                                <img src="{{ asset($book->cover) }}" class="w-100 h-100 object-cover"
                                    style="border-radius: 8px 0 0 8px;" alt="{{ $book->title }}">
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <div class="text-secondary">
                                        {{ $book->writer }}
                                        <br><span class="text-dark fw-bold">{{ $book->title }}</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3 class="{{ $book->price == 0 ? 'text-success' : '' }} fw-bold">
                                            {{ $book->price == 0 ? 'Gratis' : 'Rp ' . number_format($book->price, 0, ',', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            <p>Tidak ada hasil yang ditemukan.</p>
        @endforelse
        </div>
    </div>
@endsection
