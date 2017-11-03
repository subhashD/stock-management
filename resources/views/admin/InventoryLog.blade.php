@extends('layouts.master')
@section('title')
Inventory Log
@endsection

@section('body-content')

  <div class="card bg-white animated slideInLeft">
    <div class="card-header bg-info text-white">
      Inventory Log
    </div>
    <div class="card-block">
      <div class="row m-a-0">
        <div class="table-responsive">
          <table class="table datatable table-striped data-table" id="productTable">
            <thead>
              <tr>
                <td>#</td>
                <td>Product name</td>
                <td>Qty</td>
                <td>Vendor/Client</td>
                <td>Godown</td>
                <td>Date</td>
              </tr>
            </thead>
            <tbody>
              <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
              @foreach ($logs as $log)
                <tr>
                  <td>{{$count++}}</td>
                  <td>{{$log->product->name}}</td>
                  <td>
                    @if($log->type=='added')
                      <span class="text-success">+ {{$log->qty}}</span>
                      <small class="text-success">added</small>
                    @else
                      <span class="text-danger">- {{$log->qty}}</span>
                      <small class="text-danger">deducted</small>
                    @endif
                  </td>
                  <td>{{!is_null($log->vendor_id)?$log->vendor->name:$log->client->fullname}}</td>
                  <td>{{$log->godown->name}}</td>
                  <td>{{date('M d, Y',strtotime($log->created_at))}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{$logs->render()}}
      </div>
    </div>
  </div>

@endsection


@section('script-content')

<script src="{{ URL::asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('scripts/helpers/bootstrap-datatables.js') }}"></script>
<script src="{{ URL::asset('scripts/tables/table-edit.js') }}"></script>

</body>


@endsection
