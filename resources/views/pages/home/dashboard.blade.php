@extends('layouts.common.index')

@section('title')
  Dashboard
@endsection

@section('styles')
<!-- Dashboard 1 Page CSS -->
<link href="css/pages/dashboard1.css" rel="stylesheet">
@endsection

@section('page-title')
Dashboard
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex m-b-40 align-items-center no-block">
          <h5 class="card-title ">Stock changes over time</h5>
          <div class="ml-auto">
            <ul class="list-inline font-12">
              <li><i class="fa fa-circle text-cyan"></i> This week</li>
              <li><i class="fa fa-circle text-primary"></i> Last week</li>
            </ul>
          </div>
        </div>
        <div id="morris-area-chart" style="height: 340px;"></div>
        {{-- <div id="main" style="height: 340px;"></div> --}}
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
      <div class="card">
        <div class="card-body bg-light">
          <div class="row">
            <div class="col-6">
              <h3>Current products in stock </h3>
              {{-- <h5 class="font-light m-t-0">Report for this month</h5> --}}
            </div>
            <div class="col-6 align-self-center display-6 text-right">
              {{-- <h2 class="text-success">$3,690</h2> --}}
            </div>
          </div>
          <div class="table-responsive">
              <table class="table table-bordered table-striped" id="table_dashboard">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Current stock</th>
                    <th>Sales</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($products as $product)
                    <tr>
                      <td>{{ $product['no'] }}</td>
                      <td>{{ $product['product'] }}</td>
                      <td>{{ $product['category'] }}</td>
                      <td>{{ $product['stock'] }}</td>
                      <td>{{ $product['sales'] }}</td>
                    </tr>                      
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- Popup message jquery -->
<script src="js/system/jquery.toast.js"></script>
<!-- Chart JS -->
<script src="js/system/echarts-all.js"></script>
<script src="js/dashboard.js"></script>
@endsection