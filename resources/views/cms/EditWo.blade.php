@extends('layouts.Base')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile Wedding Organizer</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
</div>
@endsection
@section('content')

<div class="col-lg-12">
    <!-- Form Basic -->
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <form class="form" action="" method="post" id="Form-data" enctype="multipart/form-data">
                        <!-- Avatar Section -->
                        <div class="text-center mb-4">
                            <img src="" class="avatar img-circle img-thumbnail" id="preview-image" alt="avatar">
        
                            <h6 class="mt-2">Upload a different photo...</h6>
                            <span class="text-danger error-text img_wopal-error"></span>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="img_wopal" name="img_wopal" accept="image/*">
                                <label class="custom-file-label" for="img_wopal" id="package-label">Pilih file</label>
                            </div>
                            <div id="file-name" class="text-left mt-2"></div> <!-- Added element for file name -->
                        </div>
                </div>
                <div class="col-lg-9">
                    <!-- Main Form Content -->
        
                    <!-- Form Fields -->
                    <div class="form-group row ml-3">
                        <label for="nama_wopal" class="col-sm-3 col-form-label">Name WO</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_wopal" id="nama_wopal" placeholder="Name WO">
                            <span class="text-danger error-text nama_wopal-error"></span>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
                            <span class="text-danger error-text alamat-error"></span>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label for="no_hp" class="col-sm-3 col-form-label">Kontak</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Kontak">
                            <span class="text-danger error-text no_hp-error"></span>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="email" id="email" placeholder="email">
                            <span class="text-danger error-text email-error"></span>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                            <span class="text-danger error-text deskripsi-error"></span>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <div class="col-sm-12 text-right">
                            @php
    $user = auth()->user();
    $hasWoData = $user->wo()->exists() && $user->role == 'admin';
    $woId = $hasWoData ? $user->wo()->first()->id : null;
@endphp
                            <button type="button" class="btn btn-outline-primary" id="btn-send" data-id="{{ $woId }}"
                            >Edit Data</button>
                            <button type="reset" class="btn btn-outline-danger" id="btn-reset">Reset</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        const url = 'http://127.0.0.1:8000/api/v1';



        function fetchData() {
            $.ajax({
                type: 'GET',
                url: url + '/Wopal/profile',
                success: function (response) {
                    if (response.code === 200) {
                        console.log(response);
                        displayData(response.data); // Panggil fungsi untuk menampilkan data
                    } else {
                        console.error('Error fetching data: ' + response.message);
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching data: ' + xhr.responseText);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to fetch data from server. Please try again later.',
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: true
                    });
                }
            });
        }

        function displayData(data) {
            // Ambil data pertama dari array karena kita hanya menangani satu data saja
            const dataWO = data[0];

            // Set nilai input form dengan data yang diambil
            $('#nama_wopal').val(dataWO.nama_wopal);
            $('#alamat').val(dataWO.alamat);
            $('#no_hp').val(dataWO.no_hp);
            $('#email').val(dataWO.email);
            $('#deskripsi').val(dataWO.deskripsi);
            $('#preview-image').attr('src', '/uploads/wopal_profile/' + dataWO.img_wopal);
            $('#package-label').html(cutFileName(dataWO.img_wopal, 15));
        }

        fetchData();

        $(document).on('change', '#img_wopal', function () {
            var fileName = $(this).val().split('\\').pop();
            var maxLength = 15;
            fileName = cutFileName(fileName, maxLength);
            $(this).siblings('.custom-file-label').addClass("selected").html(fileName);

            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#btn-send').click(function () {
            let formData = new FormData($('#Form-data')[0]);
            let woId = $(this).data('id');
            $('.error-text').text('');

            function handleError(xhr) {
                console.error(xhr.responseText);

                if (xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.nama_wopal) {
                        $('.nama_wopal-error').text(errors.nama_wopal[0]);
                    }
                    if (errors.alamat) {
                        $('.alamat-error').text(errors.alamat[0]);
                    }
                    if (errors.no_hp) {
                        $('.no_hp-error').text(errors.no_hp[0]);
                    }
                    if (errors.email) {
                        $('.email-error').text(errors.email[0]);
                    }
                    if (errors.deskripsi) {
                        $('.deskripsi-error').text(errors.deskripsi[0]);
                    }
                    
                }
            }

            $.ajax({
                type: 'POST',
                url: url + `/Wopal/update/` + woId,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success',
                        text: 'Data successfully updated!',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: true
                    }).then(() => {
                        fetchData(); // Ambil data baru setelah berhasil
                    });

                },
                error: function (xhr, status, error) {
                    handleError(xhr);
                }
            });
        });

    function cutFileName(fileName, maxLength) {
        if (fileName && fileName.length > maxLength) {
            return fileName.substring(0, maxLength) + '...';
        } else {
            return fileName || ''; // Return an empty string if fileName is undefined
        }
    }

    });

</script>

@endsection
