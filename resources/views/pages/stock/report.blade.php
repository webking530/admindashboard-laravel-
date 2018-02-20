@extends('layouts.common.index')

@section('title')
  Reports
@endsection

@section('styles')
<link href="css/system/switchery.min.css" rel="stylesheet">
<style>
.title {
  font-weight: bold;
  font-size: 20px;
}
.table td {
  padding: 0;
}
.table td.dataTables_empty {
  padding: 1rem;
}
.loading {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: #00000077;
  display: none;
}
.loader {
  width: 70px;
}
</style>
@endsection

@section('page-title')
  Report Management
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="py-3 pl-5 row">
      <div class="col-md-6">        
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input show-hidden" id="check_in_stock" checked>
          <label class="custom-control-label" for="check_in_stock"> < Show products in stock</label>
        </div>
        <div class="custom-control custom-checkbox mt-2">
          <input type="checkbox" class="custom-control-input show-hidden" id="check_out_stock" checked>
          <label class="custom-control-label" for="check_out_stock"> < Show products out of stock</label>
        </div>
      </div>
      <div class="col-md-6 pull-right pr-5">
        <button class="btn btn-rounded btn-outline-info float-right" data-toggle="modal" data-target="#size-modal">Size filter</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 row">
        <div class="col-md-4">
          <div class="form-group row">
            <label for="quantity" class="col-sm-4 text-right control-label col-form-label">Date:</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="date" value="{{date('Y-m-d')}}">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label for="quantity" class="col-sm-4 text-right control-label col-form-label">Category:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="category">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label for="quantity" class="col-sm-4 text-right control-label col-form-label">Product:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="product">
            </div>
          </div>
        </div>
        {{-- <div class="col-md-3">
          <div class="form-group row">
            <label for="quantity" class="col-sm-4 text-right control-label col-form-label">Size:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="size">
            </div>
          </div>
        </div> --}}
      </div>
      <div class="col-md-2 row">
        <div class="col-md-6">
          <button class="btn btn-rounded btn-outline-info float-right" id="btn_search">Search</button>
        </div>
        <div class="col-md-6">
          <button class="btn btn-rounded btn-outline-info float-right" id="btn_clear">Clear</button>
        </div>
      </div>
    </div>
    <div class="table-responsive table-in-stock">
      <div class="row mx-0">
        <div class="col-md-2">
          <div class="title">In-Stock</div>
        </div>
        <div class="col-md-10">
          <button class="btn btn-rounded btn-outline-info" id="btn-export-instock">Export</button>
        </div>
      </div>
      <table id="in_stock_table" class="table table-bordered table-striped">
        <thead id="in_stock_table_header">
        </thead>
        <tbody id="in_stock_table_body">
        </tbody>
      </table>
    </div>
    <div class="table-responsive table-out-stock pt-4">
      <div class="row mx-0">
        <div class="col-md-2">
          <div class="title">Out-Stock</div>
        </div>
        <div class="col-md-10">
          <button class="btn btn-rounded btn-outline-info" id="btn-export-outstock">Export</button>
        </div>
      </div>
      <table id="out_stock_table" class="table table-bordered table-striped">
        <thead id="out_stock_table_header">
        </thead>
        <tbody id="out_stock_table_body">
        </tbody>
      </table>
    </div>
  </div>
  <div class="loading">
    <div class="loader">
      <div class="loader__figure"></div>
      <div class="loader__label">Loading...</div>
    </div>
  </div>
</div>

{{-- Add Grade Modal --}}
<div id="size-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Show/hide size field</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-show-hide" action="javascript:;">
        <div class="modal-body p-t-40">
          <div id="size_fields" class="row">
            {{-- @foreach ($sizes as $size)
            <div class="col-sm-6">
              <div class="form-group row">
                <label class="col-sm-6 text-right control-label col-form-label">{{ $size->name }}</label>
                <div class="col-sm-6">
                  <input
                    type="checkbox"
                    class="js-switch"
                    data-color="#26c6da"
                    data-secondary-color="#f62d51"
                    size-name="{{ 2 + $size->id }}"
                    @if ($size->visibility == '1')
                      checked
                    @endif
                  />
                </div>
              </div>
            </div>
            @endforeach --}}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-size">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="js/system/switchery.min.js"></script>
<script src="js/report-management.js"></script>
@endsection