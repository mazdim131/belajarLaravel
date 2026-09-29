@extends('layout.app')
@section('content')
    <div class="card mt-5 w-50 mx-auto">
        <div class="card-header">
            <h1>Edit Paket Langganan</h1>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.subscription-packages.update', $subscriptionPackage->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Paket Langganan</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $subscriptionPackage->name) }}" required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        required>{{ old('description', $subscriptionPackage->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Kode Warna</label>
                    <input type="text" name="color" id="color"
                        class="form-control @error('color') is-invalid @enderror"
                        value="{{ old('color', $subscriptionPackage->color) }}" required>

                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="prices" class="form-label">Harga</label>
                    <input type="number" name="prices" id="prices"
                        class="form-control @error('prices') is-invalid @enderror"
                        value="{{ old('prices', $subscriptionPackage->prices) }}" required>

                    @error('prices')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection