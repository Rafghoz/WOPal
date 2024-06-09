<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/ruang-admin.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>  

  <!-- Page level plugins -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
<script>
  $(document).ready(function () {
    $('#dataTable').DataTable(); // ID From dataTable 
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
  });
</script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>


<script>
  $(document).ready(function() {
      $('#logoutButton').click(function(e) {
          e.preventDefault(); // Mencegah tindakan default klik link
          
          // Menampilkan konfirmasi menggunakan SweetAlert
          Swal.fire({
              title: 'Yakin ingin Logout?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel',
              resolveButton: true
          }).then((result) => {
              if (result.isConfirmed) {
                  // Jika konfirmasi dilakukan, maka kirim permintaan logout menggunakan AJAX
                  $.ajax({
                      url: '{{ route('logout') }}',
                      method: 'POST',
                      dataType: 'json',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(response) {
                          // Jika logout berhasil, arahkan ke halaman login
                          window.location.href = '/cms/login';
                      },
                      error: function(xhr, status, error) {
                          // Jika terjadi kesalahan, tampilkan pesan kesalahan
                          alert('Error: Failed to logout. Please try again.');
                      }
                  });
              }
          });
      });
  });
</script>


@yield('script')