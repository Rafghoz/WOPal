@extends('components.template')

@section('content')
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{ url('UI/img/banner/login-bg.jpg') }}" alt="">
                    <div class="hover">
                        <h4>Baru di website kami?</h4>
                        <p>Daftar sekarang untuk mendapatkan akses penuh ke semua fitur dan manfaat dari layanan kami.</p>
                        <a class="primary-btn" href="/registrasi">Buat Akun</a>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Log in to enter</h3>
                    <form class="row login_form" action="{{ route('login') }}" method="post" id="loginForm" novalidate="novalidate">
                        @csrf
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-12 form-group">
							<div class="input-group" id="show_hide_password">
								<input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
								<div class="input-group-addon">
									<a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.code === 200) {
                // Simpan token di local storage atau cookies jika diperlukan
                localStorage.setItem('access_token', response.access_token);
                // Redirect ke halaman yang diinginkan
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: response.message,
                    showConfirmButton: true,
                    timer: 2000 // Waktu tampilan alert 2 detik
                }).then(function () {
                    // Redirect ke halaman yang diinginkan
                    window.location.href = response.redirect_url;
                });
            } else {
                // Tampilkan SweetAlert untuk pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.message,
                });
            }
        },
        error: function (xhr, status, error) {
            // Cek status code untuk menentukan pesan error yang tepat
            if (xhr.status === 422) {
                // Jika terjadi kesalahan validasi
                let errorText = '';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        errorText += `${errors[key][0]}<br>`;
                    });
                } else {
                    errorText = 'Terjadi kesalahan validasi.';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error Validasi',
                    html: errorText,
                });
            } else if (xhr.status === 401) {
                // Jika terjadi Unauthorized (misalnya, token tidak valid)
                Swal.fire({
                    icon: 'error',
                        title: 'Tidak Diizinkan',
                        text: 'Kredensial tidak valid. Silakan coba lagi.',
                });
            } else if (xhr.status === 403) {
                // Jika terjadi Forbidden (misalnya, akses terbatas)
                Swal.fire({
                    icon: 'error',
                        title: 'Akses Ditolak',
                        text: 'Akses ditolak. Silakan hubungi administrator.',
                });
            } else if (xhr.status === 500) {
                // Jika terjadi Internal Server Error
                Swal.fire({
                    icon: 'error',
                        title: 'Error Server',
                        text: 'Internal server error. Silakan coba lagi nanti.',
                });
            } else {
                // Jika error umum atau tidak diketahui
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan!',
                });
            }
        }
    });
});


    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
});
</script>
@endsection
