@extends('layouts.master')

@section('title')
  Payments
@endsection
 
@section('body-content')
  

   <div class="card bg-white animated slideInRight" id="divTable">
      <div class="card-header bg-info text-white">
        All Invoice
        <a href="" class="pull-right">
          <span class="btn btn-sm btn-default">
            <i class="fa fa-eye"></i>View All
          </span>
        </a> 
      </div>

      <div class="card-block">
         <div class="row">
                 <form action="" method="POST" id="custTaxSearch">
                  {{ csrf_field() }}
                  <div class="col-md-11 row">

                    <div class="col-xs-4">
                     <input type="hidden" name="client_id" value="{{$client->id}}">
                      <select class="form-control" style="width: 100%" name="contact_on_search" value="">
                        <option disabled selected="true">--Select Month--</option>
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">May</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Aug</option>
                        <option value="9">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                      </select>
                    </div>

                    <div class="col-xs-4">
                      
                     <select class="form-control" style="width: 100%" name="contact_year_search" value="">
                          <option disabled selected="true">--Select Year--</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                        </select>
                      
                    </div>

                    <div class="col-xs-4">
                        <select class="form-control" style="width: 100%" name="status_search">
                          <option disabled selected="true">--Select Status--</option>
                          <option value="expired">Date Expired</option>
                          <option value="running">Date Running</option>
                        </select>            
                    </div>
                  </div>
                  <br class="visible-xs visible-sm">
                  <div class="col-md-1">
                    <div class="col-xs-12">
                      <button class="btn btn-primary btn-block">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </form>
                <br><br>
              </div>
         <br>
         <div class="table-responsive">
           <table id="table" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th class="text-center">#</th>
                   <th class="text-center">Name</th>
                   <th class="text-center">Invoice #</th>
                   <th class="text-center">Amount</th>
                   <th class="text-center">Due Date</th>
                   <th class="text-center">Action</th>
                 </tr>
               </thead>
               
               <tbody>
                <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
               @foreach($invoices as $invoice)       
               <tr class="text-center">
                 <td>{{$count++ }}</td>
                 <td>{{$invoice->client->fullname }}</td>
                 @if($invoice->client->tax == 'yes')
                  <td>{{$invoice->tax_invoice}}</td>
                 @else
                  <td>{{$invoice->notax_invoice}}</td>
                 @endif
                 <td>{{$invoice->total}} /-</td>
                 <td>
                 {{'',$now = \Carbon\Carbon::now(),$due_date=\Carbon\Carbon::parse($invoice->due_date),$diff=$now->diffInDays($due_date)}} 
                 @if($now>=$due_date)
                     <span class="text-danger">{{date('M d,Y',strtotime($invoice->due_date))}}</span><br>
                     <span class="text-danger ">{{$diff+1}} day(s) passed.</span>
                 @else
                     <span class="text-success">{{date('M d,Y',strtotime($invoice->due_date))}}</span><br>
                     <span class="text-success">{{$diff+1}} day(s) to go.</span>
                 @endif
                 </td>
                 <td>
                   <div class="row">
                       <div class="col-xs-6">
                        @if($invoice->status=='pending')
                         <button class="payInvoice btn btn-sm btn-info" id="{{$invoice->id}}" title="MAKE PAYMENT" type="button"><i class="fa fa-plus"></i></button>  
                         </a>
                        @else
                          <button type="button" class="btn btn-sm btn-info">PAID</button>
                        @endif
                       </div>

                       <div class="col-xs-6">
                         <a href="/invoicePdf/{{$invoice->id}}" target="_blank" title="PDF VIEW"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button>  
                         </a>
                       </div>
                       <br><br>
                       <div class="col-xs-6">
                         <a href="/editInvoice/{{$invoice->id}}">
                           <button class="btn btn-sm btn-primary" title="EDIT INVOICE"><i class="fa fa-pencil"></i></button>
                         </a>
                       </div>

                       <div class="col-xs-6">
                         <button type="button" class="btn btn-sm btn-danger deleteInvoice" title="DELETE INVOICE" id="{{ $invoice->id }}"><i class="fa fa-trash"></i></button>
                       </div>
                   </div>
                 </td>
               </tr>
             @endforeach

               </tbody>
             </table>
         </div>
            {{$invoices->render()}}
        </div>

  </div>

  
@endsection

@section('script-content')
<script src="{{ URL::asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
  <!-- end page scripts -->
  <!-- initialize page scripts -->
  <script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
  <script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>
<script type="text/javascript">
  
$('.recordPaymentBtn').click(function(){
    $("#invoice_no").val($(this).attr('id'));
});

$('.deleteInvoice').click(function(event) {
  var data=$(this).attr('id');
   swal({
    title: 'Delete this INVOICE?',
    showCancelButton: true,
    closeOnConfirm: false,
    animation: 'slide-from-top',
  }, function (inputValue) {
    if (inputValue === false) {
      return false;
    }
    else{
         $.ajax({
          url:"/deleteInvoice",
          method:"POST",
          data:"id="+data+"&_token="+$('[name="_token"]').val(),
          success:function(response){
            if(response=='0'){
              swal('Success', 'Invoice deleted successfully');
              setTimeout(function() {
                location.reload();
              },1000);   
            }
        }
      });
    }
  });
});

$('.payInvoice').click(function(event) {
  var data=$(this).attr('id');
   swal({
    title: 'Paid???',
    showCancelButton: true,
    closeOnConfirm: false,
    animation: 'slide-from-top',
  }, function (inputValue) {
    if (inputValue === false) {
      return false;
    }
    else{
         $.ajax({
          url:"/payInvoice",
          method:"POST",
          data:"id="+data+"&_token="+$('[name="_token"]').val(),
          success:function(response){
            if(response=='0'){
              swal('Success', 'Invoice Paid successfully');
              setTimeout(function() {
                $('#table').load("/getClientInvoice/"+data+" #table");
              },1000);   
            }
        }
      });
    }
  });
});

</script>

@endsection
