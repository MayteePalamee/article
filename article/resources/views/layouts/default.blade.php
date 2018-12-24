<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    @include('includes.head')
</head>
<body>
<div class="container">

    <header class="row">
        @include('includes.navigetion')
    </header>

    <div id="main" class="index">

            @yield('content')

    </div>

    <footer class="row">
        @include('includes.footer')
    </footer>
</div>
 <div class="modal"><!-- Place at bottom of page --></div>  
</body>
</html>