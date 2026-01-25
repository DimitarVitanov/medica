<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'ПЗУ Медика') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/webp" href="/images/logo.webp">

        <!-- Preconnect to external domains -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
        
        <!-- Preload critical fonts -->
        <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"></noscript>

        <!-- Bootstrap CSS - load async -->
        <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></noscript>

        <!-- Preload hero image for LCP optimization -->
        @if(isset($page['props']['sliders']) && count($page['props']['sliders']) > 0 && $page['props']['sliders'][0]['image'])
            @php
                $heroImage = $page['props']['sliders'][0]['image'];
                $heroImageUrl = str_starts_with($heroImage, 'http') ? $heroImage : '/storage/' . $heroImage;
            @endphp
            <link rel="preload" as="image" href="{{ $heroImageUrl }}" fetchpriority="high">
        @endif

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
            html, body {
                font-family: 'Figtree', sans-serif;
                overflow-x: hidden;
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

        <!-- Bootstrap JS - only Collapse component needed for navbar -->
        <script defer>
            document.addEventListener('DOMContentLoaded',function(){
                document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(btn){
                    btn.addEventListener('click',function(){
                        var target=document.querySelector(this.getAttribute('data-bs-target'));
                        if(target){target.classList.toggle('show');}
                    });
                });
            });
        </script>
    </body>
</html>
