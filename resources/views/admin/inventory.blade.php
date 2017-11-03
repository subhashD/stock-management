@extends('layouts.master')
@section('title')
Inventory
@endsection

@section('body-content')

  <div class="card bg-white animated slideInLeft">
    <div class="card-header bg-info text-white">
      Product Details
      <div class="pull-right">
        <button type="button" name="button" class="btn btn-default" data-toggle="modal" data-target="#stock">
          <i class="fa fa-plus"></i> Add Stock
        </button>
        <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#ProductModal">
          <i class="fa fa-plus"></i> Add New Product
        </button>
      </div>
    </div>
    <div class="card-block">
      <div class="row m-a-0">
        <div class="table-responsive">
          <table class="table datatable table-striped data-table" id="productTable">
            <thead>
              <tr>
                <td>#</td>
                <td>Name</td>
                <td>Godown</td>
                <td>Price</td>
                <td>Selling Price</td>
                @if(isset($CompanyDetail)?$CompanyDetail->gst:''!=null)
                  <td>Tax</td>
                @endif
                <td>In Stock</td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
              @foreach ($products as $product)
                <tr>
                  <td>{{$count++}}</td>
                  <td>{{$product->name}}</td>
                  <td>{{$product->godown->name}}</td>
                  <td>{{$product->price}}</td>
                  <td>{{$product->selling_price}}</td>
                  @if(isset($CompanyDetail)?$CompanyDetail->gst:''!=null)
                    <td>{{$product->tax!=null?$product->tax:'-'}}</td>
                  @endif
                  <td>{{$product->qty_avail}}</td>
                  <td class="pa-0">
                    <button type="button" class="btn btn-primary edit" id="{{$product->id}}"  title="edit"
                      data-toggle="modal" data-target="#editModal">
                      <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger delete" id="{{$product->id}}" title="delete">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>

              @endforeach
            </tbody>
          </table>
        </div>
        {{$products->render()}}
      </div>
    </div>
  </div>

<!-- New Product Modal -->
<div id="ProductModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Product</h4>
      </div>

      <form action="/save_product" method="post">
        {{csrf_field()}}
        <div class="modal-body">


            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label col-xs-3"><strong>Product Name :</strong></label>
                  <input type="text" class="form-control" name="name" required>
                </div>
              </div>
              @if(isset($CompanyDetail))
                @if($CompanyDetail->gst!=null)
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="control-label col-xs-12"><strong>HSN/SAC :</strong></label>
                    <input type="text" class="form-control" name="hsnSac" required>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="control-label col-xs-12"><strong>TAX % :</strong></label>
                    <input type="text" class="form-control" name="tax" required>
                  </div>
                </div>
                @endif
              @endif
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Price :</strong></label>
                  <input type="text" class="form-control col-sm-12" name="price" required min="0">
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Selling Price :</strong></label>
                  <input type="text" class="form-control col-sm-12" name="selling_price" required min="0">
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Godown :</strong></label>
                 <select class="form-control col-xs-12 godown" name="godown" style="width:100%">
                  @foreach ($godowns as $godown)
                    <option value="{{$godown->id}}">{{$godown->name}}</option>
                  @endforeach
                </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-12"><strong>Description :(optional)</strong></label>
              <textarea name="description" rows="5" class="form-control"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fa fa-times"></i></button>
          <button type="submit" class="btn btn-success">SAVE <i class="fa fa-paper-plane"></i></button>
        </div>
      </form>
    </div>

  </div>
</div>

<!--Edit Product Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Product</h4>
      </div>

      <form action="/save_product" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" id="product_id" value="">
        <div class="modal-body">

          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Product Name :</strong></label>
                <input type="text" class="form-control" name="name" id="product_name" required>
              </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label col-xs-12"><strong>Godown :</strong></label>
                 <select class="form-control godown" name="godown" style="width:100%">
                  @foreach ($godowns as $godown)
                    <option value="{{$godown->id}}">{{$godown->name}}</option>
                  @endforeach
                </select>
                </div>
              </div>
            @if(isset($CompanyDetail))
              @if($CompanyDetail->gst!=null)
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label col-xs-12"><strong>HSN/SAC :</strong></label>
                  <input type="text" class="form-control" name="hsnSac" id="hsnSac" required>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label col-xs-12"><strong>TAX % :</strong></label>
                  <input type="text" class="form-control" name="tax" id="tax" required>
                </div>
              </div>
              @endif
            @endif
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Price :</strong></label>
                  <input type="text" class="form-control col-sm-12" name="price" id="product_price" required min="0">
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Selling Price :</strong></label>
                  <input type="text" class="form-control col-sm-12" name="selling_price" id="product_sp" required min="0">
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Stock :</strong></label>
                  <input type="text" class="form-control col-sm-12" name="qty_avail" id="qty_avail" required min="0">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-12"><strong>Description :(optional)</strong></label>
              <textarea name="description" rows="5" class="form-control" id="product_desc"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fa fa-times"></i></button>
          <button type="submit" class="btn btn-success">SAVE <i class="fa fa-paper-plane"></i></button>
        </div>
      </form>
    </div>

  </div>
</div>

<!--Stock Modal -->
<div id="stock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Stock</h4>
      </div>

      <form action="/add_stock" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" id="product_id" value="">
        <div class="modal-body">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Product :</strong></label>
                <select class="form-control col-xs-12" name="product" style="width:100%">
                  @foreach ($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Godown :</strong></label>
                <select class="form-control col-xs-12 godown" name="godown" style="width:100%">
                  @foreach ($godowns as $godown)
                    <option value="{{$godown->id}}">{{$godown->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Vendor :</strong></label>
                <select class="form-control" name="vendor" style="width:100%">
                  @foreach ($vendors as $vendor)
                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Stock :</strong></label>
                <input type="text" class="form-control col-sm-12" name="quantity" id="qty_avail" required min="0">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Comment (optional) :</strong></label>
                <textarea name="comment" class="form-control col-sm-12" rows="5" cols="80"></textarea>
              </div>
            </div>

          </div><br>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fa fa-times"></i></button>
          <button type="submit" class="btn btn-success">SAVE <i class="fa fa-paper-plane"></i></button>
        </div>
      </form>
    </div>

  </div>
</div>

@endsection

@section('script-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
<script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>

<script type="text/javascript">
$(function(){
  $('.godown').select2();
})
$(document).on('click','.delete',function(){

  let id=$(this).attr('id');
  swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true
}, function () {
      $.ajax({
        url: '/deleteProduct/'+id,
        type: 'GET',
      })
      .done(function(res) {
        if(JSON.parse(res)=="success"){
          setTimeout(function () {
            swal("Product Deleted");
            $('#productTable').load('/inventory #productTable');
          },1000);
        }
      });
});
});

$(document).on('click','.edit',function(){
  let id=$(this).attr('id');
  $('#product_id').val(id);
  $.ajax({
    url: '/getProductDesc/'+id,
    type: 'GET',
    })
  .done(function(response) {
    let res=JSON.parse(response);
    $('#product_name').val(res['name']);
    $('#product_price').val(res['price']);
    $('#product_sp').val(res['selling_price']);
    $('#qty_avail').val(res['qty_avail']);
    $('#product_desc').val(res['desc']);
    $('#tax').val(res['tax']);
    $('#hsnSac').val(res['hsnSac']);
    console.log(response);
  });
});
</script>
@endsection
