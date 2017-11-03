@extends('layouts.master')

@section('title')
  All Clients
@endsection

@section('body-content')


<div class="card bg-white animated slideInRight" id="divTable">
  <div class="card-header bg-info text-white">
    <a href="/new_client"><span class="pull-right"><i class="fa fa-plus-circle"></i> Add Client</span></a>
  </div>
  <div class="card-block" >
    <div class="row">
      <div class="table-responsive" id="table_wrapper">
        <table id="client_table" class="table datatable table-bordered table-condensed table-striped m-b-0">
         <thead class="text-center">
           <tr class="text-center">
             <th>#</th>
             <th>Name</th>
             <th>Contact</th>
             <th>Email</th>
             <th>Tax</th>
             <th>Address</th>
             <th>Enquiry Date</th>
             <th style="width: 150px;">Action</th>
           </tr>
         </thead>

         <tbody>
           <?php $count=1;?>
           <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
             @foreach ($clients as $client)
                <tr class="text-center">
                 <td>{{ $count++ }}</td>
                 <td>{{ $client->fullname }}</td>
                 <td>{{ $client->contact_no}}<br> {{ ($client->alt_contact==null)?"":$client->alt_contact}}</td>
                 <td>{{ $client->email}}</td>
                 <td>{{ ($client->tax==null)?"No":ucfirst($client->tax)}}</td>
                 <td>
                  {{ isset($client)?$client->street.",".$client->pincode.",".$client->city.",".$client->state:'--' }}
                 </td>
                 <td>{{ date("d M, Y",strtotime($client->created_at)) }}</td>
                 <td>
                 <div class="row">
                   <div class="col-xs-5">
                     <form action="/new_invoice" method ="POST">
                      {{ csrf_field() }}
                      <input type="hidden" name="client_id" value="{{$client->id}}">
                      <button class="btn btn-success btn-sm" type="submit" title="Make Invoice"><i class="fa fa-files-o "></i></button>
                     </form>
                   </div>
                   <div class="col-xs-4">
                     <form action="/new_estimation" method ="POST" id="modalForm">
                      {{ csrf_field() }}
                      <input type="hidden" name="client_id" value="{{$client->id}}">
                      <button class="btn btn-primary btn-sm" type="submit" title="Make Quote"><i class="fa fa-plus-square"></i></button>
                     </form>
                   </div>
                  </div>
                  <br>
                  <div class="row">
                   <div class="col-xs-5">
                    <a href="/edit_client/{{$client->id}}" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-pencil"></i></a>
                   </div>
                   <div class="col-xs-4">
                    <button class="btn btn-danger btn-sm deleteClient" title="Delete" id="{{$client->id}}"><i class="fa fa-trash"></i>
                    </button>
                   </div>
                 </div>
                </td>
               </tr>
             @endforeach
         </tbody>
       </table>
     </div>
    </div>
  </div>
  </div>


@endsection

@section('script-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
<script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>

<script type="text/javascript">
  $(".deleteClient").click(function(event) {
    var id=$(this).attr('id');
    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this Client Data',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes,I want to delete it!',
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    }, function () {
         $.ajax({
      url:'/deleteClient/'+id,
      method:"GET",
      data:"emp_id="+id+"&_token="+$('[name="_token"]').val(),
      success:function(response){
        if(JSON.parse(response)=='success'){
          setTimeout(function(){
          swal('Deleted','Client Deleted with all Paid Invoices','Success');
          $('#client_table').load('/all_client #client_table');  
         
        },1000);
        }else{
          swal("Cancelled", "Client has some Pending Invoices", "error");
        }
      }
    });
    });
      
  });
</script>

@endsection
