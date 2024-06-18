<!DOCTYPE html>
<html>

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('UI/img/fav.png') }}">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Wopal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--CSS============================================= -->
    <link href="{{ asset('UI/css/linearicons.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/nouislider.min.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/css/themify-icons.css') }}" rel="stylesheet">
    <!-- Load moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- Load moment.js Bahasa Indonesia locale -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>

    @include('components.navbar')
    <!-- End Header Area -->

    <!-- Start Banner Area -->
    @yield('hero')
    {{-- <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shop Category page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Fashon Category</a>
                    </nav>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Banner Area -->
    <div class="container">
        @yield('content')
    </div>

    <!-- start footer Area -->
    @include('components/footer')
    <!-- End footer Area -->


    <script src="{{ asset('UI/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="{{ asset('UI/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('UI/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('UI/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('UI/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('UI/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('UI/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('UI/js/owl.carousel.min.js') }}"></script>
    <!--gmaps Js-->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script> --}}
    <script src="{{ asset('UI/js/gmaps.min.js') }}"></script>
    <script src="{{ asset('UI/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <Script>
        document.addEventListener("DOMContentLoaded", function() {
        // Simulasi pengecekan status login pengguna
        // Gantilah ini dengan logika sebenarnya untuk memeriksa apakah pengguna sudah login atau belum
        var isLoggedIn = false; // Misalnya, nilai ini diambil dari server atau local storage
        
        var authLink = document.getElementById("authLink");
        var menuNav = document.getElementById("navbarSupportedContent");
    
        if (isLoggedIn) {
            authLink.innerHTML = '<a class="nav-link" href="/logout">Log out</a>';
        } else {
            authLink.innerHTML = '<a class="nav-link" href="/login">Log in</a>';
        }
    });
    </Script>
    @yield('script')

</body>

</html>
