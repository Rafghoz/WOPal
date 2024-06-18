@extends('layouts.Base')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile Admin</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile Admin</li>
    </ol>
</div>
@endsection
@section('content')

<div class="col-lg-12">
    <!-- Form Basic -->
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Profile Admin</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Main Form Content -->
                    <form class="form" action="" method="post" id="Form-data" enctype="multipart/form-data">
                        <!-- Form Fields -->
                        <div class="form-group">
                            <label for="name">Nama Panjang</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Panjang" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Panjang'">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                <div class="input-group-append">
                                    <a href="#" id="toggle_password" class="input-group-text" style="text-decoration: none; outline: none;"
                                    ><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor HP" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nomor HP'">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat'">
                        </div>
                        <div class="form-group row ml-3">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-outline-primary">Edit Data</button>
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
    const url = 'http://127.0.0.1:8000/v1';
    const userId = '{{ Auth::user()->id }}'; // Assuming you are using Laravel authentication and the user is logged in

    function fetchData() {
        $.ajax({
            type: 'GET',
            url: `${url}/auth/getDataById/${userId}`, // Adjust the endpoint according to your API
            success: function (response) {
                if (response.code === 200) {
                    console.log(response);
                    displayData(response.data); // Call function to display data
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
        // Set input form values with fetched data
        $('#name').val(data.name);
        $('#email').val(data.email);
        $('#alamat').val(data.alamat);
        $('#no_hp').val(data.no_hp);
    }

    fetchData();

    $('#toggle_password').on('click', function (event) {
    event.preventDefault();
    var passwordField = $('#password');
    var fieldType = passwordField.attr('type');
    if (fieldType === 'password') {
        passwordField.attr('type', 'text');
        $(this).html('<i class="fa fa-eye" aria-hidden="true"></i>');
    } else {
        passwordField.attr('type', 'password');
        $(this).html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
    }
});

$('#Form-data').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            // Convert 'no_hp' to string
            let no_hp = formData.get('no_hp');
            if (no_hp !== null && no_hp !== undefined) {
                formData.set('no_hp', String(no_hp));
            }

    $.ajax({
                type: 'POST',
                url: `${url}/auth/updateData/${userId}`,
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
                        fetchData(); // Fetch updated data
                    });
                },
                error: function (xhr) {
                    console.error('Error updating data: ' + xhr.responseText);
                    
                    // Parse validation errors
                    let errorText = '';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            errorText += `${errors[key][0]}<br>`;
                        });
                    } else {
                        errorText = 'Failed to update data. Please try again later.';
                    }

                    Swal.fire({
                        title: 'Error',
                        html: errorText,
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: true
                    });
                }
            });
});

});


</script>

@endsection
