@extends('layouts.master')

@section('title')
  Customer Invoice
@endsection

@section('body-content')


  <div class="card bg-white animated slideInRight" id="divTable">
  <div class="card-header bg-info text-white">
    Non-GST Invoice
     <a href="#payments" data-toggle="modal" id="addDate"><span class="pull-right"><i class="fa fa-plus-circle"></i> Add New Invoice</span></a>
  </div>
   <div class="card-block">
   <div class="row">
     <div class="col-xs-4">
       <input type="text" id="t1" class="form-control col-xs-4" placeholder="Search Name">
     </div>
     <div class="col-xs-4">
       <input type="text" id="t2" class="form-control col-xs-4" placeholder="Search  Phone">
     </div>
     <div class="col-xs-4">
       <input type="text" id="t3" class="form-control col-xs-4" placeholder=" Search Address">
     </div>
   </div>
   <br/>
     <div class="table-responsive">
       <table id="table" class="table table-bordered table-striped">
         <thead>
           <tr>
             <th>#</th>
             <th class="name">Name</th>
             <th class="phone">Contact</th>
             <th style="width: 250px" class="address">Billing Address</th>
             <th>No. of Invoices</th>
             <th>Action</th>
           </tr>
         </thead>

         <tbody>
          <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
              @foreach($clients as $client)
              @if($client->invoice->count()>0)
                <tr class="text-center">
                   <td>{{ $count++ }}</td>
                   <td>{{ $client->fullname }}</td>
                   <td>{{ $client->contact_no}}<br> {{ ($client->alt_contact==null)?"":$client->alt_contact}}</td>
                   <td>{{ isset($client)?$client->street.",".$client->pincode.",".$client->city.",".$client->state:'--' }}</td>
                   <td>
                    {{ $client->invoice->count()}}
                   </td>
                   <td>
                      <a href="/getClientInvoice/{{$client->id}}">
                        <button class="btn btn-sm btn-info">
                          <i class="fa fa-eye"></i>View
                        </button>
                      </a>
                  </td>
                </tr>
                @endif
              @endforeach
         </tbody>
        </table>
	  </div>
    </div>
  </div>


  <!--New Invoice Modal -->
  <div id="payments" class="modal fade" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalTitle">New Invoice</h4>
        </div>

        <form action="/new_invoice" method ="POST" id="modalForm">

        {{ csrf_field() }}

          <div class="modal-body">

            <div class="row">
              <div class="form-group col-sm-2">
                  <label for="text"><strong> Select Customer </strong></label>
              </div>
              <div class="form-group col-sm-10">
                <select class="form-control" required style="width: 100%" name='client_id' >
                  <option selected disabled value="">--- Select Client---</option>
                  @foreach($clients as $client)
                    <option value="{{$client->id}}">{{$client->fullname}}</option>
                  @endforeach
                    <option class="bg-danger" value="new_customer">Add New Cleint</option>
                </select>
              </div>
            </div>

            </div>
            <br>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-icon">
              <i class="icon-cursor"></i> <span>Proceed</span>
            </button>
          </div>
       </form>
      </div>
    </div>
 </div>
<!-- Modal end-->

@endsection

@section('script-content')

<script src="{{ URL::asset('vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}} "></script>
<script src="{{ URL::asset('scripts/helpers/smartresize.js')}}"></script>
<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
<script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>
<script src="{{ URL::asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#table_filter').hide();
    $('#table').DataTable();
    setTimeout(function() {
      $('[role=alert]').fadeOut('slow');
    }, 5000);
});


$('#t1').on('keyup',function(){
  var table = $('#table').DataTable();

  table
      .columns( '.name' )
      .search( $('#t1').val() )
      .draw();
});

$('#t2').on('keyup',function(){
  var table = $('#table').DataTable();

  table
      .columns( '.phone' )
      .search( $('#t2').val() )
      .draw();
});

$('#t3').on('keyup',function(){
  var table = $('#table').DataTable();

  table
      .columns( '.address' )
      .search( $('#t3').val() )
      .draw();
});
</script>
</body>


@endsection
