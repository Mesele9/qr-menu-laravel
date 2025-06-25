<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings['company_name'] ?? config('app.name', 'Digital Menu') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- CSS Framework (e.g., Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @honeypot

    <style>
        :root {
            --brand-primary: {{ $settings['primary_brand_color'] ?? '#0d6efd' }};
            --brand-secondary: {{ $settings['secondary_brand_color'] ?? '#6c757d' }};
            --main-bg: {{ $settings['main_bg_color'] ?? '#f8f9fa' }};
            --header-bg: {{ $settings['header_bg_color'] ?? '#ffffff' }};
            --header-text: {{ $settings['header_text_color'] ?? '#212529' }};
            --footer-bg: {{ $settings['footer_bg_color'] ?? '#343a40' }};
            --footer-text: {{ $settings['footer_text_color'] ?? '#ffffff' }};
        }
    </style>
    
    @stack('styles')

</head>
<body style="background-color: var(--main-bg);">

    <!-- Main Content Area -->
    <div id="app">
        @yield('content')
    </div>
    <!-- End Main Content Area -->

    <!-- Scripts (e.g., Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>