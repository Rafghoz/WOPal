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
                                    <h1>Paket WO Terbaru!</h1>
                                    <p>Temukan berbagai paket menarik dari Wedding Organizer terbaik di satu aplikasi. Mulai dari dekorasi, catering, hingga dokumentasi, semua tersedia untuk membuat hari istimewa Anda sempurna. Pilih paket yang sesuai dengan kebutuhan dan anggaran Anda.</p>
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
                            <div class="col-lg-5 col-md-6">
                                <div class="banner-content">
                                    <h1>Paket WO Terbaru!</h1>
                                    <p>Temukan berbagai paket menarik dari Wedding Organizer terbaik di satu aplikasi. Mulai dari dekorasi, catering, hingga dokumentasi, semua tersedia untuk membuat hari istimewa Anda sempurna. Pilih paket yang sesuai dengan kebutuhan dan anggaran Anda.</p>
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
                    <input type="text" class="form-control" id="searchInput" placeholder="Pencarian Paket"
                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Pencarian Paket'">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
                    </span>
                </div>
            </aside>
            <!-- End Filter Bar -->
            <!-- Start Sorting Option -->
            <div class="form-group">
                <select class="form-control" id="sortBy">
                    <option value="none">Tidak diurutkan</option>
                    <option value="asc">Harga Terendah</option>
                    <option value="desc">Harga Tertinggi</option>
                </select>
            </div>
            <!-- End Sorting Option -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row card-paket-container" id="containerPaket">
                    <!-- Isi paket akan dimasukkan oleh JavaScript -->
                </div>
            </section>
            <!-- End Best Seller -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const containerPaket = $("#containerPaket");
            const searchInput = $("#searchInput");
            const sortBy = $("#sortBy");

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
                                    <img class="img-fluid" src="uploads/packages/${item.gmb_paket}" alt="Gambar Paket">
                                    <div class="d-flex flex-row align-items-center pl-3">
                                        <img src="uploads/wopal_profile/${item.wopal.img_wopal}" alt="profile"
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

            // Memuat data paket pertama kali
            $.ajax({
                type: "GET",
                url: "{{ url('v1/packages/get/') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.code === 200) {
                        showPackages(response.data);
                    } else {
                        console.error("Failed to get data: ", response.message);
                    }
                },
                error: function(error) {
                    console.log("Failed to get data from the server", error);
                }
            });

            // Filter dan urutkan paket berdasarkan pencarian dan sort option
            const filterAndSortPackages = () => {
                const searchTerm = searchInput.val().toLowerCase();
                const sortOption = sortBy.val();
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('v1/packages/get/') }}",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.code === 200) {
                            let filteredData = response.data.filter(function(item) {
                                return item.wopal.nama_wopal.toLowerCase().includes(searchTerm) || item.nama_paket.toLowerCase().includes(searchTerm);
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

            // Event listener untuk input pencarian
            searchInput.on("input", filterAndSortPackages);

            // Event listener untuk select option sort
            sortBy.on("change", filterAndSortPackages);
        });
    </script>
@endsection
