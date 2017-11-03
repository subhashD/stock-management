<!-- build:js({.tmp,app}) scripts/app.min.js -->
  <script src="{{ URL::asset('scripts/helpers/modernizr.js') }}"></script>
  <script src="{{ URL::asset('vendor/jquery/dist/jquery.js') }}"></script>
  <script src="{{ URL::asset('vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
  <script src="{{ URL::asset('vendor/fastclick/lib/fastclick.js') }}"></script>
  <script src="{{ URL::asset('vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
  <script src="{{ URL::asset('scripts/helpers/smartresize.js') }}"></script>
  <script src="{{ URL::asset('scripts/constants.js') }}"></script>
  <script src="{{ URL::asset('scripts/main.js') }}"></script>
  <!-- endbuild -->
  <!-- page scripts -->
  <script src="{{ URL::asset('vendor/flot/jquery.flot.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot/jquery.flot.categories.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot/jquery.flot.stack.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot/jquery.flot.time.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot/jquery.flot.pie.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot-spline/js/jquery.flot.spline.js') }}"></script>
  <script src="{{ URL::asset('vendor/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
  <!-- end page scripts -->
  <!-- initialize page scripts -->
  <script src="{{ URL::asset('scripts/helpers/sameheight.js') }}"></script>
  <script src="{{ URL::asset('scripts/ui/dashboard.js') }}"></script>
  <script src="{{ URL::asset('scripts/forms/plugins.js')}}"></script>
  <script src="{{ URL::asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ URL::asset('js/customselect.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
    setTimeout(function() {
      $('[role=alert]').fadeOut('slow');
    }, 5000);
  });
  </script>
  <!-- end initialize page scripts -->
  @yield('script-content')
</body>
</html>
