<!DOCTYPE html>
<html dir="{{ isRtl() ? 'rtl' : 'ltr' }}" data-layout="vertical" data-sidebar-size="{{ $uiOptions['sidebar_size'] }}"
    data-sidebar="dark" data-layout-mode="{{ $uiOptions['layout_mode'] }}" lang="{{ str_replace('_', '-', locale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Platform') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ $uiOptions['fav_icon'] }}">
    @routes
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @inertiaHead
    <script>
        window.Fezlee = {
            locale: "{{ locale() }}",
            fallbackLocale: "{{ fallback_locale() }}",
            isRtl: "{{ isRtl() }}"
        }
    </script>
</head>

<body>
    @inertia
</body>

</html>
