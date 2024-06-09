@extends('components.template')

{{-- @section('hero')
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Bergabung</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/AboutUs">Bergabung</a>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection --}}

@section('content')
    <!-- Konten Anda di sini -->
    <section class="register_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="register_form_inner">
                        <h3>Registrasi</h3>
                        <form class="row register_form" action="" method="post" id="registerForm" novalidate="novalidate">
                            @csrf
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
                            </div>
                            <div class="col-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="input-group" id="show_hide_password">
                                    <input type="Password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor HP" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nomor HP'">
                            </div>
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat'">
                            </div>
                            <div class="col-md-12 form-group mt-4">
                                <button type="submit" class="primary-btn">Register</button>
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
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('api/v1/auth/createDataUser') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Data berhasil ditambahkan!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        window.location.href = document.referrer;
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim data',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    });

    // Toggle password visibility
    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        } else {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').removeClass("fa-eye");
            $('#show_hide_password i').addClass("fa-eye-slash");
        }
    });
});

    </script>
@endsection
