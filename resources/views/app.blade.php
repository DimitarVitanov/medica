<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'ПЗУ Медика') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/images/logo.png">

        <!-- Preconnect to external domains -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
        
        <!-- Preload critical fonts -->
        <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"></noscript>

        <!-- Bootstrap CSS - load async -->
        <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></noscript>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <style>
            :root {
                --primary-color: #6B4C9A;
                --primary-light: #8B6BAE;
                --primary-dark: #5B3C8A;
            }
            body {
                font-family: 'Figtree', sans-serif;
            }
            .btn-purple {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
                color: white;
                border: none;
            }
            .btn-purple:hover {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
                color: white;
            }
            .bg-purple {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%) !important;
            }
            .text-purple {
                color: var(--primary-color);
            }
            .form-control:focus, .form-select:focus {
                border-color: var(--primary-light);
                box-shadow: 0 0 0 0.25rem rgba(107, 76, 154, 0.25);
            }
            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
        </style>
    </head>
    <body>
        @inertia

        <!-- Bootstrap JS - defer loading -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    </body>
</html>
