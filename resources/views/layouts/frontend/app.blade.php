<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>


  <!-- Font -->

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">


  <!-- Stylesheets -->

  <link href="{{ asset('assets/frontend/css') }}/bootstrap.css" rel="stylesheet">

  <link href="{{ asset('assets/frontend/css') }}/swiper.css" rel="stylesheet">

  <link href="{{ asset('assets/frontend/css') }}/ionicons.css" rel="stylesheet">
  {{-- toastr link --}}
  <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

  {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> --}}



  @stack('css')

  
</head>
<body>
  @include('layouts.frontend.header')

  @yield('frontendContant')

  @include('layouts.frontend.footer')


  <!-- SCIPTS -->

  <script src="{{ asset('assets/frontend/js') }}/jquery-3.1.1.min.js"></script>

  <script src="{{ asset('assets/frontend/js') }}/tether.min.js"></script>

  <script src="{{ asset('assets/frontend/js') }}/bootstrap.js"></script>

  <script src="{{ asset('assets/frontend/js') }}/swiper.js"></script>

  <script src="{{ asset('assets/frontend/js') }}/scripts.js"></script>
  {{-- toastr js link --}}
  <script src="{{ asset('js/toastr.min.js') }}"></script>
  {{-- <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script> --}}
  {!! Toastr::message() !!}
  <script>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr["error"]("{{ $error }}")
    toastr.options = {
     "closeButton": true,
     "newestOnTop": true,
     "progressBar": true,
     "positionClass": "toast-top-center"
   }
   @endforeach
   @endif

 </script>
 @stack('js')
</body>
</html>
