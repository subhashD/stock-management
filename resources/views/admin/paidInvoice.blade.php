@extends('layouts.master')

@section('title')
  Payment Report
@endsection

@section('body-content')


   <div class="card bg-white animated slideInRight" id="divTable">
      <div class="card-header bg-info text-white">
        All Invoice
        <a href="/paid_inv" class="pull-right">
          <span class="btn btn-sm btn-default">
            <i class="fa fa-eye"></i>View All
          </span>
        </a> 
      </div>

      <div class="card-block">
         <div class="row">
             <form action="/filterPaid" method="POST">
              {{ csrf_field() }}
              <div class="col-md-11">
                <div class="col-xs-4">
                  <input type="text" name="start_date" class="form-control" data-provide="datepicker" placeholder="mm/dd/yyyy" onchange="checkVal()">
                </div>

                <div class="col-xs-4">
                  <input type="text" name="end_date" class="form-control" data-provide="datepicker" placeholder="mm/dd/yyyy" onchange="checkVal()">
                </div>
                <div class="col-xs-4">
                    <select class="form-control" style="width: 100%" name="status_search">
                      <option disabled selected="true">--Select Status--</option>
                      <option value="running">Running</option>
                      <option value="expired">Expired</option>
                    </select>            
                </div>
              </div>
              <div class="col-md-1">
                <div class="col-xs-12">
                  <button type="submit" class="btn btn-primary btn-block">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
            </form>
            <br><br>
          </div>
         <br>
         <div class="table-responsive">
           <table id="table" class="table datatable table-bordered table-striped">
               <thead>
                 <tr>
                   <th class="text-center">#</th>
                   <th class="text-center">Name</th>
                   <th class="text-center">Contact No.</th>
                   <th class="text-center">Invoice #</th>
                   <th class="text-center">Amount</th>
                   <th class="text-center">Payment Date</th>
                 </tr>

               </thead>

               <tbody>

                <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
                @foreach($invoices as $invoice)
                <tr class="text-center">
                 <td>{{$count++ }}</td>
                 <td>{{$invoice->client->fullname}}</td>
                 <td>{{$invoice->client->contact_no}}</td>
                 <td>
                   {{is_null($invoice->notax_invoice)?is_null($invoice->tax_invoice)?'-':$invoice->tax_invoice:$invoice->notax_invoice}}
                 </td>
                 <td>{{$invoice->total}} /-</td>
                 <td>{{date('M d, Y',strtotime($invoice->updated_at))}}</td>
                </tr>
                @endforeach

               </tbody>
             </table>
         </div>
        </div>

  </div>



@endsection

@section('script-content')
<script src="{{ URL::asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
<script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>
@endsection
