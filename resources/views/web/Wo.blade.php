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
        <input type="text" class="form-control" id="searchInput" placeholder="Pencarian WO" onfocus="this.placeholder = ''"
            onblur="this.placeholder = 'Pencarian WO'">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
        </span>
    </div>
</aside>
<section class="cart_area">
    <div class="container" id="containerWo">
        <div class="col-12">
            {{-- <div class="card" id="card-WO">
                    <a href="" id="link">
                    <div class="card-body text-center">
                        <img src="" id="profileWopal" class="rounded-circle mb-3" alt="Profile Image" style="width: 100px; height: 100px;">
                        <h5 class="NamaWopal">Nama Wedding</h5>
                        <p class="alamat">Alamat Wedding</p>
                    </div>
                </a>
                </div> --}}
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $.ajax({
        type: "get",
        url: "{{ url('api/v1/Wopal') }}",
        dataType: "json",
        success: function(response) {
            $(document).ready(function() {
                const containerWo = $("#containerWo");

                // Empty the container element initially
                containerWo.empty();

                $.each(response.data, function(index, data) {
                    console.log("Data:", data);

                    // Create a new card element
                    const card = $(`
            <div class="card-Wo" id="card-WO">
                <a id="link" href="/detail-WO/${data.id}">
                    <div class="card-body">
                        <img src="uploads/wopal_profile/${data.img_wopal}" class="rounded-circle mb-3 profileWopal" alt="Profile Image">
                        <div>
                            <h5 class="card-title">${data.nama_wopal}</h5>
                            <p class="card-text">${data.alamat}</p>
                        </div>
                    </div>
                </a>
            </div><hr>
                    `);

                    // Append the updated card to the container
                    containerWo.append(card);
                });

                const searchInput = $("#searchInput");

                searchInput.on("input", function() {
                    var searchTerm = searchInput.val().toLowerCase();

                    // Filter data based on the search term
                    var filteredData = response.data.filter(function(item) {
                        return item.nama_wopal.toLowerCase().includes(searchTerm) || item.alamat.toLowerCase().includes(searchTerm);
                    });

                    // Empty the container before adding the filtered data
                    containerWo.empty();

                    // Display the filtered data
                    $.each(filteredData, function(index, item) {
                        const card = $(`
            <div class="card-Wo" id="card-WO">
                <a id="link" href="/detail-WO/${item.id}">
                    <div class="card-body">
                        <img src="uploads/wopal_profile/${item.img_wopal}" class="rounded-circle mb-3 profileWopal" alt="Profile Image">
                        <div>
                            <h5 class="card-title">${item.nama_wopal}</h5>
                            <p class="card-text">${item.alamat}</p>
                        </div>
                    </div>
                </a>
            </div><hr>
                    `);

                        containerWo.append(card);
                    });
                });
            });
        },
        error: function() {
            console.log("Failed to get data from the server");
        }
    });
</script>
@endsection
