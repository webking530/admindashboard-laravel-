@extends('layouts.common.index')

@section('title')
  Stocks
@endsection

@section('styles')
<style>
  .daterangepicker {
    background-color: #272c36;
  }
  .daterangepicker .ranges li:hover {
    background-color: #000;
  }
</style>
@endsection

@section('page-title')
  Stock Management
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="row">
      <div class="col-md-1">
        <button class="btn btn-rounded btn-outline-info" id="btn-add" data-toggle="modal" data-target="#stock-modal">Add</button>
      </div>
      <div class="col-md-3">
        <input class="form-control" id="daterange" type="text" name="daterange" value="" autocomplete="off" />
      </div>
      <div class="col-md-8 pull-right">
        <button class="btn btn-rounded btn-outline-info float-right" id="btn-import" data-toggle="modal" data-target="#import-modal">Import</button>
        <span class="float-right">&nbsp;&nbsp;&nbsp;</span>
        <button class="btn btn-rounded btn-outline-info float-right" id="btn-export">Export</button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="stock-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>Updated Date</th>
            <th>Comment</th>
            <th>Change / Product / Size</th>
            <th>Category</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Add Grade Modal --}}
<div id="stock-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Stock</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-stock" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="edit-id" value="0">
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
          <div class="form-group row">
            <label class="col-sm-4 text-right control-label col-form-label">Product:</label>
            <div class="col-sm-8">
              <select class="form-control" id="product" required>
                <option value="">-Choose product-</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="quantity" class="col-sm-4 text-right control-label col-form-label">Quantity:</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="quantity" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 text-right control-label col-form-label">Size:</label>
            <div class="col-sm-8">
              <select class="form-control" id="size" required>
                <option value="">-Choose size-</option>
                @foreach ($sizes as $size)
                  <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 text-right control-label col-form-label">Type:</label>
            <div class="col-sm-8">
              <select class="form-control" id="type" required>
                <option value="">-Choose type-</option>
                @foreach ($types as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 text-right control-label col-form-label">Add or Substract:</label>
            <div class="col-sm-8">
              <select class="form-control" id="addable" required>
                <option value="1">Add(+)</option>
                <option value="0">Substract(-)</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="comment" class="col-sm-4 text-right control-label col-form-label">Comment:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="comment" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-stock">Add</button>
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
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-stock">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="js/stock-management.js"></script>
@endsection