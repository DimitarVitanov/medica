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
        <!-- Skeleton loader shown immediately while Vue loads -->
        <div id="skeleton-loader" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999;background:linear-gradient(180deg,#FDFBFE 0%,#FFF 100%);">
            <nav style="padding:1rem 0;background:transparent;">
                <div style="max-width:1200px;margin:0 auto;padding:0 1rem;display:flex;justify-content:space-between;align-items:center;">
                    <div style="width:120px;height:50px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:8px;"></div>
                    <div style="display:flex;gap:1.5rem;">
                        <div style="width:60px;height:20px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:4px;"></div>
                        <div style="width:60px;height:20px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:4px;"></div>
                        <div style="width:60px;height:20px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:4px;"></div>
                    </div>
                </div>
            </nav>
            <div style="max-width:1200px;margin:0 auto;padding:4rem 1rem;display:flex;align-items:center;min-height:80vh;">
                <div style="flex:1;padding-right:2rem;">
                    <div style="width:200px;height:40px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:8px;margin-bottom:1rem;"></div>
                    <div style="width:100%;max-width:300px;height:24px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:4px;margin-bottom:0.75rem;"></div>
                    <div style="width:80%;max-width:250px;height:16px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:4px;margin-bottom:1.5rem;"></div>
                    <div style="display:flex;gap:1rem;">
                        <div style="width:140px;height:44px;background:linear-gradient(135deg,#6B4C9A 0%,#8B6BAE 100%);border-radius:22px;"></div>
                        <div style="width:120px;height:44px;background:#f5f5f5;border-radius:22px;border:1px solid #ddd;"></div>
                    </div>
                </div>
                <div style="flex:1;display:flex;justify-content:center;">
                    <div style="width:100%;max-width:500px;height:340px;background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:20px;"></div>
                </div>
            </div>
            <style>@keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}</style>
        </div>
        <script>
            // Hide skeleton when Vue app is ready
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const skeleton = document.getElementById('skeleton-loader');
                    if (skeleton) {
                        skeleton.style.opacity = '0';
                        skeleton.style.transition = 'opacity 0.3s ease';
                        setTimeout(function() { skeleton.style.display = 'none'; }, 300);
                    }
                }, 100);
            });
        </script>

        @inertia

        <!-- Bootstrap JS - defer loading -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    </body>
</html>
