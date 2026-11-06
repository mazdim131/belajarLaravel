@extends('layout.app')

@section('content')
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between">
            <h3>Data Buku yang akan Dipilih untuk paket langganan <b>{{ $subscriptionPackage->name }}</b></h3>
            <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        {{-- form ini mengirim pilihan buku ke route admin.subscription-packages.books.store --}}
        <form action="{{ route('admin.subscription-packages.books.store', $subscriptionPackage->id) }}" id="addBookForm"
            method="POST" id="form-paket-buku">
            @csrf
            {{-- id paket langganan yang sedang diedit --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Daftar buku</span>
                    <button type="submit" id="btnSubmitBooks" class="btn btn-primary d-none">
                        <i class="fas fa-plus me-1"></i>Tambah ke paket langganan (<span id="selectedCount">0</span>)
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mt-3" id="data-buku">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 30px;">{{-- checkbox --}}</th>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 80px;">Sampul Buku</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Katergori</th>
                                <th class="text-end" style="width: 120px;">Harga</th>
                            </tr>
                        </thead>
                        <tbody></tbody>

                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Buku</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const selectedBooks = new Set(@json($selectedBookIds));
            const table = $("#data-buku").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.subscription-packages.books', $subscriptionPackage->id) }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type) {
                            if (data['checkAdded'] === 'Ya') {
                                return ''; // Jika buku sudah ditambahkan tidak menampilkan checkbox
                            }
                            // tampilkan checkbox jika buku belum ditambahkan
                            return `<input type="checkbox" value="${data}" name="book_ids[]" class="book-checkbox">`;
                        }
                    },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'coverImg', name: 'coverImg', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'title', name: 'title' },
                    { data: 'writer', name: 'writer' },
                    { data: 'book_category_id', name: 'category.name' },
                    { data: 'price', name: 'price', className: 'text-end' }
                ]
            });

            table.on('draw.dt', function() {
                $('#data-buku .book-checkbox').each(function() {
                    $(this).prop('checked', selectedBooks.has(parseInt($(this).val())));
                });
                updateButtonVisibility();
            });

            $('#data-buku').on('change', '.book-checkbox', function() {
                const bookId = parseInt($(this).val());
                if (this.checked) {
                    selectedBooks.add(bookId);
                } else {
                    selectedBooks.delete(bookId);
                }
                updateButtonVisibility();
            });

            $('#form-paket-buku').on('submit', function() {
                var $form = $(this);
                $form.find('input[name="book_ids[]"]').remove();
                selectedBooks.forEach(function(bookId) {
                    $('<input>', {
                        type: 'hidden',
                        name: 'book_ids[]',
                        value: bookId
                    }).appendTo($form);
                });
            });

            function updateButtonVisibility() {
                let checkedCount = selectedBooks.size;
                $('#selectedCount').text(checkedCount);
                if (checkedCount > 0) {
                    $('#btnSubmitBooks').removeClass('d-none');
                } else {
                    $('#btnSubmitBooks').addClass('d-none');
                }
            }

            updateButtonVisibility();
        });
    </script>
@endpush
