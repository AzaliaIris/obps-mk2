<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
                <div class="close-btn">Close <i class="fa fa-close"></i></div>
                <form id="searchForm" action="#">
                    <div class="form-group">
                        <input type="search" name="search" placeholder="What are you searching for...">
                        <button type="submit" class="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header -->
                <a href="/admin/dashboard" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Office</strong><strong>BPS</strong></div>
                    {{-- <div class="brand-text brand-sm"><strong class="text-primary">O</strong><strong>M</strong></div> --}}
                </a>
                <!-- Sidebar Toggle Btn -->
                <button class="sidebar-toggle"><i class="fa fa-bars"></i></button>
            </div>
            <!-- Dropdown Menu for User -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle user-dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-black">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
.header .dropdown-menu {
    margin-top: 0;
    background-color: white; /* Background color untuk dropdown */
}

.header .dropdown-item {
    color: black; /* Warna tulisan hitam */
    background-color: white; /* Background color putih */
}

.header .dropdown-item:hover {
    background-color: #f1f1f1; /* Hover color sedikit lebih gelap dari putih */
}

.header .user-dropdown {
    background-color: white; /* Background color putih */
    border-color: white;
    color: black; /* Warna tulisan hitam */
}

.header .user-dropdown:hover,
.header .user-dropdown:focus,
.header .user-dropdown:active {
    background-color: white; /* Background color hover */
    color: black; /* Warna tulisan tetap hitam */
}

</style>
