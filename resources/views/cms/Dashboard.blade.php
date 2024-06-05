@extends('layouts.Base')
@section('title', 'Dashboard')
@section('head-content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</div>
@endsection
@section('content')
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Pengunjung</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <span id="visitorCount">Loading...</span>
                    </div>
                    <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Earnings (Annual) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Bookings</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">650</div>
                    <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-shopping-cart fa-2x text-success"></i>
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
                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/api/visitors/count',
            method: 'GET',
            success: function(response) {
                $('#visitorCount').text(response.count);
            },
            error: function() {
                $('#visitorCount').text('Error loading visitor count');
            }
        });
    });
</script>
@endsection