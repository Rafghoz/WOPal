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
                                <img id="profileWopal" src="https://source.unsplash.com/random/1080x1080" alt="" class="img-fluid" style="height: 200px; width: 100%;">
                            </div>
                        </div>
                        <div class="col-md-8 mt-sm-20">
                            <p class="NamaWopal">Nama Wopal</p>
                            <p class="deskrip">Deskripsi</p>
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
    
    <section class="lattest-product-area pb-40 category-list">
        <div class="row card-paket-container">
            <div class="col-lg-4 col-md-6 card-paket-template" style="display: none;">
                <div class="single-product">
                    <a href="/detail-produk" id="link">
                        <img class="img-fluid" src="" alt="" id="gmbPaket">
                        <div class="d-flex flex-row align-items-center pl-3">
                            <img src="" alt="profile" class="rounded-circle" id="profileWopal" style="width: 50px; height: 50px; object-fit: cover;">
                            <h4 class="NamaWopal pl-3"></h4>
                        </div>
                        <div class="product-details pl-4">
                            <h5 class="namaPak"></h5>
                            <p class="deskrip"></p>
                            <div class="price">
                                <h6 class="harga">00000</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn primary-btn">Pesan</button>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        const formatRupiah = (nilai) => {
            return "Rp " + nilai.toLocaleString('id-ID');
        }

        const path = location.pathname;
        const pathSegments = path.split('/');

        // Mengambil ID dari pathSegments[2]
        const productId = pathSegments[2];

        // First AJAX request for Wopal details
        $.ajax({
            type: "GET",
            url: `{{ url('api/v1/Wopal/get/') }}/${productId}`,
            dataType: "json",
            success: function(response) {
                console.log(response);

                if (response.code === 200) {
                    const data = response.data;
                    if (data) {
                        $('.NamaWopal').text(data.nama_wopal);
                        $('#profileWopal').attr('src', '/uploads/wopal_profile/' + data.img_wopal);
                        $('.deskrip').text(data.deskripsi);
                        // Update the text content without removing the icons
                        $('.alamat').html(data.alamat + ' <i class="fas fa-map-marker-alt"></i>');
                        $('.nomor').html(data.no_hp + ' <i class="fas fa-phone"></i>');
                        $('.email').html(data.email + ' <i class="fas fa-envelope"></i>');
                    } else {
                        console.error("Data is undefined");
                    }
                } else {
                    console.error("Failed to get data: ", response.message);
                }
            },
            error: function(error) {
                console.log("Failed to get data from the server", error);
            }
        });

        // Second AJAX request for packages
        $.ajax({
            type: "GET",
            url: `{{ url('api/v1/packages/get/wo/') }}/${productId}`,
            dataType: "json",
            success: function(response) {
                console.log(response);

                // Kosongkan kontainer sebelum menambahkan data
                $(".card-paket-container").empty();

                if (response.code === 200) {
                    $.each(response.data, function(index, data) {
                        console.log("Data:", data);
                        // Cloning card-paket template
                        const card = $('.card-paket-template').clone();

                        // Mengisi data ke dalam template
                        card.find('.namaPak').text(data.nama_paket);
                        card.find('.NamaWopal').text(data.nama_wopal);
                        card.find('#gmbPaket').attr('src', 'uploads/packages/' + data.gmb_paket);
                        card.find('#profileWopal').attr('src', 'uploads/wopal_profile/' + data.wopal.img_wopal);
                        card.find('.harga').text(formatRupiah(data.harga));
                        card.find('.deskrip').text(data.deskrisi);
                        card.find('#link').attr('href', '/detail-produk/' + data.id);

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
    });
</script>
@endsection
