<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    @include('includes.viewHead')
</head>
<body>
    @include('includes.viewNav') 
<div class="index">
    @yield('content')
</div>
<div>
    @include('includes.viewFooter')
</div>
 <div class="modal"><!-- Place at bottom of page --></div>  
</body>
</html>