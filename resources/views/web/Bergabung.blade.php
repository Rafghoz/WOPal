@extends('components.template')

{{-- @section('hero')
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Bergabung</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/AboutUs">Bergabung</a>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection --}}

@section('content')
    <!-- Konten Anda di sini -->
    <div class="section_gap">
        <h3 class="text-heading">Text Sample</h3>
        <p class="sample-text">
            Every avid independent filmmaker has <b>Bold</b> about making that <i>Italic</i> interest documentary, or short
            film to show off their creative prowess. Many have great ideas and want to “wow” the<sup>Superscript</sup> scene,
            or video renters with their big project. But once you have the<sub>Subscript</sub> “in the can” (no easy feat), how
            do you move from a <del>Strike</del> through of master DVDs with the <u>“Underline”</u> marked hand-written title
            inside a secondhand CD case, to a pile of cardboard boxes full of shiny new, retail-ready DVDs, with UPC barcodes
            and polywrap sitting on your doorstep? You need to create eye-popping artwork and have your project replicated.
            Using a reputable full service DVD Replication company like PacificDisc, Inc. to partner with is certainly a
            helpful option to ensure a professional end result, but to help with your DVD replication project, here are 4 easy
            steps to follow for good DVD replication results:

        </p>
    </div>
<div class="section_gap_bottom">
    <div class="row">
        <div class="col-lg-3">
            <div class="contact_info">
                <div class="info_item">
                    <i class="lnr lnr-home"></i>
                    <h6>Sulawesi Tengah, Palu</h6>
                    <p></p>
                </div>
                <div class="info_item">
                    <i class="lnr lnr-phone-handset"></i>
                    <h6><a href="#">081543138256</a></h6>
                    <p>Senin sampai jumat 9am - 6 pm</p>
                </div>
                <div class="info_item">
                    <i class="lnr lnr-envelope"></i>
                    <h6><a href="#">raflighoz@gmail.com</a></h6>
                    <p>Kirimkan masukanmu</p>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Nama'">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Alamat Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Alamat Email'">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Masukan Subjek" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Subjek'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" name="message" id="message" rows="1" placeholder="Masukan Pesan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Pesan'"></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button type="submit" value="submit" class="primary-btn">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
