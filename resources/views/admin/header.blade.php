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
                    <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Admin</strong><strong>Page</strong></div>
                    {{-- <div class="brand-text brand-sm"><strong class="text-primary">A</strong><strong>P</strong></div> --}}
                </a>
                <!-- Sidebar Toggle Btn -->
                <button class="sidebar-toggle"><i class="fa fa-bars"></i></button>
            </div>
            <!-- Dropdown Menu for User -->
            <div>
                <span class="navbar-text ml-3">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </nav>
</header>

<style>
@media (max-width: 992px) {
    .navbar-text.ml-auto {
        display: block !important;
    }
}
</style>
