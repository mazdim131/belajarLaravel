@extends('layout.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex">
            <h1>@isset($category)Kategori {{ $category->name }}@endisset</h1>

            <form method="GET" action="{{ route('searchCategory') }}" class="input-icon justify-content-end ms-auto py-2">
                @isset($category)
                    <input type="hidden" name="category" value="{{ $category->slug }}">
                @endisset
                <input type="text" value="{{ request('p') }}" name="p" class="form-control rounded-3"
                    placeholder="Cari Judul atau Penulis..." />
                {{-- <button type="submit" class="input-icon-addon btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="5" y2="15" />
                            </svg>
                        </button> --}}
            </form>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <select name="sort" onchange="location = this.value;" class="form-select w-auto">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ ($sort ?? 'latest') === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ ($sort ?? 'latest') === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
            </select>
        </div>

        <div class="row g-4 mt-3">
            @forelse ($books as $book)
                <div class="col-md-4">
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
                                        <h3 class="fw-bold {{ $book->price == 0 ? 'text-success' : 'text-primary' }}">
                                            {{ $book->price == 0 ? 'Gratis' : 'Rp ' . number_format($book->price, 0, ',', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-secondary">Buku tidak tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
