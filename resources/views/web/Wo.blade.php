@extends('components.template')

@section('hero')
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Wedding Organizer</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/WO">Wedding Organizer</a>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<aside class="single_sidebar_widget search_widget">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Posts" onfocus="this.placeholder = ''"
            onblur="this.placeholder = 'Search Posts'">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
        </span>
    </div><!-- /input-group -->
    <div class="br"></div>
</aside>
<section class="cart_area">
    <div class="container">
        <div class="col-12">
            <div id="card-Wo">

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

            $.ajax({
                type: "GET",
                url: "{{ url('api/v1/packages/get/wo') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    // Kosongkan kontainer sebelum menambahkan data
                    $(".card-Wo").empty();

                    if (response.code === 200) {
                        $.each(response.data, function(index, data) {
                            console.log(data); // Tambahkan console.log untuk memeriksa data

                            const html = `
                        
                            <div class="single-product">
                                <img class="img-fluid" src="{{ asset('uploads/packages') }}/${data.gmb_paket}" alt="">
                                <div class="d-flex flex-row gap-2 align-items-center p-2">
        <img src="{{ asset('uploads/wopal_profile') }}/${data.wopal.img_wopal}" alt="profile" class="rounded-circle" style="width: 50px; height: 50px;">
    </div>
                                <div class="product-details">
                                    <h6>${data.wopal.nama_wopal}</h6>
                                    <h6>${data.nama_paket}</h6>
                                    <p>${data.deskrisi}</p>
                                    <div class="price">
                                        <h6>${formatRupiah(data.harga)}</h6>
                                    </div>
                                </div>
                            </div>
                    `;

                            // Tambahkan elemen HTML ke dalam kontainer
                            $(".card-Wo").append(html);
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
