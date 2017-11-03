@extends('layouts.master')
@section('title')
Dashboard
@endsection

@section('body-content')

<div class="page-title">
  <div class="title">Welcome</div>
  <div class="sub-title">STOCK MANAGEMENT</div>
</div>


<div class="row">

    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-teal text-white">
        <div class="card-circle-bg-icon"> <i class="icon-user"></i> </div>
        <div class="h4 m-a-0">{{$detail['clientCount']}}</div>
        <div>Number of Clients</div>
      </div>
    </div>

    @if($detail['gstAvailable'])
    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-blue text-white">
        <div class="card-circle-bg-icon"> <i class="icon-credit-card"></i> </div>
        <div class="h4 m-a-0"><i class="fa fa-inr"></i> {{$detail['totalTax']}}</div>
        <div>Tax Collected</div>
      </div>
    </div>
   @endif

    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-purple text-white">
        <div class="card-circle-bg-icon"> <i class="icon-wallet"></i> </div>
        <div class="h4 m-a-0"><i class="fa fa-inr"></i> {{$detail['pendingDue']}}</div>
        <div>Due Payments ({{$detail['dueCount']}})</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-cyan text-white">
        <div class="card-circle-bg-icon"> <i class="icon-wallet"></i> </div>
        <div class="h4 m-a-0"><i class="fa fa-inr"></i> {{$detail['total']}}</div>
        <div>Total Payments</div>
      </div>
    </div>

</div>

<div class="row">
    <h2 class="background double"><span>THIS MONTH STATUS</span></h2><br>
    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-teal text-white">
        <div class="card-circle-bg-icon"> <i class="icon-user"></i> </div>
        <div class="h4 m-a-0">{{$detail['m_clientCount']}}</div>
        <div>Client(s) Created</div>
      </div>
    </div>

    @if($detail['gstAvailable'])
    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-blue text-white">
        <div class="card-circle-bg-icon"> <i class="icon-credit-card"></i> </div>
        <div class="h4 m-a-0"><i class="fa fa-inr"></i> {{$detail['m_totalTax']}}</div>
        <div>Tax Collected</div>
      </div>
    </div>
   @endif

    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-purple text-white">
        <div class="card-circle-bg-icon"> <i class="icon-wallet"></i> </div>
        <div class="h4 m-a-0"><i class="fa fa-inr"></i> {{$detail['m_pendingDue']}}</div>
        <div>Due Payments ({{$detail['m_dueCount']}})</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-block b-a-0 bg-cyan text-white">
        <div class="card-circle-bg-icon"> <i class="icon-wallet"></i> </div>
        <div class="h4 m-a-0"><i class="fa fa-inr"></i> {{$detail['m_total']}}</div>
        <div>Total Payments</div>
      </div>
    </div>
</div>

@endsection

@section('script-content')

<script src="{{ URL::asset('vendor/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendor/jquery.ui/ui/core.js') }}"></script>
<script src="{{ URL::asset('vendor/jquery.ui/ui/widget.js') }}"></script>
<script src="{{ URL::asset('vendor/jquery.ui/ui/mouse.js') }}"></script>
<script src="{{ URL::asset('vendor/jquery.ui/ui/draggable.js') }}"></script>
<script src="{{ URL::asset('vendor/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ URL::asset('vendor/fullcalendar/dist/gcal.js') }}"></script>
<script src="{{ URL::asset('scripts/apps/calendar.js') }}"></script>

<script type="text/javascript">


@endsection
