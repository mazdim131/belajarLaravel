@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-content-between align-items-center mb-3">
            <h2>Kategori Buku</h2>
            <div class="justify-content-end ms-auto">
                <a href="{{ route('admin.book-categories.export') }}" class="btn btn-success">Export Data</a>
                <a href="{{ route('admin.book-categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="card container">
        <div class="card-body">
            <table class="table table-bordered table-responsive bg-white" id="book-categories-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#book-categories-table").DataTable({
                //menampilkan ikon loading
                processing: true,
                // menggunakan server side (data diproses di controller)
                serverSide: true,
                // routing yang memproses datatables
                ajax: "{{ route('admin.book-categories.index') }}",
                // isi td dari table nya
                columns: [
                    // data dan name : nama kolom, seacrhable : bisa di seacrh ga datanya, orderable: bisa di urutin ga datanya
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        })
    </script>
@endpush
