@extends('layouts.Base')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Booking</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Booking</li>
    </ol>
</div>
@endsection
@section('content')
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Booking</h6>
            {{-- <button type="button" class="btn btn-outline-primary ml-auto" data-toggle="modal" data-target="#Modal"
                id="#myBtn">
                Tambah Data
            </button> --}}
        </div>
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="tabelData">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>Kontak</th>
                        <th>Tanggal Booking</th>
                        <th>Catatan</th>
                        <th>Paket</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        @if (auth()->user()->role == 'admin')
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </div>
    </div>
</div>




@endsection

@section('modal')
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1024px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Preview Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="previewImage" src="" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        const url = 'http://127.0.0.1:8000/v1';

        let userRole = "{{ auth()->user()->role }}";

        var dataTable = $("#tabelData").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "emptyTable": "Data Kosong"
            }
        });


        function fetchData() {
    $.ajax({
        type: "GET",
        url: url + `/bookings`,  // pastikan variable url sudah terdefinisi
        dataType: "json",
        success: function (response) {
            console.log(response); 
            if (response.code === 200) {
                let tableBody = '';
                $.each(response.data, function (index, data) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>" + data.user.name + "</td>";
                            tableBody += "<td>" + data.user.no_hp + "</td>";
                            tableBody += "<td>" + data.tgl_nk + "</td>";
                            tableBody += "<td>" + data.catatan + "</td>";
                            tableBody += "<td>" + data.package.nama_paket + "</td>";
                            tableBody += "<td>" + formatRupiah(data.package.harga) + "</td>";
                            tableBody += "<td><a class='openModal text-primary' data-image='" + data.package.gmb_paket +
                            "'><i class='far fa-eye d-flex text-lg justify-content-center'></i></a></td>";

                            if (userRole === 'admin') {
                            tableBody += "<td>" +
                                "<button type='button' class='btn btn-outline-danger btn-delete' data-id='" + data.id + "'>" +
                                "<i class='fa fa-trash'></i></button>" +
                                "</td>";
                            } 
                            
                            tableBody += "</tr>";
                    
                });

                // Update table body
                let table = $("#tabelData").DataTable();
                dataTable.clear().draw();
                dataTable.rows.add($(tableBody)).draw();

                $(".openModal").on('click', function () {
                var imgSrc = $(this).data('image');
                if (imgSrc) {
                    // Set src for image preview in modal
                    $("#previewImage").attr('src', "{{ asset('uploads/packages/') }}/" + imgSrc);

                    // Show the modal
                    $('#imageModal').modal('show');
                } else {
                    console.error("Image source not found");
                }
            });
            } else {
                console.log("Data not found or failed to get data from the server");
                
            }
        },
        error: function () {
            console.log("Failed to get data from the server");
            
        }
    });
}


            // Fetch data on page load
            fetchData();

        function formatRupiah(angka) {
            let numberString = angka.toString();
            let split = numberString.split('.');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp. ' + rupiah;
        }

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus ?',
                text: 'Anda tidak dapat mengembalikan ini',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Delete',
                cancelButtonText: 'Cancel',
                resolveButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url + '/bookings/delete/' + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        success: function (response) {
                            if (response.message === 'Failed') {
                                Swal.fire({
                                    title: 'Gagal menghapus data',
                                    text: response.message,
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            } else {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Data berhasil dihapus',
                                    icon: 'success',
                                    timer: 5000,
                                    showConfirmButton: true
                                }).then(function () {
                                    fetchData();
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan',
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
