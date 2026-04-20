<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/node-waves/node-waves.min.js')}}"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('build/js/app.min.js')}}"></script>

@yield('script-bottom')
