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
            <aside class="single_sidebar_widget search_widget">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Pencarian Paket"
                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Pencarian Paket'">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
                    </span>
                </div>
            </aside>
            <!-- End Filter Bar -->
            <!-- Start Sorting Option -->
            <div class="form-group shortmin">
                <select class="form-control" id="sortBy">
                    <option value="none">Tidak diurutkan</option>
                    <option value="asc">Harga Terendah</option>
                    <option value="desc">Harga Tertinggi</option>
                </select>
            </div>
            <section class="lattest-product-area pb-40 category-list">
                <div class="row card-paket-container">
                    <div class="col-lg-4 col-md-6 card-paket-template" style="display: none;">
                        {{-- @include('components.card-paket') --}}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        const url = 'http://127.0.0.1:8000/';
        const containerPaket = $(".card-paket-container");
        const searchInput = $("#searchInput");
        const sortBy = $("#sortBy");
        const productId = location.pathname.split('/')[2];

        const formatRupiah = (nilai) => {
            return "Rp " + nilai.toLocaleString('id-ID');
        }

        // Fungsi untuk menampilkan data paket
        const showPackages = (data) => {
            containerPaket.empty();
            $.each(data, function(index, item) {
                var card = $(`
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="single-product">
                            <a href="/detail-produk/${item.id}">
                                <img class="img-fluid" src="${url}uploads/packages/${item.gmb_paket}" alt="Gambar Paket">
                                <div class="d-flex flex-row align-items-center pl-3">
                                    <img src="${url}uploads/wopal_profile/${item.wopal.img_wopal}" alt="profile"
                                        class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <h4 class="NamaWopal pl-3">${item.wopal.nama_wopal}</h4>
                                </div>
                                <div class="product-details pl-4">
                                    <h5 class="namaPak">${item.nama_paket}</h5>
                                    <div class="price">
                                        <h6 class="harga">${formatRupiah(item.harga)}</h6>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn primary-btn">Pesan</button>
                                </div>
                            </a>
                        </div>
                    </div>
                `);
                containerPaket.append(card);
            });
        };

        // Fungsi untuk menampilkan detail Wopal
        const showWopalDetails = (data) => {
            $('#NamaWopal1').text(data.nama_wopal);
            $('.profileWopal').attr('src', '/uploads/wopal_profile/' + data.img_wopal);
            $('.desWo').text(data.deskripsi);
            $('.alamat').html(data.alamat + ' <i class="fas fa-map-marker-alt"></i>');
            $('.nomor').html(data.no_hp + ' <i class="fas fa-phone"></i>');
            $('.email').html(data.email + ' <i class="fas fa-envelope"></i>');
        };

        // Fungsi untuk memuat dan memfilter data paket
        const loadAndFilterPackages = () => {
            const searchTerm = searchInput.val().toLowerCase();
            const sortOption = sortBy.val();

            $.ajax({
                type: "GET",
                url: `{{ url('api/v1/packages/get/wo/') }}/${productId}`,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.code === 200) {
                        let filteredData = response.data.filter(function(item) {
                            return item.wopal.nama_wopal.toLowerCase().includes(searchTerm) ||
                                   item.nama_paket.toLowerCase().includes(searchTerm);
                        });

                        // Urutkan berdasarkan harga
                        if (sortOption === "asc") {
                            filteredData.sort((a, b) => a.harga - b.harga);
                        } else if (sortOption === "desc") {
                            filteredData.sort((a, b) => b.harga - a.harga);
                        }

                        showPackages(filteredData);
                    } else {
                        console.error("Failed to get data: ", response.message);
                    }
                },
                error: function(error) {
                    console.log("Failed to get data from the server", error);
                }
            });
        };

        // Memuat data paket pertama kali
        $.ajax({
            type: "GET",
            url: `{{ url('api/v1/Wopal/get/') }}/${productId}`,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.code === 200 && response.data) {
                    showWopalDetails(response.data);
                    loadAndFilterPackages();
                } else {
                    console.error("Failed to get data: ", response.message);
                }
            },
            error: function(error) {
                console.log("Failed to get data from the server", error);
            }
        });

        // Event listener untuk input pencarian
        searchInput.on("input", loadAndFilterPackages);

        // Event listener untuk select option sort
        sortBy.on("change", loadAndFilterPackages);
    });
</script>


@endsection
