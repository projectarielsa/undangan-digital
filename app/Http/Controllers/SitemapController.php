<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationTemplate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate main sitemap index
     */
    public function index(): Response
    {
        $content = Cache::remember('sitemap-index', 3600, function () {
            $sitemaps = [
                ['loc' => url('/sitemap-pages.xml'), 'lastmod' => now()->toW3cString()],
                ['loc' => url('/sitemap-templates.xml'), 'lastmod' => now()->toW3cString()],
                ['loc' => url('/sitemap-invitations.xml'), 'lastmod' => now()->toW3cString()],
            ];

            return view('seo.sitemap-index', compact('sitemaps'))->render();
        });

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap for static pages
     */
    public function pages(): Response
    {
        $content = Cache::remember('sitemap-pages', 3600, function () {
            $pages = [
                [
                    'loc' => url('/'),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => 'daily',
                    'priority' => '1.0',
                ],
                [
                    'loc' => url('/login'),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ],
                [
                    'loc' => url('/register'),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ],
                [
                    'loc' => url('/demo'),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.9',
                ],
                [
                    'loc' => url('/privacy-policy'),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => 'yearly',
                    'priority' => '0.3',
                ],
                [
                    'loc' => url('/terms-of-service'),
                    'lastmod' => now()->toW3cString(),
                    'changefreq' => 'yearly',
                    'priority' => '0.3',
                ],
            ];

            return view('seo.sitemap', compact('pages'))->render();
        });

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap for templates/demo pages
     */
    public function templates(): Response
    {
        $content = Cache::remember('sitemap-templates', 3600, function () {
            $templates = InvitationTemplate::where('is_active', true)
                ->orderBy('updated_at', 'desc')
                ->get();

            $pages = $templates->map(function ($template) {
                return [
                    'loc' => url('/demo/' . $template->slug),
                    'lastmod' => $template->updated_at->toW3cString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            })->toArray();

            return view('seo.sitemap', compact('pages'))->render();
        });

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap for public invitations
     */
    public function invitations(): Response
    {
        $content = Cache::remember('sitemap-invitations', 1800, function () {
            $invitations = Invitation::where('status', 'published')
                ->orderBy('updated_at', 'desc')
                ->take(1000) // Limit to prevent huge sitemaps
                ->get();

            $pages = $invitations->map(function ($invitation) {
                return [
                    'loc' => url('/' . $invitation->slug),
                    'lastmod' => $invitation->updated_at->toW3cString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            })->toArray();

            return view('seo.sitemap', compact('pages'))->render();
        });

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
