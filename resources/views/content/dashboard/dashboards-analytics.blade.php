@extends('layouts/contentNavbarLayout')

@section('title', 'Brgy')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="row gy-4">
    <!-- Congratulations card -->
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Welcome {{ Auth::user()->name }}! 🎉</h4>

            </div>
        </div>
    </div>
    <!--/ Congratulations card -->

</div>
@endsection