    <header class="navbar navbar-expand-md d-print-none p-2">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- BEGIN NAVBAR LOGO -->
            <a href="{{ route('home') }}" aria-label="Tabler" class="navbar-brand navbar-brand-autodark me-3">

                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1cWzAkEdbaCzFQvp6GoJdo2JnNoIYuIibKIpaxoOTvQ&s=10"
                    class="navbar-brand-image">
                Books
            </a>

            <ul class="navbar-nav mx-auto w-50">
                {{-- dropdown --}}

                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item active">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">dashboard</a>
                    </li>
                    {{-- request()->routeIs() : mengecek apakah route saat ini sesuai dengan route yang ditentukan. fungsinya untuk memberikan class active yang nantinya akan berwarna biru muda link yang sedang aktif --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.book-categories.index') }}"
                            class="nav-link {{ request()->routeIs('admin.book-categories.index') ? 'active' : '' }}">Kategori
                            Buku</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.subscription-packages.index') }}"
                            class="nav-link {{ request()->routeIs('admin.subscription-packages.index') ? 'active' : '' }}">Paket
                            Langganan</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.books.index') }}"
                            class="nav-link {{ request()->routeIs('admin.books.index') ? 'active' : '' }}"">Buku</a>
                    </li>

                @else
                    {{-- kategori --}}
                    <div class="dropdown mt-2">
                        <a href="" class="btn btn-light dropdown-toggle pt-2 me-2" data-bs-toggle="dropdown">
                            Kategori
                        </a>

                        <div class="dropdown-menu dropdown-menu-card" style="min-width: 600px;">
                            <div class="p-3">
                                <div class="row g-2">
                                    <div class="col-3">
                                        <div class="card py-2">
                                            <div class="card-body p-2 text-center">Kategori 1</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- search bar --}}
                    <div class="input-icon w-100 py-2">
                        <input type="text" class="form-control form-control-rounded"
                            placeholder="Cari Judul, Produk, Buku, Penulis..." />
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </span>
                    </div>

                    {{-- icon keranjang --}}
                    <div class="mt-3 ms-2">
                        <i class="fa-solid fa-cart-arrow-down fs-2 text dark"></i>
                    </div>
                @endif

            </ul>
            <div class="navbar-nav flex-row order-md-last ms-auto gap-2">
                {{-- function check udh ada sesi login atau belum --}}
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                @endif
            </div>
        </div>
    </header>
