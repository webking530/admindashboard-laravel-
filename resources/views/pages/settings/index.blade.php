@extends('layouts.common.index')

@section('title')
  Settings
@endsection

@section('styles')
@endsection

@section('page-title')
  Settings
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    Setting part
  </div>
</div>
<div class="card-group">  
  <div class="card">
    <div class="card-body p-md-5">
      <div class="row">
        <div class="col-md-6">
          <h4 class="card-title">Sizes</h4>
        </div>
        <div class="col-md-6 pull-right">
          <button class="btn btn-rounded btn-outline-info float-right" data-toggle="modal" data-target="#size-modal">Add</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="size-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th>Size Name</th>
              <th>Stock count</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-md-5">
      <div class="row">
        <div class="col-md-6">
          <h4 class="card-title">Types</h4>
        </div>
        <div class="col-md-6 pull-right">
          <button class="btn btn-rounded btn-outline-info float-right" data-toggle="modal" data-target="#type-modal">Add</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="type-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th>Type Name</th>
              <th>Icon</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body p-md-5">
      <div class="row">
        <div class="col-md-6">
          <h4 class="card-title">Colors</h4>
        </div>
        <div class="col-md-6 pull-right">
          <button class="btn btn-rounded btn-outline-info float-right" data-toggle="modal" data-target="#color-modal">Edit</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="color-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th>Stock Count</th>
              <th>Color</th>
            </tr>
          </thead>
          <tbody id="color_table_body">
            <tr>
              <td>1</td>
              <td>0</td>
              <td>#000000</td>
            </tr>
            <tr>
              <td>2</td>
              <td>1</td>
              <td>#000000</td>
            </tr>
            <tr>
              <td>3</td>
              <td>2+</td>
              <td>#000000</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="size-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Size</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-size" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="size-id" value="0">
          <div class="form-group row">
            <label for="size_name" class="col-sm-4 text-right control-label col-form-label">Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="size_name" required>
            </div>
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

<div id="type-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Type</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-type" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="type-id" value="0">
          <div class="form-group row">
            <label for="type_name" class="col-sm-4 text-right control-label col-form-label">Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="type_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="icon" class="col-sm-4 text-right control-label col-form-label">Icon:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="icon" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="country" class="col-sm-4 text-right control-label col-form-label">Color:</label>
            <div class="col-sm-8">
              <input type="color" id="color" name="color" value="#000000">&nbsp;&nbsp;&nbsp;
              <label id="colorLabel">#000000</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-type">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="color-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Color</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-color" action="javascript:;">
        <div class="modal-body p-t-40">
          <div class="form-group row">
            <label for="country" class="col-sm-4 text-right control-label col-form-label">0 :</label>
            <div class="col-sm-8">
              <input type="color" id="color0" name="color" value="#000000">&nbsp;&nbsp;&nbsp;
              <label id="label0">#000000</label>
            </div>
          </div>
          <div class="form-group row">
            <label for="country" class="col-sm-4 text-right control-label col-form-label">1 :</label>
            <div class="col-sm-8">
              <input type="color" id="color1" name="color" value="#000000">&nbsp;&nbsp;&nbsp;
              <label id="label1">#000000</label>
            </div>
          </div>
          <div class="form-group row">
            <label for="country" class="col-sm-4 text-right control-label col-form-label">2+ :</label>
            <div class="col-sm-8">
              <input type="color" id="color2" name="color" value="#000000">&nbsp;&nbsp;&nbsp;
              <label id="label2">#000000</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-type">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="js/types.js"></script>
<script src="js/sizes.js"></script>
<script src="js/colors.js"></script>
@endsection