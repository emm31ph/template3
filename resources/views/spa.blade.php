@php
$config = [
    'appName' => config('app.name'),
    'locale' => ($locale = app()->getLocale()),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta name="csrf-token" content="{!! csrf_token() !!}"> --}}
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script> --}}

</head>

<body>
    <div id="app"></div>

    {{-- Global configuration object --}}
    <script>
        window.config = @json($config);

    </script>

    {{-- Load the application scripts --}}
    <script src="{{ mix('dist/js/app.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>
