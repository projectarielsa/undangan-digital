{{-- JSON-LD Structured Data Component --}}
@php
    $siteName = 'Ellori';
    $siteUrl = config('app.url', 'https://ellori.id');
    $logoUrl = asset('image/logo.png');
    $description = 'Platform undangan digital pernikahan online premium #1 di Indonesia. Buat undangan nikah digital dengan fitur lengkap: RSVP, galeri foto, musik, countdown, dan amplop digital.';

    $jsonOptions = JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;

    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteName,
        'alternateName' => 'Ellori Indonesia',
        'url' => $siteUrl,
        'logo' => $logoUrl,
        'description' => $description,
        'foundingDate' => '2024',
        'founders' => [
            [
                '@type' => 'Person',
                'name' => 'Ellori Team',
            ],
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => 'ID',
            'addressRegion' => 'Indonesia',
        ],
        'contactPoint' => [
            [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'availableLanguage' => ['Indonesian', 'English'],
                'areaServed' => 'ID',
            ],
        ],
        'sameAs' => [
            'https://www.facebook.com/ellori.id',
            'https://www.instagram.com/ellori.id',
            'https://twitter.com/ellori_id',
            'https://www.tiktok.com/@ellori.id',
            'https://www.youtube.com/@ellori_id',
        ],
    ];

    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $siteName,
        'alternateName' => 'Ellori - Undangan Digital',
        'url' => $siteUrl,
        'description' => $description,
        'inLanguage' => 'id-ID',
        'publisher' => [
            '@type' => 'Organization',
            'name' => $siteName,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
            ],
        ],
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => $siteUrl . '/demo?search={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];

    $softwareSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => $siteName,
        'applicationCategory' => 'WebApplication',
        'operatingSystem' => 'Web Browser',
        'description' => 'Platform undangan pernikahan digital online dengan fitur lengkap untuk membuat undangan nikah modern dan elegan.',
        'url' => $siteUrl,
        'author' => [
            '@type' => 'Organization',
            'name' => $siteName,
        ],
        'offers' => [
            '@type' => 'AggregateOffer',
            'lowPrice' => '0',
            'highPrice' => '299000',
            'priceCurrency' => 'IDR',
            'offerCount' => '3',
        ],
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '4.9',
            'ratingCount' => '1250',
            'bestRating' => '5',
            'worstRating' => '1',
        ],
        'featureList' => [
            'Template undangan elegan & modern',
            'RSVP online real-time',
            'Galeri foto & video',
            'Background musik',
            'Countdown timer',
            'Amplop digital',
            'QR Code check-in',
            'Custom domain',
            'Analytics dashboard',
            'Unlimited tamu',
        ],
    ];

    $localBusinessSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => $siteName,
        'image' => $logoUrl,
        'description' => $description,
        'url' => $siteUrl,
        'priceRange' => 'Rp 0 - Rp 299.000',
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => 'ID',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => '-6.2088',
            'longitude' => '106.8456',
        ],
        'openingHoursSpecification' => [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'opens' => '00:00',
            'closes' => '23:59',
        ],
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'Indonesia',
        ],
    ];

    $breadcrumbSchema = null;
    if (isset($breadcrumbs)) {
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($breadcrumbs)->map(function ($breadcrumb, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $breadcrumb['name'] ?? '',
                    'item' => $breadcrumb['url'] ?? '',
                ];
            })->values()->toArray(),
        ];
    }

    $faqSchema = null;
    if (isset($faqs)) {
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['question'] ?? '',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'] ?? '',
                    ],
                ];
            })->values()->toArray(),
        ];
    }
@endphp

<script type="application/ld+json">
{!! json_encode($organizationSchema, $jsonOptions) !!}
</script>

<script type="application/ld+json">
{!! json_encode($websiteSchema, $jsonOptions) !!}
</script>

<script type="application/ld+json">
{!! json_encode($softwareSchema, $jsonOptions) !!}
</script>

@if($breadcrumbSchema)
<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, $jsonOptions) !!}
</script>
@endif

<script type="application/ld+json">
{!! json_encode($localBusinessSchema, $jsonOptions) !!}
</script>

@if($faqSchema)
<script type="application/ld+json">
{!! json_encode($faqSchema, $jsonOptions) !!}
</script>
@endif

@stack('schema')