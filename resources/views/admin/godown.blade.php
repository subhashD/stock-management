@extends('layouts.master')
@section('title')
Godowns
@endsection

@section('body-content')

  <div class="card bg-white animated slideInLeft">
    <div class="card-header bg-info text-white">
      Customer Details
      <div class="pull-right">
        <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#godownModal">
          <i class="fa fa-plus"></i> Add New Godown
        </button>
      </div>
    </div>
    <div class="card-block">
      <div class="row m-a-0">
        <div class="table-responsive">
          <table class="table table-striped data-table" id="godowntable">
            <thead>
              <tr>
                <td>#</td>
                <td>Name</td>
                <td>Contact Person</td>
                <td>Address</td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $count=1 ?>
              @foreach ($godowns as $godown)
                <tr>
                  <td>{{$count++}}</td>
                  <td>{{$godown->name}}</td>
                  <td>{{$godown->person}}<br>{{$godown->contact}}</td>
                  <td>{{$godown->address}}</td>
                  <td class="pa-0">
                    <button type="button" class="btn btn-danger delete" id="{{$godown->id}}" title="delete">
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
<div id="godownModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Godown</h4>
      </div>

      <form action="/save_godown" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
              <label class="control-label col-xs-3"><strong>Godown Name :</strong></label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong>Person In Charge :</strong></label>
                  <input type="text" class="form-control col-sm-12" name="person" required>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label col-sm-12"><strong> Person In Charge Phone:</strong></label>
                  <input type="text" class="form-control col-sm-12" name="person_phone" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-12"><strong>Godown Address:</strong></label>
              <textarea name="address" rows="5" class="form-control"></textarea>
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


<!-- Move Stock -->
<div id="migrateStock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Godown For Migration</h4>
      </div>

      <form action="/migrate_stock" method="post">
        {{csrf_field()}}
        <input type="hidden" name="delete_godown" id="delete_godown">
        <div class="modal-body">
          <table class="table table-striped" id="targetGodown">
            <thead>
              <tr class="text-center">
                <td>#</td>
                <td>Select</td>
                <td>Godown</td>
              </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fa fa-times"></i></button>
          <button type="submit" class="btn btn-success">SAVE <i class="fa fa-paper-plane"></i></button>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- Delete Stock -->
<div id="deleteStock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="margin-top: 200px;">
      <div class="modal-headeaaar" style="background: transparent;">
        
      </div>

      <div>
          <div class="col-xs-12 text-center">
            <h1 class="text-white >Confirm Delete?">Confirm Delete?</h1>
            <h3 class="text-info">You won't be able to revert this change.</h3>
          </div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-success btn-block" data-dismiss="modal">Cancel. <i class="fa fa-times"></i></button>
          </div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-danger btn-block" id="confirmDelete">Yes, Delete it.<i class="fa fa-check"></i></button>
          </div>
          <div class="text-center col-xs-12 hidden" id="deleteMsg">
            <h3 class="text-white">Deleting...</h3>
          </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('script-content')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->
<script type="text/javascript">
$(document).on('click','.delete',function(){
   $('#deleteMsg').addClass('hidden');
  $('#deleteStock').modal('show');
  let id=$(this).attr('id');
  $('#confirmDelete').attr('data-id',id);
  // swal({
  // title: 'Are you sure?',
  // text: "You won't be able to revert this!",
  // type: 'warning',
  // showCancelButton: true,
  // closeOnConfirm: false,
  // showLoaderOnConfirm: true
  // },function () {
  //     $.ajax({
  //       url: '/deleteGodown/'+id,
  //       type: 'GET',
  //     })
  //     .done(function(res) {
  //       if(JSON.parse(res)=="success"){
  //         setTimeout(function () {
  //           swal("Godown Deleted");
  //           $('#godowntable').load('/godown #godowntable');
  //         },1000);
  //       }else{
  //         alert();
  //         console.log(res);
  //         window.open("https://www.google.com");
  //       }
  //     });
  // });
});
$(document).on('click','#confirmDelete',function(){
  let id=$(this).attr('data-id');
  $('#deleteMsg').removeClass('hidden');
   $.ajax({
        url: '/deleteGodown/'+id,
        type: 'GET',
      })
      .done(function(res) {
        if(JSON.parse(res)=="success"){ 
          $('#deleteStock').modal('hide');
          $('#godowntable').load('/godown #godowntable');
        }else{
          $('#deleteStock').modal('hide');
          $('#migrateStock').modal('show');
          $('#delete_godown').val(id);
          var resTemp=JSON.parse(res);

          console.log(resTemp);
          var str="";
          for(var i=0;i<resTemp['count'];i++){
            console.log(resTemp['data'][i]['id']);
            str +="<tr class='text-center'><td>"+(i+1)+"</td><td><input type='radio' class='form-control' value='"+resTemp['data'][i]['id']+"' name='godown_id' /></td>";
            str +="<td><span class='text-info'>"+resTemp['data'][i]['name']+"</span></td></tr>";
          }
          $('#targetGodown').append(str);
          }
      });
});
</script>
@endsection
