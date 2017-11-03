<!Doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
  <!-- page stylesheets -->
  <!-- end page stylesheets -->
  <!-- build:css({.tmp,app}) styles/app.min.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
  <!--custom select-->
  <link rel="stylesheet" href="{{ URL::asset('styles/webfont.css') }} ">
  <link rel="stylesheet" href="{{ URL::asset('styles/climacons-font.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap/dist/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/card.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/sli.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/animate.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/app.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/app.skins.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('styles/parsley.css') }}">

  <link rel="stylesheet" href="{{ URL::asset('vendor/chosen_v1.4.0/chosen.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/jquery.tagsinput/src/jquery.tagsinput.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/checkbo/src/0.1.4/css/checkBo.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/intl-tel-input/build/css/intlTelInput.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap-daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/clockpicker/dist/bootstrap-clockpicker.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/jquery-labelauty/source/jquery-labelauty.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/multiselect/css/multi-select.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/ui-select/dist/select.css')}}">
{{--   <link rel="stylesheet" href="{{ URL::asset('vendor/datatables/media/css/dataTables.bootstrap.css')}} "> --}}
  <link rel="stylesheet" href="{{ URL::asset('vendor/datatables/media/css/jquery.dataTables.css')}} ">
  <link rel="stylesheet" href="{{ URL::asset('vendor/fullcalendar/dist/fullcalendar.min.css')}} ">
  <link rel="stylesheet" href="{{ URL::asset('vendor/sweetalert/dist/sweetalert.css')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
  <style media="screen">
    .form-control{
      background-color: #d3d3d3 !important;
    }
  </style>
  <!-- end page stylesheets -->
  @yield('style-content')
  <!-- endbuild -->
</head>

<body class="page-loading">
  <!-- page loading spinner -->
  <div class="pageload">
    <div class="pageload-inner">
      <div class="sk-rotating-plane"></div>
    </div>
  </div>
  <!-- /page loading spinner -->
  <div class="app layout-fixed-header">

 <!-- sidebar panel -->
    <div class="sidebar-panel offscreen-left">
      <div class="brand">
        <!-- toggle small sidebar menu -->

        <!-- /toggle small sidebar menu -->
        <!-- toggle offscreen menu -->
        <div class="toggle-offscreen">
          <a href="javascript:;" class="visible-xs hamburger-icon" data-toggle="offscreen" data-move="ltr">
            <span></span>
            <span></span>
            <span></span>
          </a>
        </div>
        <!-- /toggle offscreen menu -->
        <!-- logo -->
        <a class="brand-logo">
          <span>STOCK MANAGEMENT</span>
        </a>
        <a href="#" class="small-menu-visible brand-logo">S.M</a>
        <!-- /logo -->
      </div>

      <!-- main navigation -->
      <nav role="navigation" class="animated bounce">

        <ul class="nav">
          <!-- dashboard -->
          <li>
            <a href="/home">
              <i class="icon-home"></i>
              <span>Home</span>
            </a>
          </li>

          <li>
            <a href="/new_client">
              <i class="icon-user"></i>
              <span>Add Client</span>
            </a>
          </li>

          <li>
            <a href="/all_client">
              <i class="icon-users"></i>
              <span>All Clients</span>
            </a>
          </li>

          <li>
            <a href="/vendors">
              <i class="icon-user"></i>
              <span>Vendor</span>
            </a>
          </li>

          <li>
            <a href="/godown">
              <i class="icon-user"></i>
              <span>Godown</span>
            </a>
          </li>

          <li>
            <a href="javascript:;">
              <i class="icon-user"></i>
              <span>Invoice</span>
            </a>
            <ul class="sub-menu">
              <li>
                <a href="/gst_payments">
                  <span>GST Invoice</span>
                </a>
              </li>
              <li>
                 <a href="/non_gst_payments">
                   <span>Non-GST Invoice</span>
                 </a>
              </li>
            </ul>
          </li>


          <li>
            <a href="/inventory">
              <i class="icon-user"></i>
              <span>Inventory</span>
            </a>
          </li>

          <li>
            <a href="/all_estimation">
              <i class="icon-user"></i>
              <span>Estimation</span>
            </a>
          </li>

          <li>
            <a href="javascript:;">
              <i class="icon-screen-desktop"></i>
              <span>Reports</span>
            </a>
            <ul class="sub-menu">
              <li>
                <a href="/pending_inv">
                  <span>Pending Invoice</span>
                </a>
              </li>
              <li>
                 <a href="/paid_inv">
                   <span>Paid Invoice</span>
                 </a>
              </li>
              <li>
                 <a href="/report_est">
                   <span>Estimates</span>
                 </a>
              </li>
              <li>
               <a href="/inventory_log">
                 <span>Inventory log</span>
               </a>
              </li>
            </ul>
          </li>



          <li>
            <a href="/setting">
              <i class="icon-home"></i>
              <span>Company Profile</span>
            </a>
          </li>

          <li class="visible-xs visible-sm">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form-xs').submit();">
              <i class="icon-logout"></i>
              <span>Logout</span>

            </a>
            <form id="logout-form-xs" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </li>

        </ul>
      </nav>
      <!-- /main navigation -->
    </div>
