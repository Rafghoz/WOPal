@extends('layouts.Base')
@section('title', 'Dashboard')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
    </ol>
</div>
@endsection
@section('content')

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Pengunjung</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <span id="visitorCount">Loading...</span>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Bookings</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="bookingCount">Loading...</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar-check fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Paket</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="packageCount">Loading...</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-box fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Booking</h6>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/v1/admin-dashboard') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#visitorCount').text(data.visitorCount);
                    $('#bookingCount').text(data.jumlahBookings);
                    $('#packageCount').text(data.jumlahPakets);
    
                },
                error: function(err) {
                    console.error('Error fetching admin dashboard data: ', err);
                }
            });

        });
    </script>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- Letakkan sebelum skrip FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/moment/moment.js"></script>
<!-- Sesuaikan dengan lokasi file id.js -->

<script>
$(document).ready(function () {
    // Initialize FullCalendar dengan bahasa Indonesia
    var calendar = $('#calendar').fullCalendar({
        editable: false, // Nonaktifkan fitur edit acara
        locale: 'id', // Set locale bahasa Indonesia
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: function (start, end, timezone, callback) {
            $.ajax({
                url: '/v1/admin-dashboard',
                dataType: 'json',
                success: function (response) {
                    var events = response.events.map(function (event) {
                        return {
                            id: event.id,
                            title: event.title, // Menampilkan nama user
                            start: event.start,
                            end: event.end,
                            paket: event.paket // Menambahkan nama paket ke description
                        };
                    });
                    callback(events);
                }
            });
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            // Tidak ada prompt untuk menambah acara
            $('#calendar').fullCalendar('unselect');
        },
        eventClick: function (event) {
            // Redirect to booking page
            var bookingUrl = '/Bookings/' + event.id; // Ganti '/booking/' dengan URL yang sesuai
            window.location.href = bookingUrl;
        },
        eventRender: function (event, element) {
            // Menampilkan nama paket sebagai tooltip
            element.attr('title', event.paket);
            
            // Mengubah warna teks judul (nama user) menjadi putih
            $(element).find('.fc-title').css('color', 'white');
        },
        monthNames: [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ],
        monthNamesShort: [
            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
        ],
        dayNames: [
            "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
        ],
        dayNamesShort: [
            "Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"
        ],
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari'
        }
    });
});


</script>

    

@endsection
