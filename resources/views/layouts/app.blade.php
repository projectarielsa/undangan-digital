<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Ellori - Platform Undangan Digital Pernikahan Online #1 Indonesia')</title>
    
    {{-- SEO Meta Tags --}}
    @include('components.seo', [
        'seoTitle' => View::hasSection('seo_title') ? View::getSection('seo_title') : null,
        'seoDescription' => View::hasSection('seo_description') ? View::getSection('seo_description') : null,
        'seoKeywords' => View::hasSection('seo_keywords') ? View::getSection('seo_keywords') : null,
        'seoImage' => View::hasSection('seo_image') ? View::getSection('seo_image') : null,
        'seoType' => View::hasSection('seo_type') ? View::getSection('seo_type') : null,
        'seoCanonical' => View::hasSection('seo_canonical') ? View::getSection('seo_canonical') : null,
    ])
    
    {{-- Structured Data / Schema Markup --}}
    @include('components.schema-markup', [
        'breadcrumbs' => $breadcrumbs ?? null,
        'faqs' => $faqs ?? null,
    ])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
    @yield('body')
    @stack('scripts')
</body>
</html>
