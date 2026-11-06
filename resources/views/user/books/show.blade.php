@extends('layout.app')

@push('styles')
    <style>
        /* batasi teks menjadi maksimal 3 baris dan beri efek '...'' */
        .description-clamped {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* ubah angka ini untuk mengatur jumlah baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .style-width-label {
            min-width: 110px;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('carts.store') }}" method="POST">
        @csrf
        <div class="page-body">
            <div class="container-xl pb-5 bg-white p-3">
                <div class="row g-4">

                    {{-- Kolom Gambar produk (kiri) --}}
                    <div class="col-lg-5 col-md-6">
                        <div class="card border-0 shadow-sm">
                            {{-- Preview Gambar Utama --}}
                            <div class="text-center rounded bg-light p-4 mb-3"
                                style="min-height: 380px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}"
                                    class="img-fluid rounded shadow-sm" style="max-height: 350px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    {{-- Kolom informasi produk (kanan) --}}
                    <div class="col-lg-7 col-md-6">
                        <h1 class="h2 font-weight-bold text-dark mb-0">
                            {{ $book->title }}
                        </h1>

                        {{-- opsi pembelian --}}
                        <div class="mb-4">
                            <label class="form-label font-weight-bold text-muted small uppercase mb-2">Opsi
                                Pembelian</label>
                            <div class="row g-2">
                                @foreach ($book->subscriptionPackageBooks as $subscriptionPackageBook)
                                    <div class="col-auto">
                                        <label class="form-selectgroup-item">

                                            <input type="radio" name="purchase_option"
                                                value="{{ $subscriptionPackageBook->subscription_package_id }}"
                                                class="form-selectgroup-input" {{ $loop->first ? 'checked' : '' }}>

                                            <div class="form-selectgroup-label d-flex flex-column align-items-start p-3 border rounded-3 bg-light text-start"
                                                style="min-width: 180px">

                                                <span
                                                    class="text-muted small">{{ $subscriptionPackageBook->SubscriptionPackage->name }}</span>
                                                <span
                                                    class="h3 fw-bold text-dark mb-0 mt-3">Rp{{ number_format($subscriptionPackageBook->SubscriptionPackage->prices, 0, ',', '.') }}</span>
                                            </div>

                                        </label>
                                    </div>
                                @endforeach

                                <div class="col-auto">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="purchase_option" class="form-selectgroup-input">
                                        <div class="form-selectgroup-label d-flex flex-column align-items-start p-3 border rounded-3 bg-light text-start"
                                            style="min-width: 180px">
                                            <span class="text-muted small">Satuan</span>
                                            <span
                                                class="h3 fw-bold text-dark mb-0 mt-2">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- info box: akses aplikasi --}}
                        <div class="card bg-light border-0 rounded-3 mb-4">
                            <div class="card-body p-3">
                                <h5 class="mb-1 font-weight-bold">Konten ini dapat dibaca melalui aplikasi Gramedia Digital
                                </h5>
                                <p class="text-muted small mb-3">
                                    Download aplikasi Gramedia Digital yang tersedia di seluruh di seluruh perangkat ios dan
                                    Android
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                                        <i class="ti ti-brand-google-play fs-3"></i> Google Play
                                    </a>
                                    <a href="#" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                                        <i class="ti ti-brand-apple fs-3"></i> App Store
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- deskripsi buku --}}
                        <div class="mb-4">
                            <h3 class="h4 font-weight-bold mb-4">Deskripsi</h3>
                            {{-- container deskripsi dengan batas baris --}}
                            <div class="text-muted leading-relaxed mb-1 description-clamped" id="bookDescription">
                                {!! $book->description !!}
                            </div>

                            {{-- tombol toggle baca selengkapnya --}}
                            <a href="javascript:void(0)"
                                class="text-primary small font-weight-bold d-inline-flex align-items-center gap-1 mt-2"
                                id="btnReadMore" onclick="toggleDescription()">
                                <span id="readMoreText">Baca Selengkapnya</span>
                                <i class="ti ti-chevron-down" id="readMoreIcon"></i>
                            </a>
                        </div>

                        <div class="mb-4">
                            <h3 class="h4 font-weight-bold mb-3">Informasi Buku</h3>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex mb-3">
                                        <span class="text-muted style-width-label">Bahasa</span>
                                        <span class="fw-semibold">: {{ $book->languange }}</span>
                                    </div>

                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Penerbit</span>
                                        <span class="fw-semibold">{{ $book->publisher }}</span>
                                    </div>

                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Penulis</span>
                                        <span class="fw-semibold">: {{ $book->writer }}</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="d-flex mb-2">
                                        <span class="text-muted style-width-label">Tanggal Rilis</span>
                                        <span class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($book->release_data)->format('d F Y') }}
                                        </span>
                                    </div>
                                    <div class="d-flex mb-32">
                                        <span class="text-muted style-width-label">Halaman</span>
                                        <span class="fw-semibold">: {{ $book->page_of_book }} Halaman</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="fixed-bottom bg-white border-top shadow-lg py-2" style="z-index: 1020">
                            <div class="container-xl">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        {{-- informasi singkat produk --}}
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset($book->cover) }}" alt="Thumbnail" class="rounded border"
                                                style="width: 40px; height: 50px; object-fit: cover;">

                                            <div>
                                                <h4 class="mb-0 text-truncate font-weight-bold" style="max-width: 400px;">
                                                    {{ $book->title }}
                                                </h4>
                                                <span class="fw-bold text-dark h4 mb-0">Rp35.000</span>
                                            </div>
                                        </div>

                                        {{-- tombol transaksi --}}
                                        <div class="d-flex gap-2">
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            {{-- memberikan name dan value di btn biar tau dari 2 btn itu, btn mana yang legi di klik --}}
                                            <button type="submit" name="action" value="add_to_cart"
                                                class="btn outline-primary px-4 py-2 font-weight-medium">
                                                Tambah ke Keranjang
                                            </button>
                                            <button type="submit" name="action" value="buy_now"
                                                class="btn btn-primary px-4 py-2 font-weight-medium">
                                                Beli Sekarang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function toggleDescription() {
            const desc = document.getElementById('bookDescription');
            const text = document.getElementById('readMoreText');
            const icon = document.getElementById('readMoreIcon');

            if (desc.classList.contains('description-clamped')) {
                desc.classList.remove('description-clamped');
                text.innerText = 'Tutup';
                icon.classList.replace('ti-chevron-down', 'ti-chevron-up');
            } else {
                desc.classList.add('description-clamped');
                text.innerText = 'Baca Selengkapnya';
                icon.classList.replace('ti-chevron-up', 'ti-chevron-down');
            }
        }
    </script>
@endpush
