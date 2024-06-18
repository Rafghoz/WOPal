<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img class="img-profile rounded-circle" src="{{ asset('img/logo/logo.png') }}" style="max-width: 60px">
            <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
        </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="logoutButton" href="javascript:void(0);" role="button">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
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