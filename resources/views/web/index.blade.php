@extends('components.template')

@section('hero')
    <section class="banner-area">
        <div class="container">
            <div class="row fullscreen align-items-center justify-content-start">
                <div class="col-lg-12">
                    <div class="active-banner-slider owl-carousel">
                        <!-- single-slide -->
                        <div class="row single-slide align-items-center d-flex">
                            <div class="col-lg-5 col-md-6">
                                <div class="banner-content">
                                    <h1>Nike New <br>Collection!</h1>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="banner-img">
                                    <img class="img-fluid" src="{{ asset('UI/img/banner/banner-img.png') }}"
                                        alt="Banner Image">
                                </div>
                            </div>
                        </div>
                        <!-- single-slide -->
                        <div class="row single-slide align-items-center d-flex">
                            <div class="col-lg-5">
                                <div class="banner-content">
                                    <h1>Nike New <br>Collection!</h1>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="banner-img">
                                    <img class="img-fluid" src="{{ asset('UI/img/banner/banner-img2.png') }}"
                                        alt="Banner Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <!-- Konten Anda di sini -->
    <div class="row">

        <div class="col-xl-12">
            <!-- Start Filter Bar -->
            <aside class="single_sidebar_widget search_widget">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Pencarian WO" onfocus="this.placeholder = ''"
                        onblur="this.placeholder = 'Pencarian Paket'">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
                    </span>
                </div>
            </aside>
            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row card-paket-container" id="containerPaket">
                    <div class="col-lg-4 col-md-6 card-paket-template" style="display: none;">
                        @include('components.card-paket')
                    </div>
                </div>
            </section>
            <!-- End Best Seller -->
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            const formatRupiah = (nilai) => {
                return "Rp " + nilai.toLocaleString('id-ID');
            }
            

            $(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "{{ url('api/v1/packages/') }}",
        dataType: "json",
        success: function(response) {
            console.log(response);

            // Kosongkan kontainer sebelum menambahkan data
            $(".card-Paket").empty();

            if (response.code === 200) {
                $.each(response.data, function(index, data) {
                    console.log("Data:", data); // Tambahkan console.log untuk memeriksa data
                    // Cloning card-paket template
                    const card = $('.card-paket-template').clone();

                            // Mengisi data ke dalam template
                            card.find('.namaPak').text(data.nama_paket);
                            card.find('.NamaWopal').text(data.wopal.nama_wopal);
                            card.find('#gmbPaket').attr('src', 'uploads/packages/' + data.gmb_paket);
                            card.find('#profileWopal').attr('src', 'uploads/wopal_profile/' + data.wopal.img_wopal);
                            card.find('.harga').text(formatRupiah(data.harga));
                            card.find('.deskrip').text(data.deskrisi);
                            card.find('#link').attr('href', '/detail-produk/' + data.id);

                            // Memasukkan card yang sudah diisi ke dalam kontainer
                            $('.card-paket-container').append(card.removeClass('card-paket-template').show());

                    // Tambahkan elemen HTML ke dalam kontainer
                    // $(".card-Paket").append(html);
                });
            } else {
                console.error("Failed to get data: ", response.message);
            }
        },
        error: function(error) {
            console.log("Failed to get data from the server", error);
        }
    });
    const searchInput = $("#searchInput");

searchInput.on("input", function() {
    var searchTerm = searchInput.val().toLowerCase();

    // Filter data based on the search term
    var filteredData = response.data.filter(function(item) {
        return item.nama_wopal.toLowerCase().includes(searchTerm) || item.alamat.toLowerCase().includes(searchTerm);
    });

    // Empty the container before adding the filtered data
    containerPaket.empty();

    // Display the filtered data
    $.each(filteredData, function(index, item) {
        var card = $(`
            <div class="card">
                <a id="link" href="/detail-WO/${item.id}">
                <div class="card-body text-center">
                    <img src="uploads/wopal_profile/${item.img_wopal}" class="rounded-circle mb-3 profileWopal" alt="Profile Image" style="width: 100px; height: 100px;">
                    <h5 class="NamaWopal">${item.nama_wopal}</h5>
                    <p class="alamat">${item.alamat}</p>
                </div>
                </a>
            </div>
        `);

        containerPaket.append(card);
    });
});
});


        });
    </script>
@endsection
