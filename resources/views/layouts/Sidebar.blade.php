<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        {{-- <img src="img/logo/logo2.png"> --}}
      </div>
      <div class="sidebar-brand-text mx-3">RuangAdmin</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?php echo ($currentPage == 'Dashboard') ? 'active' : ''; ?>">
      <a class="nav-link" href="/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Features
    </div>
    <li class="nav-item <?php echo ($currentPage == 'Daftar-WO') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Daftar-WO">
        <i class="fas fa-fw fa-building"></i>
        <span>Daftar WO</span>
      </a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'Bookings') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Bookings">
        <i class="fas fa-fw fa-book"></i>
        <span>Bookings</span>
      </a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'Packages') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Packages">
        <i class="fas fa-fw fa-box"></i>
        <span>Packages</span>
      </a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'Profile') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Profile">
        <i class="fas fa-fw fa-user"></i>
        <span>Profile</span>
      </a>
    </li>

    <li class="nav-item <?php echo ($currentPage == 'Wedding-Organizer') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Wedding-Organizer">
        <i class="fas fa-fw fa-building"></i>
        <span>Profile WO</span>
      </a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'usermanagement') ? 'active' : ''; ?>">
      <a class="nav-link" href="/cms/usermanagement">
        <i class="fas fa-fw fa-users"></i>
        <span>User Manajement</span>
      </a>
    </li>
    <li class="nav-item <?php echo ($currentPage == '') ? 'active' : ''; ?>">
      <a class="nav-link" href="">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </li>
    
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
  </ul>