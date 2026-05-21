{{-- SEO Meta Tags Component --}}
@php
    $defaultTitle = 'Ellori - Platform Undangan Digital Pernikahan Online #1 Indonesia';
    $defaultDescription = 'Buat undangan pernikahan digital premium dengan fitur lengkap: RSVP online, galeri foto, musik, countdown, amplop digital, QR check-in. Mulai gratis, template elegan & modern!';
    $defaultKeywords = 'undangan digital, undangan pernikahan online, undangan nikah digital, undangan website, e-invitation, undangan digital premium, undangan pernikahan modern, undangan online Indonesia, wedding invitation, digital wedding invitation';
    $defaultImage = asset('image/og-image.jpg');
    $siteName = 'Ellori';
    $siteUrl = config('app.url', 'https://ellori.id');
    $locale = 'id_ID';
    $twitterHandle = '@ellori_id';
    
    $title = $seoTitle ?? $defaultTitle;
    $description = $seoDescription ?? $defaultDescription;
    $keywords = $seoKeywords ?? $defaultKeywords;
    $image = $seoImage ?? $defaultImage;
    $type = $seoType ?? 'website';
    $canonical = $seoCanonical ?? url()->current();
    $author = $seoAuthor ?? $siteName;
    $publishedTime = $seoPublishedTime ?? null;
    $modifiedTime = $seoModifiedTime ?? now()->toIso8601String();
@endphp

{{-- Primary Meta Tags --}}
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow">
<meta name="bingbot" content="index, follow">
<meta name="language" content="Indonesian">
<meta name="revisit-after" content="7 days">
<meta name="distribution" content="global">
<meta name="rating" content="general">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonical }}">

{{-- Alternate Languages --}}
<link rel="alternate" hreflang="id" href="{{ $canonical }}">
<link rel="alternate" hreflang="x-default" href="{{ $canonical }}">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $title }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ $locale }}">
@if($publishedTime)
<meta property="article:published_time" content="{{ $publishedTime }}">
@endif
<meta property="article:modified_time" content="{{ $modifiedTime }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ $twitterHandle }}">
<meta name="twitter:creator" content="{{ $twitterHandle }}">
<meta name="twitter:url" content="{{ $canonical }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
<meta name="twitter:image:alt" content="{{ $title }}">

{{-- Additional Meta for SEO --}}
<meta name="geo.region" content="ID">
<meta name="geo.country" content="Indonesia">
<meta name="theme-color" content="#3B82F6">
<meta name="msapplication-TileColor" content="#3B82F6">
<meta name="application-name" content="{{ $siteName }}">
<meta name="apple-mobile-web-app-title" content="{{ $siteName }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">

{{-- Favicon --}}
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

{{-- Preconnect for Performance --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://www.googletagmanager.com">
<link rel="dns-prefetch" href="https://www.google-analytics.com">

@stack('seo')
