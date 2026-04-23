<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\DailyDose;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect();

        // Static pages
        $staticPages = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => '/services', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/news', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => '/daily-dose', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => '/laboratory', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($staticPages as $page) {
            $urls->push([
                'loc' => url($page['loc']),
                'lastmod' => now()->toW3cString(),
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
            ]);
        }

        // Blog posts
        $blogs = Blog::published()->latest()->get();
        foreach ($blogs as $blog) {
            $urls->push([
                'loc' => url("/news/{$blog->slug}"),
                'lastmod' => ($blog->updated_at ?? $blog->created_at)->toW3cString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ]);
        }

        // Daily Dose posts
        $doses = DailyDose::published()->latest()->get();
        foreach ($doses as $dose) {
            $urls->push([
                'loc' => url("/daily-dose/{$dose->slug}"),
                'lastmod' => ($dose->updated_at ?? $dose->created_at)->toW3cString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ]);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
