@extends('layouts.common.index')

@section('title')
  Products
@endsection

@section('styles')
@endsection

@section('page-title')
  Products Management
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="row">
      <div class="col-md-1">
        <button class="btn btn-rounded btn-outline-info" id="btn-add" data-toggle="modal" data-target="#product-modal">Add</button>
      </div>
      <div class="col-md-11 pull-right">
        <button class="btn btn-rounded btn-outline-info float-right" id="btn-import" data-toggle="modal" data-target="#import-modal">Import</button>
        <span class="float-right">&nbsp;&nbsp;&nbsp;</span>
        <button class="btn btn-rounded btn-outline-info float-right" id="btn-export">Export</button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="product-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Buy price</th>
            <th>Sell price</th>
            <th>Date updated</th>
            <th>Current stock</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Add Grade Modal --}}
<div id="product-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-product" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="edit-id" value="0">
          <div class="form-group row">
            <label for="name" class="col-sm-4 text-right control-label col-form-label">Product:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="product_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="buy_price" class="col-sm-4 text-right control-label col-form-label">Buy price:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="buy_price" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="sell_price" class="col-sm-4 text-right control-label col-form-label">Sell price:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="sell_price" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 text-right control-label col-form-label">Category:</label>
            <div class="col-sm-8">
              <select class="form-control" id="category" required>
                <option value="">-Choose category-</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-product">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="import-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Stock</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-import" action="javascript:;">
        <div class="modal-body p-t-40">
          <div class="form-group row d-flex align-items-center">
            <label for="file" class="col-sm-4 text-right control-label col-form-label">Import file:</label>
            <div class="col-sm-8">
              <input
                type="file"
                id="file"
                class="dropify"
                data-allowed-file-extensions="xlsx"
                required
                data-validation-required-message="File is required"
              />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="js/products.js"></script>
@endsection