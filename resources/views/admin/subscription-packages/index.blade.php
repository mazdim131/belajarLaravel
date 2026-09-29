@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-content-between align-items-center mb-3">
            <h2>Tambah Paket Langganan</h2>
            <a href="{{ route('admin.subscription-packages.create') }}" class="justify-content-end ms-auto btn btn-primary">Tambah
                Paket Langganan</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="card container">
        <div class="card-body">
            <table class="table table-bordered table-responsive bg-white" id="subscription-packages-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket Langganan</th>
                        <th>Deskripsi</th>
                        <th>Kode Warna</th>
                        <th>Harga</th>
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
            $('#subscription-packages-table').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('admin.subscription-packages.index') }}",
                columns: [
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
                        data: 'description',
                        name: 'description',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'color',
                        name: 'color',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'prices',
                        name: 'prices',
                        orderable: false,
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
