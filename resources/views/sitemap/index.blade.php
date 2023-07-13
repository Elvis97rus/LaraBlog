<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($langs as $lang)

        <url>
            <loc>{{ route('home'.($lang == 'ru' ? '' : '.en')) }}</loc>
            <lastmod>{{ \App\Models\TextWidget::getUpdatedAt('home') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ route('page.about-us'.($lang == 'ru' ? '' : '.en')) }}</loc>
            <lastmod>{{ \App\Models\TextWidget::getUpdatedAt('about-us') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @foreach ($categories as $category)
            <url>
                <loc>{{ route('post.by-category'.($lang == 'ru' ? '' : '.en'), $category) }}</loc>
                <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
        @foreach ($posts as $post)
            <url>
                <loc>{{route('post.show'.($lang == 'ru' ? '' : '.en'), $post)}}</loc>
                <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endforeach
</urlset>
