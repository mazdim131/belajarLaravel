@extends('layout.app')

@section('content')
    {{-- syarat ketika form upload file adalah enctype --}}
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
        class="card w-75 d-block mx-auto">

        @csrf

        <div class="card-header">
            <h3>Tambah Buku</h3>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="book_category_id" class="form-label">Kategori Buku</label>
                    <select name="book_category_id" id="book_category_id" class="form-select">
                        <option disabled hidden selected>Pilih</option>
                        {{-- opsi kategori buku sesuai data yang dari controller (db) --}}
                        @foreach ($bookCategories as $category)
                            <option value="{{ $category->id }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    @error('book_category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-6">
                    <label for="writer" class="form-label">Penulis</label>
                    <input type="text" name="writer" id="writer" class="form-control" value="{{ old('writer') }}">
                    @error('writer')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" class="form-control"
                        value="{{ old('publisher') }}">
                    @error('publisher')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                        step="100">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="languange" class="form-label">Bahasa</label>
                    <select name="languange" id="languange" class="form-select">
                        <option disabled hidden selected>Pilih</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="English">English</option>
                        <option value="Japan">Japan</option>
                        <option value="Arabic">Arabic</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="release_data" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="release_data" id="release_data" class="form-control">
                    @error('release_data')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-6">
                    <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                    <input type="number" name="page_of_book" id="page_of_book" class="form-control">
                    @error('page_of_book')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="cover">Sampul Buku</label>
                    <input type="file" name="cover" id="cover" class="form-control">
                    @error('cover')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Deskripsi</label>

                <!-- Container Visual Quill -->
                <div id="description" style="min-height: 150px;"></div>

                <!-- Hidden Input untuk Menampung Value ke Laravel -->
                <input type="hidden" name="description" id="description_input" value="{{ old('description') }}">

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row" style="margin-top: 8%">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </div>
    </form>
@endsection

@push('scripts')
    <script>
        const quill = new Quill('#description', {
            theme: 'snow'
        });

        document.querySelector('#description_input').value = '-';

        quill.on('text-change', function() {
            document.querySelector('#description_input').value = quill.root.innerHTML;
        });
    </script>
@endpush
