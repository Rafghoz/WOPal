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
        <h3 class="text-heading">Bergabunglah dengan Kami!</h3>
        <p class="sample-text">
            Kami mengundang semua Wedding Organizer profesional untuk bergabung dengan platform kami dan menjadi bagian dari komunitas yang berkomitmen untuk memberikan layanan terbaik bagi calon pengantin. Dengan bergabung bersama kami, Anda akan mendapatkan akses ke ribuan calon pelanggan yang mencari layanan WO yang handal dan berkualitas.
        </p>
        <p class="sample-text">
            Jangan lewatkan kesempatan ini untuk memperluas jangkauan bisnis Anda dan membantu lebih banyak pasangan mewujudkan pernikahan impian mereka. Daftar sekarang dan mulailah perjalanan Anda bersama kami!
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
            <form class="row contact_form" id="contactForm" novalidate="novalidate">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Nama'">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Alamat Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Alamat Email'">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Masukan Subjek" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Subjek'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" name="pesan" id="pesan" rows="1" placeholder="Masukan Pesan" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan Pesan'"></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="primary-btn" id="kirim">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
          const nama = document.getElementById('nama')
  const email = document.getElementById('email')
  const subjek = document.getElementById('subjek')
  const pesan = document.getElementById('pesan')
  const kirim = document.getElementById('kirim')

  kirim.addEventListener('click', () => {
    if (nama.value && email.value && pesan.value) {
      window.open(`https://wa.me/+6281543138256?text=halo kak, saya ${nama.value} dengan email ${email.value}, ${pesan.value}`, '_blank')
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: 'nama, email, dan pesan tidak boleh kosong'
      })
    }
  })
    </script>
@endsection
