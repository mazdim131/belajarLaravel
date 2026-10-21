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
        <form action="{{ route('admin.subscription-packages.books.store') }}" method="POST" id="form-paket-buku">
            @csrf
            {{-- id paket langganan yang sedang diedit --}}
            <input type="hidden" name="subscription_package_id" value="{{ $subscriptionPackage->id }}">

            <div class="mb-3">
                <label for="expired_date" class="form-label">Tanggal Berakhir Buku</label>
                <input type="date" class="form-control" id="expired_date" name="expired_date"
                    value="{{ old('expired_date', now()->addMonth()->format('Y-m-d')) }}">
                @error('expired_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <table class="table table-bordered mt-3" id="data-buku">
                <thead>
                    <tr>
                        <th></th> {{-- checkbox --}}
                        <th>#</th>
                        <th>Sampul Buku</th>
                        <th>Judul</th>
                        <th>Katergori</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody></tbody>

            </table>

            <button type="submit" class="btn btn-primary mt-3">Simpan Buku</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // daftar id buku yang sudah tertaut ke paket ini, diisi dari server
            // dipakai supaya checkbox tetap tercentang walau tabel di ganti halamannya
            const selectedBooks = new Set(@json($selectedBookIds));

            const table = $("#data-buku").DataTable({
                //menampilkan ikon loading
                processing: true,
                // menggunakan server side (data diproses di controller)
                serverSide: true,
                // routing yang memproses datatables
                // diarahkan ke route paket ini, bukan daftar buku semua
                ajax: "{{ route('admin.subscription-packages.books', $subscriptionPackage->id) }}",
                // isi td dari tablenya
                columns: [
                    // data dan name : nama kolom, seacrhable : bisa di seacrh ga datanya, orderable: bisa di urutin ga datanya
                    {
                        // yg dikirim ketika ceklis buku itu idnya karena yg diperlukan subscription itu book_id
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                        // sama kaya editcolumn di serverside
                        render: function(data, type, row) {
                            // (data) isinya data: 'id'
                            // (row) berisi data buku ini, termasuk is_selected yang menandai buku ini sudah tertaut atau belum
                            if (type !== 'display') {
                                return data;
                            }
                            // nama attribute sengaja dikosongkan, karena input book_id[] dibuat
                            // sendiri oleh javascript saat form dikirim (lihat event submit di bawah)
                            return `<input type="checkbox" value="${data}" class="form-check-input book-checkbox">`;
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'coverImg',
                        name: 'coverImg',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    // data : dari nama field/addcolumn/editcolumn
                    // name: category.name : untuk search/sort carinya dari relasi
                    {
                        data: 'book_category_id',
                        name: 'category.name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },

                ]
            });

            // setiap tabel selesai digambar ulang (ganti halaman, cari, atau sort)
            // checkbox dibuat ulang oleh DataTables, jadi centangnya perlu disamakan
            // dengan daftar selectedBooks
            table.on('draw.dt', function() {
                $('#data-buku .book-checkbox').each(function() {
                    $(this).prop('checked', selectedBooks.has(parseInt($(this).val())));
                });
            });

            // simpan atau hapus id buku dari daftar selectedBooks sesuai kondisi checkbox
            $('#data-buku').on('change', '.book-checkbox', function() {
                const bookId = parseInt($(this).val());

                if (this.checked) {
                    selectedBooks.add(bookId);
                } else {
                    selectedBooks.delete(bookId);
                }
            });

            // saat form dikirim, buat input hidden book_id[] dari daftar selectedBooks
            // ini diperlukan karena DataTables server side hanya menampilkan isi halaman
            // yang sedang dibuka, sedangkan selectedBooks menyimpan pilihan dari semua halaman
            $('#form-paket-buku').on('submit', function() {
                $(this).find('input[name="book_id[]"]').remove();

                selectedBooks.forEach(function(bookId) {
                    $('<input>', {
                        type: 'hidden',
                        name: 'book_id[]',
                        value: bookId
                    }).appendTo(this);
                }, this);
            });

        });
    </script>
@endpush
