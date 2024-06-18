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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Panjang" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Panjang'">
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

                // Validasi form sebelum mengirim data
                if (!validateForm()) {
                    return false;
                }

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
                                text: 'Akun Berhasil di Buat',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: true
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
                        let errorMessage = 'Terjadi kesalahan saat mengirim data';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            displayErrors(xhr.responseJSON.errors);
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }
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

            // Function untuk validasi form
            function validateForm() {
                let isValid = true;

                $('#registerForm input[required]').each(function () {
                    if ($(this).val().trim() === '') {
                        isValid = false;
                        let fieldName = $(this).attr('name');
                        Swal.fire({
                            title: 'Error',
                            text: 'Field ' + fieldName + ' tidak boleh kosong',
                            icon: 'error',
                            showConfirmButton: true
                        });
                        return false; // Menghentikan iterasi each
                    }
                });

                return isValid;
            }

            // Function untuk menampilkan pesan error validasi
            function displayErrors(errors) {
                let errorMessage = '<ul>';
                $.each(errors, function (key, value) {
                    errorMessage += '<li>' + value + '</li>';
                });
                errorMessage += '</ul>';

                Swal.fire({
                    title: 'Error',
                    html: errorMessage,
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    </script>
@endsection


