@extends('layouts.master')

@section('title')
  Estimate
@endsection
 
@section('body-content')
  

   <div class="card bg-white animated slideInRight" id="divTable">
      <div class="card-header bg-info text-white">
        All Estimates of <span class="test-capitalize">{{$client->fullname}}</span>
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
                   <th class="text-center">estimate NO</th>
                   <th class="text-center">Amount</th>
                   <th class="text-center">estimate Date</th>
                   <th class="text-center">Expiry Date</th>
                   <th class="text-center">Action</th>
                 </tr>
               </thead>
               
               <tbody>
                <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
               @foreach($estimates as $estimate)       
               <tr class="text-center">
                 <td>{{$count++ }}</td>
                 <td>{{$estimate->estimate_no }}</td>
                 <td>{{$estimate->total}} /-</td>
                 <td>{{date('M d,Y',strtotime($estimate->estimate_date))}}</td>
                 <td>
                 {{'',$now = \Carbon\Carbon::now(),$due_date=\Carbon\Carbon::parse($estimate->expiry_date),$diff=$now->diffInDays($due_date)}} 
                 @if($now>=$due_date)
                     <span class="text-danger">{{date('M d,Y',strtotime($estimate->expiry_date))}}</span><br>
                     <span class="text-danger ">{{$diff+1}} day(s) passed.</span>
                 @else
                     <span class="text-success">{{date('M d,Y',strtotime($estimate->expiry_date))}}</span><br>
                     <span class="text-success">{{$diff+1}} day(s) to go.</span>
                 @endif
                 </td>
                 <td>
                   <div class="row">
                       <div class="col-xs-6">
                        @if($estimate->status=='pending')
                         <button class="sendestimate btn btn-sm btn-info" data-target="#estimateModal" data-toggle="modal" id="{{$estimate->id}}" title="SEND ESTIMATE" type="button"><i class="fa fa-send"></i></button>  
                        @else
                          <a href="/convertInvoice/{{$estimate->id}}"><button class="btn btn-sm btn-info" title="MAKE INVOICE" type="button"><i class="fa fa-plus"></i></button></a>
                        @endif
                       </div>

                       <div class="col-xs-6">
                         <a href="/estimatePdf/{{$estimate->id}}" target="_blank" title="PDF VIEW"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button>  
                         </a>
                       </div>
                       <br><br>
                       <div class="col-xs-6">
                         <a href="/editEstimate/{{$estimate->id}}">
                           <button class="btn btn-sm btn-primary" title="EDIT ESTIMATE"><i class="fa fa-pencil"></i></button>
                         </a>
                       </div>

                       <div class="col-xs-6">
                         <button type="button" class="btn btn-sm btn-danger deleteestimate" title="DELETE ESTIMATE" id="{{ $estimate->id }}"><i class="fa fa-trash"></i></button>
                       </div>
                   </div>
                 </td>
               </tr>
             @endforeach

               </tbody>
             </table>
         </div>
            {{$estimates->render()}}
        </div>
  </div>

  <!-- Mail Modal -->
<div id="estimateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Estimate</h4>
      </div>
      <form class="form-horizontal" role="form" action="/sendMail" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        <div class="modal-body">          
        <div class="row" id="sendMail">
        
        <input type="hidden" name="estimate_id" id="estimate_id" value="">
        <input name="client_id" type="hidden" class="form-control" value="{{$client->id}}">
          <div class="col-sm-8">
              <div class="form-group">
                <label class="col-sm-2 control-label">To :</label>
                <div class="col-sm-10">
                  <input name="emailTo" type="email" class="form-control emailTo" value="{{$client->email}}">
                </div>
              </div>
              <div class="row">
              <div class="form-group">
                <label class="col-sm-2 control-label">Cc :</label>
                <div class="col-sm-10">
                  <input name="cc" id="cc" type="email" class="form-control">
                </div>
              </div>
            </div>            
          </div>
        </div>
        </div>

        <div class="modal-footer">
          <div class="row">
              <div class="col-xs-6">
                  <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">
                  <i class="fa fa-remove"></i> Close</button>     
              </div>
              <div class="col-xs-6">
                  <button type="submit" class="btn btn-success btn-block">
                  <i class="fa fa-check"></i> Send Mail</button>     
              </div>
          </div>
        </div>
       </form>
    </div>
  </div>
</div>
<!--end of modal-->

@endsection

@section('script-content')
<script src="{{ URL::asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
  <!-- end page scripts -->
  <!-- initialize page scripts -->
  <script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
  <script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>
<script type="text/javascript">
  $('.sendestimate').click(function(){
    $("#estimate_id").val($(this).attr('id'));
});

$('.deleteestimate').click(function(event) {
  var data=$(this).attr('id');
   swal({
    title: 'Delete this estimate?',
    showCancelButton: true,
    closeOnConfirm: false,
    animation: 'slide-from-top',
  }, function (inputValue) {
    if (inputValue === false) {
      return false;
    }
    else{
         $.ajax({
          url:"/deleteEstimate",
          method:"POST",
          data:"id="+data+"&_token="+$('[name="_token"]').val(),
          success:function(response){
            if(response=='0'){
              swal('Success', 'estimate deleted successfully');
              setTimeout(function() {
                $('#table').load('/getClientEstimate'+data+' #table');
              },1000);   
            }
        }
      });
    }
  });
});

</script>

@endsection
