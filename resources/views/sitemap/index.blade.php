<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if ($blogtr)
    <sitemap>
        <loc>{{ url('sitemap/blog-tr') }}</loc>
        <lastmod>{{ $blogtr->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
    
    @if ($blogen)
    <sitemap>
        <loc>{{ url('sitemap/blog-en') }}</loc>
        <lastmod>{{ $blogen->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
    
     @if ($servicestr)
    <sitemap>
        <loc>{{ url('sitemap/hizmetler') }}</loc>
        <lastmod>{{ $servicestr->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
    
    @if ($servicesen)
    <sitemap>
        <loc>{{ url('sitemap/services') }}</loc>
        <lastmod>{{ $servicesen->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
    
 
</sitemapindex>
