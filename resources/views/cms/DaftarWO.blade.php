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

        // $(document).ready(function () {
        //     $('#gmb_paket').on('change', function () {
        //         var fileName = $(this).val().split('\\').pop();
        //         var maxLength = 30; // Panjang maksimal nama file yang diizinkan
        //         fileName = cutFileName(fileName,
        //             maxLength); // Panggil fungsi pembatas nama file
        //         $(this).siblings('.custom-file-label').addClass("selected").html(fileName);

        //         var reader = new FileReader();
        //         reader.onload = function (e) {
        //             $('#preview-add').attr('src', e.target.result);
        //         }
        //         reader.readAsDataURL(this.files[0]);
        //     });
        // });

        // Fungsi untuk memotong nama file yang terlalu panjang
        // function cutFileName(fileName, maxLength) {
        //     if (fileName.length > maxLength) {
        //         return fileName.substring(0, maxLength) + '...';
        //     } else {
        //         return fileName;
        //     }
        // }


        // function formatRupiah(angka) {
        //     let numberString = angka.toString();
        //     let split = numberString.split('.');
        //     let sisa = split[0].length % 3;
        //     let rupiah = split[0].substr(0, sisa);
        //     let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        //     if (ribuan) {
        //         let separator = sisa ? '.' : '';
        //         rupiah += separator + ribuan.join('.');
        //     }

        //     rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        //     return 'Rp. ' + rupiah;
        // }


        // showTable(); // Load table data on page load

        // $('#harga_display').on('input', function () {
        //     var inputValue = $(this).val();

        //     // Remove non-numeric characters except for periods
        //     inputValue = inputValue.replace(/[^,\d]/g, '');

        //     // If input value is not empty
        //     if (inputValue !== '') {
        //         // Convert input value to number
        //         var numberValue = parseInt(inputValue.replace(/,/g, ''));

        //         if (numberValue > MAX_PRICE) {
        //             $('.harga_error').text('Harga tidak boleh melebihi 1 miliar');
        //             $('#btn-send').attr('disabled', true); // Disable submit button
        //             return;
        //         } else {
        //             $('.harga_error').text('');
        //             $('#btn-send').attr('disabled', false); // Enable submit button
        //         }

        //         // Format the number to currency format
        //         var formattedCurrency = formatRupiah(numberValue);

        //         // Update the input value with formatted currency
        //         $(this).val(formattedCurrency);

        //         // Store the raw numeric value in the hidden input
        //         $('#harga').val(numberValue);
        //     } else {
        //         $('#harga').val('');
        //     }
        // });


        // $('#add-data').on('click', function () {
        //     $('#formData').trigger("reset");
        //     $('.error-text').text('');
        //     $('#Modal').modal('show');
        //     $('#btn-send').html('Submit Data');
        //     $('.modal-title').html('Tambah Data');
        //     $("#preview-add").attr("src", "");
        //     $("#preview-add").css("display", "none"); // Hide the image
        //     $('#gmb_paket').val(''); // Clear the file input
        //     $('#package-label').text('Pilih file'); // Reset the file label
        //     $('#id').val(''); // Clear the ID value

        //     // Clear the package price inputs
        //     $('#harga').val('');
        //     $('#harga_display').val('');
        //     $('#btn-send').attr('disabled', false); // Ensure submit button is enabled
        // });


        // $('#btn-send').click(function () {
        //     let formData = new FormData($('#formData')[0]);
        //     let id = $('#id').val();
        //     let fileInput = $('#gmb_paket')[0];

        //     // Clear previous errors
        //     $('.error-text').text('');

        //     // Save the selected image file in a variable to reuse if there are validation errors
        //     let selectedImageFile = fileInput.files[0];
        //     let reader = new FileReader();
        //     reader.onload = function (e) {
        //         $('#preview-add').attr('src', e.target.result);
        //     }
        //     if (selectedImageFile) {
        //         reader.readAsDataURL(selectedImageFile);
        //     }

        //     function handleError(xhr) {
        //         if (xhr.status === 422) { // Unprocessable Entity
        //             let errors = xhr.responseJSON.errors;
        //             for (let key in errors) {
        //                 if (errors.hasOwnProperty(key)) {
        //                     $('.' + key + '_error').text(errors[key][0]);
        //                 }
        //             }
        //         } else {
        //             console.error(xhr.responseText);
        //         }
        //     }
        //     let url = id ? 'http://127.0.0.1:8000/api/v1/wopal_profile/update/' + id : 'http://127.0.0.1:8000/api/v1/wopal_profile/create';
        //     if (id) {
        //         formData.delete('id');
        //     }
    
        //     $.ajax({
        //         type: 'POST',
        //         url: url,
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function (response) {
        //             console.log(response);
        //             $('#Modal').modal('hide');
        //             Table();
        //             Swal.fire({
        //                 title: 'Success',
        //                 text: id ? 'Data berhasil diupdate!' : 'Data berhasil ditambahkan!',
        //                 icon: 'success',
        //                 timer: 5000,
        //                 showConfirmButton: true
        //             }).then(function () {
        //                 Table();
        //                     // showTable();
        //                     // window.location.reload();
        //                 });;
        //         },
        //         error: function (xhr, status, error) {
        //             handleError(xhr);
        //         }
        //     });

        // });

        // $(document).on('click', '.btn-edit', function (res) {
        //     let id = $(this).data('id');
        //     $('.error-text').text('');
        //     console.log(id);
        //     $(document).on('change', '#gmb_paket', function () {
        //         var fileName = $(this).val().split('\\').pop();
        //         $('#package-label').text(fileName);
        //         if (this.files && this.files[0]) {
        //             const fileEdit = this.files[0];
        //             const reader = new FileReader();

        //             reader.onload = function (e) {
        //                 // Display the image preview
        //                 $("#preview-add").attr("src", e.target.result);
        //             };

        //             reader.readAsDataURL(fileEdit);
        //         }

        //     });
        //     $.ajax({
        //         url: url + "/wopal_profile/get/" + id,
        //         type: 'GET',
        //         dataType: 'JSON',
        //         success: function (data) {
        //             console.log(data);
        //             $('#id').val(data.data.id);
        //             $('#nama_paket').val(data.data.nama_paket);
        //             $('#harga').val(data.data.harga);
        //             $('#harga_display').val(formatRupiah(data.data.harga));
        //             $('#deskrisi').val(data.data.deskrisi);
        //             $('#package-label').text(data.data.gmb_paket);
        //             // $('#package-image').html(data.data.gmb_paket);
        //             $('#Modal').modal('show');
        //             $('#btn-send').html('Update Data');
        //             $('.modal-title').html('Edit Data');
        //             $("#preview-add").attr('src', "{{ asset('uploads/wopal_profile/') }}/" + data.data.gmb_paket);

        //             $("#preview-add").css("display", "block"); // Display the image
        //         },
        //         error: function (xhr, status, error) {
        //             console.error(xhr.dataText);
        //         }
        //     });
        // });

        // $(document).on('click', '.btn-delete', function (e) {
        //     e.preventDefault();
        //     let id = $(this).data('id');
        //     Swal.fire({
        //         title: 'Hapus ?',
        //         text: 'Anda tidak dapat mengembalikan ini',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya, Delete',
        //         cancelButtonText: 'Cancel',
        //         resolveButton: true
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 type: "DELETE",
        //                 url: url + '/Wopal/delete/' + id,
        //                 data: {
        //                     "_token": "{{ csrf_token() }}",
        //                     "id": id
        //                 },
        //                 success: function (response) {
        //                     if (response.message === 'Failed') {
        //                         Swal.fire({
        //                             title: 'Gagal menghapus data',
        //                             text: response.message,
        //                             icon: 'error',
        //                             timer: 5000,
        //                             showConfirmButton: true
        //                         });
        //                     } else {
        //                         Swal.fire({
        //                             title: 'Success',
        //                             text: 'Data berhasil dihapus',
        //                             icon: 'success',
        //                             timer: 5000,
        //                             showConfirmButton: true
        //                         }).then(function () {
        //                             Table();
        //                         });
        //                     }
        //                 },
        //                 error: function (xhr, status, error) {
        //                     Swal.fire({
        //                         title: 'Error',
        //                         text: 'Terjadi kesalahan',
        //                         icon: 'error',
        //                         timer: 5000,
        //                         showConfirmButton: true
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // });
    });

</script>
@endsection
