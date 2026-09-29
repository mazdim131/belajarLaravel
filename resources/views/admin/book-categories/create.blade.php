@extends('layout.app')

@section('content')
    <div class="card mt-5 w-50 d-block mx-auto">
        <div class="card-header">
            <h1>Tambah Kategori Buku</h1>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.book-categories.store') }}" method="POST">
                {{-- setiap form harus memiliki method POST/GET selain itu gunakan fungsi @method() --}}
                @csrf
                {{-- csrf digunakan untuk mencegah request yang tidak sah --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feeback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
