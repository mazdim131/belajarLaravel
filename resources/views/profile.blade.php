@extends('layout.app')

@push('style')
    <style>
        .profile-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            font-weight: 700;
            /* background: linear-gradient(135deg, #206bc4, #4299e1); */
            color: #fff;
        }

        .book-cover-wrap {
            height: 220px;
            overflow: hidden;
            background: #f1f5f9;
        }

        .book-cover-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl py-4">
            <div class="row g-4">
                {{-- Sidebar profil --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="bg-primary profile-avatar mx-auto mb-3">
                                {{ strtoupper(mb_substr($profile->name, 0, 2)) }}
                            </div>

                            <h2 class="mb-1">{{ $profile->name }}</h2>
                            <div class="text-secondary">{{ $profile->email }}</div>
                        </div>

                        <hr>

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="card-title mb-0">Paket Langganan</h3>
                                <span class="badge bg-blue-lt">{{ $totalSubscriptionPackagesUser }} paket</span>
                            </div>

                            @forelse ($showSubscriptionPackage as $sp)
                                <div class="subscription-item">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start gap-2">
                                                <div>
                                                    <div class="fw-bold">
                                                        {{ $sp->SubscriptionPackage->name ?? 'Paket' }} Package
                                                    </div>
                                                    <div class="text-secondary small">
                                                        Berakhir
                                                        {{ $sp->expired_date }}
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <div class="fw-bold text-warning">
                                                        Rp
                                                        {{ number_format($sp->SubscriptionPackage->prices ?? 0, 0, ',', '.') }}
                                                    </div>
                                                    <span class="badge bg-success-lt">Aktif</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-secondary py-3">
                                    Belum ada paket langganan.
                                </div>
                            @endforelse
                        </div>

                        <div class="card-body border-top">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="h1 mb-0">{{ $totalCheckoutsUser }}</div>
                                    <div class="text-secondary small">Koleksi Buku</div>
                                </div>
                                <div class="col-4">
                                    <div class="h1 mb-0">{{ $totalSubscriptionPackagesUser }}</div>
                                    <div class="text-secondary small">Langganan</div>
                                </div>
                                <div class="col-4">
                                    <div class="h1 mb-0">{{ $showBookOfSubscription->count() }}</div>
                                    <div class="text-secondary small">Buku Paket</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Koleksi buku --}}
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h1 class="page-title mb-1">Koleksi Buku</h1>
                            <div class="text-secondary">
                                Buku yang tersedia dari paket langganan aktif Anda.
                            </div>
                        </div>
                    </div>

                    <div class="row row-cards">
                        @forelse ($showBookOfSubscription as $sbos)
                            <div class="col-sm-6 col-xl-4">
                                <div class="card h-100">
                                    <div class="book-cover-wrap">
                                        <img src="{{ asset($sbos->Book->cover) }}" alt="{{ $sbos->Book->title }}">
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h3 class="card-title mb-1">
                                            {{ $sbos->Book->title ?? 'Buku'}}
                                        </h3>

                                        <div class="text-secondary small mb-2">
                                            {{ $sbos->Book->writer ?? 'Penulis tidak tersedia' }}
                                        </div>

                                        <p class="text-secondary small mb-3">
                                            {{ $sbos->Book->description ?? 'Deskripsi belum tersedia.' }}
                                        </p>

                                        <div class="d-flex align-items-center justify-content-between mt-auto">
                                            <span class="badge bg-blue-lt">
                                                {{ $sbos->Book->page_of_book ?? 0 }} halaman
                                            </span>
                                            <a href="#" class="btn btn-primary btn-sm">
                                                Baca
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty">
                                    <p class="empty-title">Belum ada buku</p>
                                    <p class="empty-subtitle text-secondary">
                                        Buku dari paket langganan aktif akan muncul di sini.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Daftar Transaksi --}}
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">Daftar Transaksi</h3>
                            <select class="form-select form-select-sm w-auto" onchange="window.location.href=this.value">
                                <option value="{{ route('profile', ['type' => 'subscription']) }}"
                                    {{ $type === 'subscription' ? 'selected' : '' }}>
                                    Paket Langganan
                                </option>
                                <option value="{{ route('profile', ['type' => 'checkout']) }}"
                                    {{ $type === 'checkout' ? 'selected' : '' }}>
                                    Buku
                                </option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    @if ($type === 'subscription')
                                        <tr>
                                            <th>Tanggal Dibuat</th>
                                            <th>Nama Paket</th>
                                            <th>Tanggal Berakhir</th>
                                            <th>Harga</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>Tanggal Dibuat</th>
                                            <th>Jumlah Buku</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $trx)
                                        @if ($type === 'subscription')
                                            <tr>
                                                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $trx->SubscriptionPackage->name ?? 'Paket' }}</td>
                                                <td>{{ $trx->expired_date }}</td>
                                                <td>Rp
                                                    {{ number_format($trx->SubscriptionPackage->prices ?? 0, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $trx->total_book }}</td>
                                                <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $trx->status }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-secondary">Belum ada transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
