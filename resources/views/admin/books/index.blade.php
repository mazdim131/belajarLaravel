@extends('layout.app')

@section('content')
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success my-3">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between">
            <h3>Data Buku</h3>
            <div>
                <a href="{{ route('admin.books.export') }}" class="btn btn-success">Export Data</a>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Data Buku</a>
            </div>
        </div>

        <table class="table table-bordered mt-3" id="data-buku">
            <thead>
                <tr>
                    <th class="text-center" style="width: 30px;"></th>
                    <th>#</th>
                    <th>Sampul Buku</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#data-buku").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type) {
                            if (type !== 'display') {
                                return data;
                            }
                            return '<div class="text-center"><input type="checkbox" value="' +
                                data + '" class="book-checkbox"></div>';
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'coverImg',
                        name: 'coverImg',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'book_category_id',
                        name: 'category.name'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        className: 'text-end'
                    },
                ]
            });
        })
    </script>
@endpush
