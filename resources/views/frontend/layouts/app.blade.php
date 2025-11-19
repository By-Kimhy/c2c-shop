<!doctype html><html><head>
<meta charset="utf-8"><title>@yield('title','C2C Shop')</title>
@include('frontend.partials.styles')
</head><body>
@include('frontend.partials.header')
<div class="container py-4">@yield('content')</div>
@include('frontend.partials.scripts')
</body></html>
