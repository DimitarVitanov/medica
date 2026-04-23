<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Preconnect FIRST - before any external requests -->
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title inertia>{{ config('app.name', 'ПЗУ Медика') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/webp" href="/images/logo.webp">
        
        <!-- Critical CSS inline for faster FCP -->
        <style>
            .container{width:100%;padding-right:var(--bs-gutter-x,.75rem);padding-left:var(--bs-gutter-x,.75rem);margin-right:auto;margin-left:auto}
            @media(min-width:576px){.container{max-width:540px}}
            @media(min-width:768px){.container{max-width:720px}}
            @media(min-width:992px){.container{max-width:960px}}
            @media(min-width:1200px){.container{max-width:1140px}}
            @media(min-width:1400px){.container{max-width:1320px}}
            .row{display:flex;flex-wrap:wrap;margin-right:calc(-.5*var(--bs-gutter-x));margin-left:calc(-.5*var(--bs-gutter-x))}
            .col-12,.col-lg-6{flex:0 0 auto;width:100%}
            @media(min-width:992px){.col-lg-6{width:50%}}
            .d-flex{display:flex!important}.align-items-center{align-items:center!important}.justify-content-center{justify-content:center!important}
            .position-relative{position:relative!important}.position-fixed{position:fixed!important}.w-100{width:100%!important}
            .text-white{color:#fff!important}.text-center{text-align:center!important}
            .py-3{padding-top:.75rem!important;padding-bottom:.75rem!important}
            .navbar{--bs-navbar-padding-y:.5rem;position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}
        </style>

        <!-- Bootstrap CSS - load async -->
        <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></noscript>
        
        <!-- Fonts - load async -->
        <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"></noscript>

        <!-- Preload hero image for LCP optimization -->
        @if(isset($page['props']['sliders']) && count($page['props']['sliders']) > 0)
            @php
                // Find first slider with an image
                $heroSlider = collect($page['props']['sliders'])->first(fn($s) => !empty($s['image']));
                if ($heroSlider) {
                    $heroImage = $heroSlider['image'];
                    $heroImageUrl = str_starts_with($heroImage, 'http') ? $heroImage : '/storage/' . $heroImage;
                    // Generate srcset for responsive preload
                    $pathInfo = pathinfo($heroImage);
                    $dir = $pathInfo['dirname'];
                    $name = $pathInfo['filename'];
                    $srcset = "/storage/{$dir}/{$name}-xs.webp 320w, /storage/{$dir}/{$name}-sm.webp 480w, /storage/{$dir}/{$name}-md.webp 768w, /storage/{$dir}/{$name}-lg.webp 1200w";
                }
            @endphp
            @if(isset($heroSlider))
            <link rel="preload" as="image" href="{{ $heroImageUrl }}" imagesrcset="{{ $srcset }}" imagesizes="(max-width: 480px) 320px, (max-width: 768px) 480px, (max-width: 1200px) 768px, 1200px" fetchpriority="high">
            @endif
        @endif

        <!-- Schema.org JSON-LD -->
        @php
            $fbUrl = \App\Models\Setting::get('facebook_url', '');
            $igUrl = \App\Models\Setting::get('instagram_url', '');
            $sameAs = array_filter([$fbUrl, $igUrl]);
        @endphp
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'MedicalBusiness',
            '@id' => 'https://medica.mk/#organization',
            'name' => 'ПЗУ Медика',
            'alternateName' => ['PZU Medica', 'Поликлиника Медика', 'Поликлиника Медика Струмица'],
            'url' => 'https://medica.mk',
            'logo' => 'https://medica.mk/images/logo.webp',
            'image' => 'https://medica.mk/images/logo.webp',
            'description' => 'Приватна здравствена установа во Струмица - Општа медицина, Гинекологија, Психијатрија, Естетска медицина, Лабораторија, Медицина на труд.',
            'telephone' => '+389-34-360-444',
            'email' => 'info@medica.mk',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'ул. Вањо Китанов бр. 19',
                'addressLocality' => 'Струмица',
                'addressCountry' => 'MK',
                'postalCode' => '2400',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 41.4375,
                'longitude' => 22.6427,
            ],
            'priceRange' => '$$',
            'currenciesAccepted' => 'MKD',
            'paymentAccepted' => 'Cash, Credit Card',
            'areaServed' => [
                '@type' => 'City',
                'name' => 'Струмица',
            ],
            'sameAs' => array_values($sameAs),
            'medicalSpecialty' => [
                'GeneralPractice',
                'Gynecologic',
                'Psychiatric',
                'Dermatology',
                'LaboratoryScience',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'url' => 'https://medica.mk',
            'name' => 'ПЗУ Медика',
            'alternateName' => ['PZU Medica Strumica', 'Поликлиника Медика'],
            'inLanguage' => ['mk', 'en'],
            'publisher' => [
                '@id' => 'https://medica.mk/#organization',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>

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
