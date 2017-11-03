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
  <link rel="stylesheet" href="{{ URL::asset('vendor/select2/dist/css/select2.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('vendor/selectize/dist/css/selectize.css')}}">
{{--   <link rel="stylesheet" href="{{ URL::asset('vendor/datatables/media/css/dataTables.bootstrap.css')}} "> --}}
  <link rel="stylesheet" href="{{ URL::asset('vendor/datatables/media/css/jquery.dataTables.css')}} ">
  <link rel="stylesheet" href="{{ URL::asset('vendor/fullcalendar/dist/fullcalendar.min.css')}} ">
  <link rel="stylesheet" href="{{ URL::asset('vendor/sweetalert/dist/sweetalert.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('css/customselect.css') }}">
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
  <div class="app layout-fixed-header">
