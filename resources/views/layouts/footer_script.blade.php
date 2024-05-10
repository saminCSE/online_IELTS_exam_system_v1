   <script src="{{ URL::asset('/assets/libs/jquery/jquery.min.js')}}"></script>
   <!-- <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script> -->
   <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
   <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
   <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
   <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>
   <script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>
   <script src="{{asset('assets/js/demo/chart-pie-demo.js')}}"></script>
   <script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>
   <script>
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
   </script>
   @yield('scripts')