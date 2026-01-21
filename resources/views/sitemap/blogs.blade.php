<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data as $item)
        @if(isset($item->parentSeo))
        <url>
            <loc>{{ url($locale . '/blog/' . Str::lower($item->parentSeo->slug) . '/' .$item->slug) }}</loc>
            <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
        @else
        <url>
            <loc>{{ url($locale . '/blog/' . $item->slug) }}</loc>
            <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
        @endif
    @endforeach
</urlset>
