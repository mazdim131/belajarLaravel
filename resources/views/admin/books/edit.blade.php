@extends('layout.app')

@section('content')
    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="card w-75 d-block mx-auto">
        @csrf
        @method('PUT')
        <div class="card-header">
            <h3>Edit Data Buku</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="book_category_id" class="form-label">Kategori Buku</label>
                    <select name="book_category_id" id="book_category_id" class="form-select">
                        <option disabled hidden>Pilih Kategori Buku</option>
                        @foreach ($bookCategories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>{{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title)}}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="writer" class="form-label">Penulis</label>
                    <input type="text" name="writer" id="writer" class="form-control" value="{{ old('writer', $book->writer)}}">
                    @error('writer')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" value="{{ old('publisher', $book->publisher)}}">
                    @error('publisher')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $book->price)}}">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="languange" class="form-label">Bahasa</label>
                    @php
                        $language = [
                            'Indonesia' => 'Indonesia',
                            'English' => 'English',
                            'Japan' => 'Japan',
                            'Arabic' => 'Arabic',
                        ];
                    @endphp
                    <select name="languange" id="languange" class="form-select">
                        <option value="" disabled hidden>Pilih Bahasa</option>
                        @foreach ($language as $lang)
                            <option value="{{ $lang}}"
                                {{ old('languange', $book->languange) == $lang ? 'selected' : '' }}> {{ $lang}}
                            </option>
                        @endforeach
                    </select>
                    @error('languange')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="release_date" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date', $book->release_data) }}">
                    @error('release_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="page_of_book" class="form-label">jumlah halaman</label>
                    <input type="number" name="page_of_book" id="page_of_book" class="form-control" value="{{ old('page_of_book', $book->page_of_book) }}">
                    @error('page_of_book')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="cover" class="form-label">Sampul Buku</label>
                    {{-- preview sampul lama --}}
                    @if($book->cover)
                        <div class ="mb-2">
                            <img src="{{ asset($book->cover) }}" alt="cover {{ $book->title }}" class="img-thumbnail" style="max-height: 120px">
                            <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah sampul</small>
                        </div>
                    @endif

                    <input type="file" name="cover" id="cover" class="form-control">
                    @error('cover')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="description">
                    </div>
                        <input type="hidden" name="description" id="description-input" value="{{ old('description', $book->description) }}">

                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row" style="margin-top: 8%">
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Ubah Data</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    {{-- library DOMpurify untuk sanitasi XSS agar aman --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.8/purify.min.js">
    </script>

    <script>
        const quill = new Quill('#description', {
            theme: 'snow'
        });

        const descriptionInput = document.getElementById('description-input');

        // isi editor dengan nilai lama jika ada
        if (descriptionInput && descriptionInput.value) {
            quill.root.innerHTML = descriptionInput.value;
        }

        // update nilai hidden ketika editor berubah
        quill.on('text-change', function() {
            document.querySelector('#description-input').value = quill.root.innerHTML;
        });
    </script>
@endpush
