@extends('components.template')

@section('content')
    <!-- Konten Anda di sini -->
    <div class="section_gap">
        <div class="whole-wrap pb-100">
            <div class="container">
                <div class="section-top-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="frame-circle">
                                <img id="profileWopal" src="https://source.unsplash.com/random/1080x1080" alt=""
                                    class="img-fluid profileWopal" style="height: 200px; width: 100%;">
                            </div>
                        </div>
                        <div class="col-md-8 mt-sm-20">
                            <p id="NamaWopal1">Nama Wopal</p>
                            <p class="desWo">Deskripsi</p>
                            <div class="contact-info">
                                <p class="alamat">Alamat <i class="fas fa-map-marker-alt"></i></p>
                                <p class="nomor">Nomor <i class="fas fa-phone"></i></p>
                                <p class="email">Email <i class="fas fa-envelope"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <section class="lattest-product-area pb-40 category-list">
                <div class="row card-paket-container">
                    <div class="col-lg-4 col-md-6 card-paket-template" style="display: none;">
                        @include('components.card-paket')
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let url = 'http://127.0.0.1:8000/';
            const formatRupiah = (nilai) => {
                return "Rp " + nilai.toLocaleString('id-ID');
            }

            const path = location.pathname;
            const pathSegments = path.split('/');

            // Mengambil ID dari pathSegments[2]
            const productId = pathSegments[2];

            $('#NamaWopal').text('');
            $('.profileWopal').attr('');
            $('.desWo').text('');
            // Update the text content without removing the icons
            $('.alamat').text('');
            $('.nomor').text('');
            $('.email').text('');


            // First AJAX request for Wopal details
            $.ajax({
                type: "GET",
                url: `{{ url('api/v1/Wopal/get/') }}/${productId}`,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    let data = response.data;

                    if (response.code === 200) {
                        const data = response.data;
                        if (data) {
                            $('#NamaWopal1').text(data.nama_wopal);
                            $('.profileWopal').attr('src', '/uploads/wopal_profile/' + data.img_wopal);
                            $('.desWo').text(data.deskripsi);
                            // Update the text content without removing the icons
                            $('.alamat').html(data.alamat + ' <i class="fas fa-map-marker-alt"></i>');
                            $('.nomor').html(data.no_hp + ' <i class="fas fa-phone"></i>');
                            $('.email').html(data.email + ' <i class="fas fa-envelope"></i>');
                        } else {
                            console.error("Data is undefined");
                        }
                        $.ajax({
                        type: "GET",
                        url: `{{ url('api/v1/packages/get/wo/') }}/${productId}`,
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            $(".card-Paket").empty();

                            if (response.code === 200) {
                                $.each(response.data, function(index, item) {
                                    // Membuat template card dengan data yang diterima
                                    const card = $('.card-paket-template').clone();

                                    // Mengisi data ke dalam template
                                    card.find('.namaPak').text(item.nama_paket);
                                    card.find('.NamaWopal').text(item.wopal.nama_wopal);
                                    card.find('#gmbPaket').attr('src', url + 'uploads/packages/' + item.gmb_paket);
                                    card.find('#profileWopal').attr('src', url + 'uploads/wopal_profile/' + item.wopal.img_wopal);
                                    card.find('.harga').text(formatRupiah(item.harga));
                                    card.find('.deskrip').text(item.deskrisi);
                                    card.find('#link').attr('href', '/detail-produk/' + item.id);

                                    // Memasukkan card yang sudah diisi ke dalam kontainer
                                    $('.card-paket-container').append(card.removeClass('card-paket-template').show());
                                                });
                                            } else {
                                                console.error("Failed to get data: ", response.message);
                                            }
                                        },
                                        error: function(error) {
                                            console.log("Failed to get data from the server", error);
                                        }
                                    });

                    } else {
                        console.error("Failed to get data: ", response.message);
                    }
                },
                error: function(error) {
                    console.log("Failed to get data from the server", error);
                }
            });

            // Second AJAX request for packages

        });
    </script>
@endsection
