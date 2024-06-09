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
    <a class="primary-btn" href="#" id="link" style="pointer-events: none; opacity: 0.6;">Booking</a>
    @endif
@else
    <a class="primary-btn" href="{{ route('register') }}">Booking</a>
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
                    aria-controls="review" aria-selected="false">Reviews</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row total_rate">
                            <div class="col-6">
                                <div class="box_total">
                                    <h5>Overall</h5>
                                    <h4>4.0</h4>
                                    <h6>(03 Reviews)</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rating_list">
                                    <h3>Based on 3 Reviews</h3>
                                    <ul class="list">
                                        <li><a href="#">5 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">4 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">3 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">2 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">1 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="review_list">
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-1.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-2.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-3.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Add a Review</h4>
                            <p>Your Rating:</p>
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p>Outstanding</p>
                            <form class="row contact_form" action="contact_process.php" method="post" id="contactForm"
                                novalidate="novalidate">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Your Full name" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Your Full name'">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Address" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Email Address'">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="number" name="number"
                                            placeholder="Phone Number" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Phone Number'">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message" rows="1"
                                            placeholder="Review" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Review'"></textarea></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" value="submit" class="primary-btn">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The rest of your HTML remains unchanged -->

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
                        <input class="form-control" name="nama" id="nama" 
                        @auth
                            value="{{ auth()->user()->name }}"
                            readonly
                            @endauth
                            
                            disabled>
                        <span class="text-danger error-text nama_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Kontak</label>
                        <input class="form-control" name="no_hp" id="no_hp" 
                        @auth
                            value="{{ auth()->user()->no_hp }}"
                            readonly
                            @endauth
                            
                            disabled>
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

                    const whatsappLink = `https://wa.me/${item.wopal.no_hp}?text=${encodeURIComponent(`Hallo kak, saya tertarik dengan paket ${item.nama_paket}. Saya ingin Memboking.`)}&source=&data=${url + 'uploads/packages/' + item.gmb_paket}`;

                    @if(auth()->check())
                    $('#link').on('click', function () {
                        $('#Modal').modal('show');
                        $('#nama_paket').val(item.nama_paket);
                    });

                    $('#btn-send').on('click', function (e) {
                    e.preventDefault();

                    // Validate form fields
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
                        id_user: '{{ auth()->id() }}', // Replace with actual user ID
                        id_package: item.id
                    };

                    $.ajax({
                        type: 'POST',
                        url: `${url}api/v1/bookings/create`, // Adjust the URL as needed
                        data: formData,
                        success: function (response) {
                            if (response.code === 200) {
                                // Open WhatsApp link
                                window.open(whatsappLink, '_blank');

                                // Show SweetAlert notification after clicking "Pesan" button
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
