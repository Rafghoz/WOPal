@extends('layouts.Base')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Wedding Organizer</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
</div>
@endsection
@section('content')

<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Wedding Organizer</h6>

        </div>
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="tabelData">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Wedding Organizer</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    {{-- <tr id="loading-row" style="display: none;">
                        <td colspan="6" class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Loading...
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>


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
        const url = 'http://127.0.0.1:8000/api/v1';

        var dataTable = $("#tabelData").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "emptyTable": "Data Kosong"
            }
        });

        function Table() {
            $.ajax({
                type: "GET",
                url: url + `/Wopal`,
                dataType: "json",
                success: function (response) {
                    console.log(response)
                        let tableBody = '';
                        $.each(response.data, function (index, data) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>" + data.nama_wopal + "</td>";
                            tableBody += "<td>" + data.alamat + "</td>";
                            tableBody += "<td>" + data.no_hp + "</td>";
                            tableBody += "<td>" + data.email + "</td>";
                            tableBody += "<td><a class='openModal text-primary' data-image='" + data.img_wopal +
                            "'><i class='far fa-eye d-flex text-lg justify-content-center'></i></a></td>";
                            tableBody += "<td>" + data.deskripsi + "</td>";
                            tableBody += "</tr>";
                        });
    
                        dataTable.clear().draw();
                        dataTable.rows.add($(tableBody)).draw();

                        $(".openModal").on('click', function () {
                var imgSrc = $(this).data('image');
                if (imgSrc) {
                    // Set src for image preview in modal
                    $("#previewImage").attr('src', "{{ asset('uploads/wopal_profile/') }}/" + imgSrc);

                    // Show the modal
                    $('#imageModal').modal('show');
                } else {
                    console.error("Image source not found");
                }
            });
                    
                },
                error: function () {
                    console.log("Failed to get data from the server");
                }
            });
        }
    
        // Fetch data on page load
        Table();

        $(document).ready(function () {
            $('#gmb_paket').change(function () {
                var fileInput = $(this)[0];
                var imagePreview = $('#preview');
                var file = fileInput.files[0];

                if (file) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        imagePreview.attr('src', e.target.result);
                        imagePreview.show();
                    };

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.hide();
                }
            });
        });

    });

</script>
@endsection
