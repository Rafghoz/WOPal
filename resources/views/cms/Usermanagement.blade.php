@extends('layouts.Base')

@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Users</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Users</li>
    </ol>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
            <button type="button" class="btn btn-outline-primary ml-auto" data-toggle="modal" data-target="#Modal"
                id="add-data">
                Tambah Data
            </button>
        </div>
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="tabel-users">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Nomor HP</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    {{-- <tr id="loading-row" style="display: none;">
                        <td colspan="5" class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Loading...
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('modal')
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required autocomplete="address">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" required autocomplete="tel">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-send">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
    $(document).ready(function () {
        // Initialize DataTable
        var dataTable = $("#tabel-users").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "emptyTable": "No data available"
            }
        });
    
        // Function to fetch data from server
        function fetchData() {
            $.ajax({
                type: "GET",
                url: "{{ url('api/v1/auth') }}",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        let tableBody = '';
                        $.each(response.data, function (index, data) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>" + data.name + "</td>";
                            tableBody += "<td>" + data.email + "</td>";
                            tableBody += "<td>" + data.alamat + "</td>";
                            tableBody += "<td>" + data.no_hp + "</td>";
                            tableBody += "<td>" + data.role + "</td>";
                            tableBody += "<td>" +
                                "<button type='button' class='btn btn-primary edit-modal' data-toggle='modal' data-target='#Modal' data-id='" +
                                data.id + "'>" +
                                "<i class='fa fa-edit'></i></button> " +
                                "<button type='button' class='btn btn-danger delete-confirm' data-id='" +
                                data.id + "'>" +
                                "<i class='fa fa-trash'></i></button>" +
                                "</td>";
                            tableBody += "</tr>";
                        });
    
                        dataTable.clear().draw();
                        dataTable.rows.add($(tableBody)).draw();
                    } else {
                        dataTable.clear().draw();
                        // alert(response.message);
                    }
                },
                error: function () {
                    console.log("Failed to get data from the server");
                }
            });
        }
    
        // Fetch data on page load
        fetchData();
    
        $('#btn-send').click(function () {
            let formData = new FormData($('#formData')[0]);
            let id = $('#id').val();
    
            function handleError(xhr) {
                console.error(xhr.responseText);
                let errorMessage = "Server Error";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    timer: 5000,
                    showConfirmButton: true
                });
            }
    
            let url = id ? 'http://127.0.0.1:8000/api/v1/auth/updateData/' + id : 'http://127.0.0.1:8000/api/v1/auth/createDataAdmin';
            if (id) {
                formData.delete('id');
            }
    
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    $('#Modal').modal('hide');
                    fetchData();
                    Swal.fire({
                        title: 'Success',
                        text: id ? 'Data berhasil diupdate!' : 'Data berhasil ditambahkan!',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: true
                    });
                },
                error: function (xhr, status, error) {
                    handleError(xhr);
                }
            });
        });
    
        $(document).on('click', '.edit-modal', function () {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ url('api/v1/auth/getDataById') }}/" + id,
                type: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    $('#ModalLabel').text('Edit Data');
                    $('#id').val(data.data.id);
                    $('#name').val(data.data.name);
                    $('#email').val(data.data.email);
                    $('#alamat').val(data.data.alamat);
                    $('#no_hp').val(data.data.no_hp);
                },
                error: function () {
                    alert("Error fetching data");
                }
            });
        });
    
        function resetModal() {
            $('#formData')[0].reset();
            $('#ModalLabel').text('Tambah Data');
        }
    
        $('#Modal').on('hidden.bs.modal', function () {
            resetModal();
        });
    
        $(document).on('click', '.delete-confirm', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Delete?',
                text: 'This action cannot be undone',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('api/v1/auth/deleteData') }}/" + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        success: function (response) {
                            if (response.message === 'Failed') {
                                Swal.fire({
                                    title: 'Failed to delete data',
                                    text: response.message,
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            } else {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Data deleted successfully',
                                    icon: 'success',
                                    timer: 5000,
                                    showConfirmButton: true
                                }).then(function () {
                                    fetchData();
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Error',
                                text: 'Server Error',
                                icon: 'error',
                                timer: 5000,
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });
    });
    </script>
@endsection
