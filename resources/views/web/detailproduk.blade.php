@extends('components.template')

@section('content')
<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="single-prd-item">
                    <img class="img-fluid" src="" alt="" id="gmbPaket">
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3 class="namaPak"></h3>
                    <h2 class="harga"></h2>
                    <p class="deskrip"></p>

                    <div class="card_area d-flex align-items-center">
                        @if (auth()->check())
                        @if (auth()->user()->role == 'user')
                        <a class="primary-btn" href="#" id="link">Booking</a>
                        @else
                        <a class="primary-btn" href="#" id="link"
                            style="pointer-events: none; opacity: 0.6;">Booking</a>
                        @endif
                        @else
                        <a class="primary-btn" href="{{ route('login') }}">Perlu Log In</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                    aria-controls="review" aria-selected="true">Reviews</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="review_list" id="reviewList">
                            <!-- Review items will be added dynamically -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Add a Review</h4>
                            <form class="row contact_form" id="reviewForm">
                                @csrf
                                @if (auth()->check())
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="UserName"
                                            placeholder="{{ Auth::user()->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="UserEmail"
                                            placeholder="{{ Auth::user()->email }}" disabled>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="UserName" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="UserEmail" disabled>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="rating">
                                            <i class="fa fa-star-o" data-rating="1"></i>
                                            <i class="fa fa-star-o" data-rating="2"></i>
                                            <i class="fa fa-star-o" data-rating="3"></i>
                                            <i class="fa fa-star-o" data-rating="4"></i>
                                            <i class="fa fa-star-o" data-rating="5"></i>
                                        </div>
                                        <input type="hidden" name="rating" id="rating">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="komentar" id="komentar" rows="5"
                                            placeholder="Review"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    @if (auth()->check())
                                        <button type="submit" class="primary-btn">kirim</button>
                                    @else
                                        <button type="button" class="primary-btn" id="submitAlert">kirim</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input class="form-control" name="nama" id="nama" @auth value="{{ auth()->user()->name }}"
                            readonly @endauth disabled>
                        <span class="text-danger error-text nama_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Kontak</label>
                        <input class="form-control" name="no_hp" id="no_hp" @auth value="{{ auth()->user()->no_hp }}"
                            readonly @endauth disabled>
                        <span class="text-danger error-text no_hp_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="tgl_nk">Tanggal</label>
                        <input type="date" class="form-control" id="tgl_nk" name="tgl_nk" required>
                        <span class="text-danger error-text tgl_nk_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" name="catatan" id="catatan" required></textarea>
                        <span class="text-danger error-text catatan_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="id_package">Paket</label>
                        <input class="form-control" name="nama_paket" id="nama_paket" disabled>
                        <span class="text-danger error-text id_package_error"></span>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary" id="btn-send">Kirim Pesanan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
    const url = 'http://127.0.0.1:8000/';

    const formatRupiah = (nilai) => {
        return "Rp " + nilai.toLocaleString('id-ID');
    }

    const path = location.pathname;
    const pathSegments = path.split('/');
    const productId = pathSegments[2];

    $.ajax({
    type: "GET",
    url: `{{ url('api/v1/packages/get/') }}/${productId}`,
    dataType: "json",
    success: function (response) {
        console.log(response);

        if (response.code === 200) {
            const item = response.data;

            $('.namaPak').text(item.nama_paket);
            $('#gmbPaket').attr('src', `${url}uploads/packages/${item.gmb_paket}`);
            $('.harga').text(formatRupiah(item.harga));
            $('.deskrip').text(item.deskrisi);

            @if(auth()->check())
            $('#link').on('click', function () {
                $('#Modal').modal('show');
                $('#nama_paket').val(item.nama_paket);
            });

            $('#btn-send').on('click', function (e) {
                e.preventDefault();

                const nama = $('#nama').val();
                const no_hp = $('#no_hp').val();
                const tgl_nk = $('#tgl_nk').val();
                const catatan = $('#catatan').val();

                if (!nama || !no_hp || !tgl_nk || !catatan) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Silakan lengkapi semua field yang dibutuhkan',
                        icon: 'error'
                    });
                    return;
                }

                const formData = {
                    nama: nama,
                    no_hp: no_hp,
                    tgl_nk: tgl_nk,
                    catatan: catatan,
                    id_user: '{{ auth()->id() }}',
                    id_package: item.id
                };

                $.ajax({
                    type: 'POST',
                    url: `${url}api/v1/bookings/create`,
                    data: formData,
                    success: function (response) {
                        if (response.code === 200) {
                            const phone = item.wopal.no_hp;
                            const countryCode = '62'; // Indonesia country code
                            let formattedPhone = phone;
                            if (phone.startsWith('0')) {
                                formattedPhone = countryCode + phone.substring(1);
                            }

                            const whatsappMessage = `Hallo kak, saya tertarik dengan paket ${item.nama_paket}. Saya ingin Membooking.\n\nTanggal Nikah: ${tgl_nk}\nCatatan: ${catatan}\n`;

                            const whatsappLink = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(whatsappMessage)}`;

                            window.open(whatsappLink, '_blank');

                            $('#Modal').modal('hide');
                            Swal.fire({
                                title: 'Terima kasih telah melakukan pemesanan!',
                                text: 'Bantu kami meningkatkan layanan dengan memberikan rating.',
                                icon: 'success',
                                confirmButtonText: 'Isi Rating',
                                cancelButtonText: 'Nanti',
                                showCancelButton: true,
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to rating page
                                    // window.location.href = '/rating-page'; // Adjust the URL as needed
                                }
                            });
                            $('#tgl_nk').val('');
                            $('#catatan').val('');
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).map(error => error.join(', ')).join('\n');
                        }
                        Swal.fire({
                            title: 'Validation Error',
                            text: errorMessage,
                            icon: 'error'
                        });
                    }
                });
            });
            @endif

        } else {
            console.error("Failed to get data: ", response.message);
        }
    },
    error: function (error) {
        console.log("Failed to get data from the server", error);
    }
});



});

</script>

@endsection
