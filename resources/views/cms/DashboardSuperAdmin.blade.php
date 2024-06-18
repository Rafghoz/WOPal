@extends('layouts.Base')
@section('title', 'Dashboard')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Super Admin</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard Super Admin</li>
    </ol>
</div>
@endsection
@section('content')
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Users</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <span id="userCount">Loading...</span>
                    </div>
                </div>
                <div class="col-auto">
                    
                    <i class="fas fa-address-book fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
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

<!-- Earnings (Annual) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah WO</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="woCount">Loading...</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-store fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
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
<div class="col-xl-3 col-md-6 mb-4">
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


<!-- Chart -->
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Overview Chart</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="overviewChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        const url = 'http://127.0.0.1:8000/v1';

        $.ajax({
            url: "{{ url('/v1/superadmin-dashboard') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#userCount').text(data.userCount);
                $('#visitorCount').text(data.visitorCount);
                $('#woCount').text(data.woCount);
                $('#bookingCount').text(data.bookingCount);
                $('#packageCount').text(data.packageCount);
                updateChart(data);
            },
            error: function(err) {
                console.error('Error fetching super admin dashboard data: ', err);
            }
        });

        function updateChart(data) {
            var ctx = document.getElementById('overviewChart').getContext('2d');
            var overviewChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jumlah Users','Jumlah Pengunjung', 'Jumlah WO', 'Jumlah Bookings', 'Jumlah Paket'],
                    datasets: [{
                        label: 'Count',
                        data: [data.userCount, data.visitorCount, data.woCount, data.bookingCount, data.packageCount],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
