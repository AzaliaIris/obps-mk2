<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
      <!-- Sidebar Navidation Menus--><span class="heading" style="margin-top:17.5px">Main</span>
      <ul class="list-unstyled">
        <li><a href="/admin/dashboard" aria-expanded="false"> <i class="icon-home"></i>Dashboard </a></li>
        <li><a href="/admin/view_pengajuan_kegiatan" aria-expanded="false"> <i class="icon-padnote"></i>Pengajuan Kegiatan </a></li>
        <li><a href="/admin/view_monitor_user" aria-expanded="false"> <i class="icon-user-1"></i>Kontribusi User </a></li>
        <li><a href="/admin/view_monitor_kegiatan" aria-expanded="false"> <i class="icon-user-1"></i>Alokasi Tim </a></li>
        <li><a href="/admin/view_master_kegiatan" aria-expanded="false"> <i class="icon-grid"></i>Master Kegiatan</a></li>
        <li><a href="/admin/view_master_rincian" aria-expanded="false"> <i class="icon-grid"></i>Master Rincian </a></li>
        <li>
          <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
              @csrf
          </form>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false"> 
              <i class="icon-logout"></i>Logout 
          </a>
      </li>
      </ul>
    </nav>
    <!-- Sidebar Navigation end-->

    <script>
      // Function to set the active class on the current page link
      function setActiveClass() {
          // Get the current URL path
          var path = window.location.pathname;
  
          // Get all the sidebar links
          var links = document.querySelectorAll('#sidebar ul li a');
  
          // Loop through the links to find the one that matches the current path
          links.forEach(function(link) {
              // Check if the link's href matches the current path
              if (link.getAttribute('href') === path) {
                  // Add the active class to the parent <li> element
                  link.parentElement.classList.add('active');
              }
          });
      }
  
      // Call the function to set the active class
      setActiveClass();
    </script>