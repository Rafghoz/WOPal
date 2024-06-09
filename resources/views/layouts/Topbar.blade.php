<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
          aria-labelledby="searchDropdown">
          <form class="navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <div class="topbar-divider d-none d-sm-block"></div>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img class="img-profile rounded-circle" src="{{ asset('img/boy.png') }}" style="max-width: 60px">
            <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
        </a>
        {{-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" id="logoutButton">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div> --}}
    </li>
    <li class="nav-item">
      <a class="nav-link" id="logoutButton" href="javascript:void(0);" role="button">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
      </a>
  </li>
    </ul>
  </nav>

@section('script')
<script>
  // const urlLogout = 'logout'
  $(document).ready(function() {
      $('#logoutButton').click(function(e) {
          Swal.fire({
              title: 'Yakin ingin Logout?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel',
              resolveButton: true
          }).then((result) => {
              if (result.isConfirmed) {
                  e.preventDefault();
                  $.ajax({
                      url: `{{ url('${urlLogout}') }}`,
                      method: 'POST',
                      dataType: 'json',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(response) {
                          window.location.href = '/cms/login';
                      },
                      error: function(xhr, status, error) {
                          alert('Error: Failed to logout. Please try again.');
                      }
                  });
              }
          });
      });
  });

</script>
@endsection