<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @include('includes.style')
    @stack('prepend-style')
    @stack('addon-style')
</head>
<body>

{{-- navbar --}}
@include('includes.navbar')
{{-- content --}}
@yield('content')

{{-- footer --}}
@include('includes.footer')

{{-- script --}}
@stack('prepend-script')
@include('includes.script')
@stack('addon-script')

</body>
</html>