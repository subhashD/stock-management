@extends('layouts.master')
@section('title')
Vendor
@endsection

@section('body-content')

  <div class="card bg-white animated slideInLeft">
    <div class="card-header bg-info text-white">
      Vendor Details
      <div class="pull-right">
        <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#vendorModal">
          <i class="fa fa-plus"></i> Add New Vendor
        </button>
      </div>
    </div>
    <div class="card-block">
      <div class="row m-a-0">
        <div class="table-responsive">
          <table class="table table-striped data-table" id="vendorTable">
            <thead>
              <tr>
                <td>#</td>
                <td>Vendor</td>
                <td>Phone</td>
                <td>Store/Company</td>
                <td>Contact</td>
                <td>Address</td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
              @foreach ($vendors as $vendor)
                <tr>
                  <td>{{$count++}}</td>
                  <td>{{$vendor->name}}</td>
                  <td>{{$vendor->phone}}</td>
                  <td>{{$vendor->company_name}}</td>
                  <td>
                      {{!is_null($vendor->company_phone)?$vendor->company_phone:'-'}}<br>
                      {{!is_null($vendor->company_email)?$vendor->company_email:'-'}}
                  </td>
                  <td>
                    {{strlen($vendor->address)>25?substr($vendor->address,0,22).'...':$vendor->address}}<br>
                    {{$vendor->city}}
                  </td>
                  <td>
                    <button type="button" class="btn btn-md btn-primary edit" title="Edit" id="{{$vendor->id}}" data-toggle="modal" data-target="#editVendorModal">
                      <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-md btn-danger delete" title="Delete" id="{{$vendor->id}}">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div id="vendorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Vendor</h4>
      </div>

      <form action="/add_vendor" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Vendor Name :</strong></label>
                <input type="text" class="form-control" name="name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Vendor Phone :</strong></label>
                <input type="text" class="form-control" name="phone" required pattern=".{10,15}">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Company/Store Name :</strong></label>
                <input type="text" class="form-control" name="company_name" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Company Phone :</strong></label>
                <input type="text" class="form-control col-sm-12" name="company_phone" required pattern=".{10,15}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Company Email :</strong></label>
                <input type="email" class="form-control col-sm-12" name="company_mail">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-12"><strong>Company Address:</strong></label>
              <textarea name="address" rows="5" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>State :</strong></label>
                <select class="form-control states" name="state" id="state" style="width:100%">
                  @foreach ($states as $state)
                    <option value="{{$state}}">{{$state}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>City :</strong></label>
                <select class="form-control cities" name="city" id="city" style="width:100%"></select>
              </div>
            </div>
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

<!-- edit Modal -->
<div id="editVendorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Vendor Details</h4>
      </div>

      <form action="/add_vendor" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" id="vendor_id" value="">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Vendor Name :</strong></label>
                <input type="text" class="form-control" name="name" id="vendor_name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Vendor Phone :</strong></label>
                <input type="text" class="form-control" name="phone" id="vendor_phone" required pattern=".{10,15}">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label col-xs-12"><strong>Company/Store Name :</strong></label>
                <input type="text" class="form-control" name="company_name" id="company_name" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Company Phone :</strong></label>
                <input type="text" class="form-control col-sm-12" name="company_phone" id="company_phone"  required pattern=".{10,15}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>Company Email :</strong></label>
                <input type="email" class="form-control col-sm-12" name="company_mail" id="company_mail">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-12"><strong>Company Address:</strong></label>
              <textarea name="address" rows="5" class="form-control" id="address"></textarea>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>State :</strong></label>
                <select class="form-control states" name="state" id="state" style="width:100%">
                  @foreach ($states as $state)
                    <option value="{{$state}}">{{$state}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-sm-12"><strong>City :</strong></label>
                <select class="form-control cities" name="city" id="city" style="width:100%"></select>
              </div>
            </div>
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

@endsection

@section('script-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type="text/javascript">
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
        url: '/deleteVendor/'+id,
        type: 'GET',
      })
      .done(function(res) {
        if(JSON.parse(res)=="success"){
          setTimeout(function () {
            swal("Vendor Deleted");
            $('#vendorTable').load('/vendors #vendorTable');
          },1000);
        }
      });
});
});

$(document).on('click','.edit',function(){
  let id=$(this).attr('id');
  $('#vendor_id').val(id);
  $.ajax({
    url: '/getVendor/'+id,
    type: 'GET',
    })
  .done(function(response) {
    let res=JSON.parse(response);
    $('#vendor_name').val(res['name']);
    $('#vendor_phone').val(res['phone']);
    $('#company_name').val(res['company_name']);
    $('#company_phone').val(res['company_phone']);
    $('#company_mail').val(res['company_email']);
    $('#address').val(res['address']);
    $('.states').val(res['state']).change();
    $('.citiess').val(res['city']).change();
    console.log(response);
  });

});

$('.states').on('change',function(){
  $.ajax({
    url: '/getCity/'+$(this).val(),
    type: 'GET',
    })
  .done(function(res) {
    $('.cities').html();
    $('.cities').html(res);
    // console.log(res);
  });

})
</script>
@endsection
