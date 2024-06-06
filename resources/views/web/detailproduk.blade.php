@extends('components.template')

@section('content')
<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="single-prd-item">
                    <img class="img-fluid" src="https://source.unsplash.com/random/1920x1080" alt="" id="gmbPaket">
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3 class="namaPak">Faded SkyBlu Denim Jeans</h3>
                    <h2 class="harga">$149.99</h2>
                    <p class="deskrip">Mill Oil is an innovative oil filled radiator with the most modern technology. If
                        you are looking
                        for
                        something that can make your interior look awesome, and at the same time give you the pleasant
                        warm feeling
                        during the winter.</p>

                    <div class="card_area d-flex align-items-center">
                        <a class="primary-btn" href="#">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->

@endsection

@section('script')
<script>
$(document).ready(function () {
    const formatRupiah = (nilai) => {
        return "Rp " + nilai.toLocaleString('id-ID');
    }

    const path = location.pathname;
    const pathSegments = path.split('/');

    // Mengambil ID dari pathSegments[2]
    const productId = pathSegments[2];

    $.ajax({
        type: "GET",
        url: `{{ url('api/v1/packages/get/') }}/${productId}`,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.code === 200) {
                const data = response.data;
                $('.namaPak').text(data.nama_paket);
                $('.NamaWopal').text(data.wopal.nama_wopal);
                $('#gmbPaket').attr('src', 'uploads/packages/' + data.gmb_paket);
                $('#profileWopal').attr('src', 'uploads/wopal_profile/' + data.wopal.img_wopal);
                $('.harga').text(formatRupiah(data.harga));
                $('.deskrip').text(data.deskripsi); // Perbaiki deskripsi menjadi deskripsi
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
