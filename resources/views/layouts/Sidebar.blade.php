<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" 
  @if (auth()->user()->role == 'super_admin')
  href="/superadmin-dashboard">
  @else
  href="/Dashboard">
  @endif
      <div class="sidebar-brand-icon">
          <img src="{{ asset('img/logo/logo2.png') }}">
      </div>
  </a>
  
  <hr class="sidebar-divider my-0">
  @if (auth()->user()->role == 'super_admin')
  <li class="nav-item {{ $currentPage == 'superadmin-dashboard' ? 'active' : '' }}">
      <a class="nav-link" href="/superadmin-dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
      </a>
  </li>
  @else
  <li class="nav-item {{ $currentPage == 'Dashboard' ? 'active' : '' }}">
      <a class="nav-link" href="/Dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
      </a>
  </li>
  @endif
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
      Features
  </div>
  @if (auth()->user()->role == 'super_admin')
  <li class="nav-item {{ $currentPage == 'Daftar-WO' ? 'active' : '' }}">
      <a class="nav-link" href="/Daftar-WO">
          <i class="fas fa-fw fa-building"></i>
          <span>Daftar WO</span>
      </a>
  </li>
  @endif
  <li class="nav-item {{ $currentPage == 'Bookings' ? 'active' : '' }}">
      <a class="nav-link" href="/Bookings">
          <i class="fas fa-fw fa-book"></i>
          <span>Bookings</span>
      </a>
  </li>
  <li class="nav-item {{ $currentPage == 'Packages' ? 'active' : '' }}">
      <a class="nav-link" href="/Packages">
          <i class="fas fa-fw fa-box"></i>
          <span>Packages</span>
      </a>
  </li>

  @php
  $user = auth()->user();
  $hasWoData = $user->wo()->exists() && $user->role == 'admin';
  $woIds = $hasWoData ? $user->wo()->pluck('id')->toArray() : [];
  $role = $user->role;
@endphp

@if ($role !== 'super_admin')
  @if ($hasWoData)
  <li class="nav-item <?php echo ($currentPage == 'Edit-WO') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Edit-WO">
          <i class="fas fa-fw fa-building"></i>
          <span>Profile WO</span>
      </a>
  </li>
@else
  <li class="nav-item <?php echo ($currentPage == 'Create-WO') ? 'active' : ''; ?>">
      <a class="nav-link" href="/Create-WO">
          <i class="fas fa-fw fa-building"></i>
          <span>Create WO</span>
      </a>
  </li>
@endif
@endif
  
  @if (auth()->user()->role == 'admin')
  <li class="nav-item {{ $currentPage == 'edit-user-dashboard' ? 'active' : '' }}">
      <a class="nav-link" href="/cms/edit-user-dashboard">
        <i class="fas fa-user"></i>
          <span>Profile Admin</span>
      </a>
  </li>
  @endif
  @if (auth()->user()->role == 'super_admin')
  <li class="nav-item {{ $currentPage == 'usermanagement' ? 'active' : '' }}">
      <a class="nav-link" href="/cms/usermanagement">
        <i class="fas fa-address-book"></i>
          <span>User Management</span>
      </a>
  </li>
  @endif
  
  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>
