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
	<section class="register_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="register_form_inner">
						<h3>Registrasi</h3>
						<form class="row register_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
							<div class="col-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
							<div class="col-12 form-group">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-12 form-group">
								<input type="text" class="form-control" id="Password" name="Password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-12 form-group">
								<input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor HP" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nomor HP'">
							</div>
							<div class="col-12 form-group">
								<input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat'">
							</div>
							<div class="col-md-12 form-group mt-4">
								<button type="submit" value="submit" class="primary-btn">Log In</button>
								{{-- <a href="#">Forgot Password?</a> --}}
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
