@extends('layouts.guest')

@push('styles')
<style>
    /* Hexagonal decorative pattern */
    .hex-pattern {
        background-image:
            linear-gradient(30deg, rgba(34, 211, 238, 0.05) 12%, transparent 12.5%, transparent 87%, rgba(34, 211, 238, 0.05) 87.5%, rgba(34, 211, 238, 0.05)),
            linear-gradient(150deg, rgba(34, 211, 238, 0.05) 12%, transparent 12.5%, transparent 87%, rgba(34, 211, 238, 0.05) 87.5%, rgba(34, 211, 238, 0.05)),
            linear-gradient(30deg, rgba(34, 211, 238, 0.05) 12%, transparent 12.5%, transparent 87%, rgba(34, 211, 238, 0.05) 87.5%, rgba(34, 211, 238, 0.05)),
            linear-gradient(150deg, rgba(34, 211, 238, 0.05) 12%, transparent 12.5%, transparent 87%, rgba(34, 211, 238, 0.05) 87.5%, rgba(34, 211, 238, 0.05));
        background-size: 80px 140px;
        background-position: 0 0, 0 0, 40px 70px, 40px 70px;
    }

    /* Article content prose styling - Following STYLE_GUIDE.md for light backgrounds */
    .article-prose {
        @apply text-base md:text-lg text-blue-950 leading-relaxed;
    }

    /* Headings hierarchy - Clean and bold */
    .article-prose h2 {
        @apply text-2xl md:text-3xl lg:text-4xl font-bold text-blue-900 mt-12 mb-6 leading-tight;
    }

    .article-prose h3 {
        @apply text-xl md:text-2xl font-bold text-blue-900 mt-8 mb-4 leading-tight;
    }

    .article-prose h4 {
        @apply text-lg md:text-xl font-bold text-blue-900 mt-6 mb-3 leading-tight;
    }

    /* Paragraphs - Generous spacing for readability */
    .article-prose p {
        @apply mb-6 text-blue-950 leading-relaxed;
    }

    /* Drop cap for first paragraph - Elegant touch */
    .article-prose > p:first-of-type::first-letter {
        @apply float-left text-6xl md:text-7xl font-bold text-cyan-400 leading-none pr-3 pt-1;
        line-height: 0.8;
    }

    /* Links - Cyan accent following style guide */
    .article-prose a {
        @apply text-blue-600 hover:text-cyan-400 underline decoration-blue-400 hover:decoration-cyan-400
               transition-all duration-300 font-medium;
    }

    /* Lists - Clean and spaced */
    .article-prose ul {
        @apply mb-6 ml-6 space-y-3 list-disc marker:text-cyan-400;
    }

    .article-prose ol {
        @apply mb-6 ml-6 space-y-3 list-decimal marker:text-cyan-400 marker:font-bold;
    }

    .article-prose li {
        @apply leading-relaxed text-blue-950 pl-2;
    }

    .article-prose li::marker {
        @apply text-cyan-400;
    }

    /* Blockquotes - Elegant with cyan accent */
    .article-prose blockquote {
        @apply border-l-4 border-cyan-400 pl-6 py-4 my-8 italic text-blue-900 bg-blue-50/50 rounded-r-lg;
        box-shadow: 0 2px 8px rgba(34, 211, 238, 0.08);
    }

    .article-prose blockquote p {
        @apply mb-0 text-blue-900;
    }

    /* Code blocks - Dark theme for contrast */
    .article-prose code {
        @apply bg-blue-900 text-cyan-300 px-2 py-1 rounded text-sm font-mono;
    }

    .article-prose pre {
        @apply bg-blue-900 text-cyan-300 p-6 rounded-lg overflow-x-auto my-8 border border-cyan-400/20;
    }

    .article-prose pre code {
        @apply bg-transparent p-0;
    }

    /* Images - Elegant with subtle shadow */
    .article-prose img {
        @apply rounded-xl my-10 w-full h-auto shadow-lg;
    }

    /* Strong/Bold text */
    .article-prose strong,
    .article-prose b {
        @apply font-bold text-blue-900;
    }

    /* Emphasis/Italic text */
    .article-prose em,
    .article-prose i {
        @apply italic text-blue-800;
    }

    /* Horizontal rules */
    .article-prose hr {
        @apply my-12 border-t-2 border-cyan-400/30;
    }

    /* Tables - If needed */
    .article-prose table {
        @apply w-full my-8 border-collapse;
    }

    .article-prose thead {
        @apply bg-blue-50 border-b-2 border-cyan-400;
    }

    .article-prose th {
        @apply px-4 py-3 text-left text-sm font-bold text-blue-900 uppercase tracking-wider;
    }

    .article-prose td {
        @apply px-4 py-3 text-blue-950 border-b border-blue-100;
    }

    .article-prose tbody tr:hover {
        @apply bg-blue-50/50 transition-colors;
    }

    /* Fade-in animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }

    /* Molecular overlay effect */
    .molecular-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: radial-gradient(circle at 20% 50%, rgba(34, 211, 238, 0.1) 0%, transparent 50%),
                          radial-gradient(circle at 80% 80%, rgba(34, 211, 238, 0.08) 0%, transparent 50%),
                          radial-gradient(circle at 40% 20%, rgba(96, 165, 250, 0.08) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Category badge - Clean and simple */
    .category-badge {
        box-shadow: 0 0 20px rgba(34, 211, 238, 0.1);
    }

    .category-badge:hover {
        box-shadow: 0 0 30px rgba(34, 211, 238, 0.2);
    }
</style>
@endpush

@section('content')
    {{-- ============================================
         HERO SECTION - Scientific Luxury
         ============================================ --}}
    <div class="relative w-full min-h-screen overflow-hidden bg-[#000d1a]">

        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0">
            @if ($article->hasMedia('featured'))
                <img src="{{ $article->getFirstMediaUrl('featured', 'large') }}"
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover object-center opacity-30">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-900/30 to-blue-600/30"></div>
            @endif

            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-b from-[#000d1a]/80 via-[#000d1a]/60 to-[#000d1a]/95"></div>

            {{-- Molecular Overlay --}}
            <div class="molecular-overlay"></div>

            {{-- Hexagonal Pattern --}}
            <div class="hex-pattern absolute inset-0 opacity-20"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 min-h-screen flex flex-col justify-center px-6 md:px-12 lg:px-16 py-20 md:py-24">
            <div class="max-w-5xl mx-auto w-full">

                {{-- Category Badges --}}
                @if ($article->categories->count() > 0)
                    <div class="mb-8 flex flex-wrap gap-3 justify-center opacity-0 fade-in-up">
                        @foreach ($article->categories as $category)
                            <span class="category-badge inline-block px-4 py-2 bg-cyan-400/10 text-cyan-400 text-sm font-semibold rounded-lg
               border border-cyan-400/30 hover:border-cyan-400/60 hover:bg-cyan-400/20
               transition-all duration-300">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Article Title - Futuristic Typography --}}
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight text-center mb-8 md:mb-10 opacity-0 fade-in-up delay-100">
                    {{ $article->title }}
                </h1>

                {{-- Excerpt - Elegant Quote Style --}}
                @if ($article->excerpt)
                    <div class="mb-10 md:mb-12 opacity-0 fade-in-up delay-200">
                        <p class="font-rhinetta text-xl md:text-2xl lg:text-3xl text-cyan-300 italic text-center leading-relaxed max-w-4xl mx-auto">
                            "{{ $article->excerpt }}"
                        </p>
                    </div>
                @endif

                {{-- Article Meta - Scientific Style --}}
                <div class="flex flex-wrap items-center justify-center gap-6 md:gap-8 text-white/80 text-sm md:text-base opacity-0 fade-in-up delay-300">

                    {{-- Author --}}
                    @if ($article->author_name || $article->author)
                        <div class="flex items-center gap-2 group">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan-400 to-blue-400 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="group-hover:text-cyan-400 transition-colors">{{ $article->author_name ?? $article->author->name }}</span>
                        </div>
                    @endif

                    <span class="text-cyan-400/30">•</span>

                    {{-- Published Date --}}
                    @if ($article->published_at)
                        <div class="flex items-center gap-2 group">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="group-hover:text-cyan-400 transition-colors">{{ $article->published_at->format('F d, Y') }}</span>
                        </div>
                    @endif

                    <span class="text-cyan-400/30">•</span>

                    {{-- View Count --}}
                    <div class="flex items-center gap-2 group">
                        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="group-hover:text-cyan-400 transition-colors">{{ number_format($article->view_count) }} views</span>
                    </div>
                </div>

                {{-- Scroll Indicator --}}
                <div class="mt-16 flex justify-center opacity-0 fade-in-up delay-400">
                    <div class="flex flex-col items-center gap-2 text-cyan-400">
                        <span class="text-xs uppercase tracking-wider">Scroll to Read</span>
                        <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                </div>

            </div>
        </div>

        {{-- Decorative Corner Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full text-cyan-400" fill="currentColor">
                <path d="M100,0 L200,0 L200,100 L100,100 L100,0 Z" />
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 w-64 h-64 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full text-cyan-400" fill="currentColor">
                <path d="M0,100 L100,100 L100,200 L0,200 L0,100 Z" />
            </svg>
        </div>
    </div>

    {{-- ============================================
         ARTICLE CONTENT SECTION - Beauty High Tech Style
         ============================================ --}}
    <div class="relative bg-blue-300 py-16 md:py-20 lg:py-24 px-6 md:px-12 lg:px-16 overflow-hidden">

        {{-- Hexagonal Pattern Background --}}
        <div class="hex-pattern absolute inset-0 opacity-10"></div>

        {{-- Subtle Gradient Overlay for Depth --}}
        <div class="absolute inset-0 bg-gradient-to-b from-blue-200/30 via-transparent to-blue-400/20 pointer-events-none"></div>

        {{-- Decorative Top Border with Gradient --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent"></div>

        <div class="relative z-10 max-w-4xl mx-auto">

            {{-- Article Content with Scientific Styling --}}
            <div class="article-prose">
                {!! $article->content !!}
            </div>

            {{-- Divider with Decorative Element --}}
            <div class="my-16 md:my-20 flex items-center justify-center">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-cyan-400/30 to-transparent"></div>
                <div class="px-8">
                    <svg class="w-8 h-8 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-cyan-400/30 to-transparent"></div>
            </div>

            {{-- Share Section - Elegant Card Style --}}
            <div class="bg-white rounded-2xl p-8 md:p-10 shadow-xl border border-cyan-400/20">
                <h3 class="text-xl md:text-2xl font-bold text-blue-900 mb-6 text-center">
                    Share this article
                </h3>

                <div class="flex flex-wrap justify-center gap-4">
                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article->slug)) }}"
                        target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-3 px-6 py-3 bg-blue-50 hover:bg-cyan-400 border border-cyan-400/30 hover:border-cyan-400
                               text-blue-900 hover:text-white rounded-xl transition-all duration-300 touch-manipulation">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="font-semibold">Facebook</span>
                    </a>

                    {{-- Twitter --}}
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('articles.show', $article->slug)) }}&text={{ urlencode($article->title) }}"
                        target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-3 px-6 py-3 bg-blue-50 hover:bg-cyan-400 border border-cyan-400/30 hover:border-cyan-400
                               text-blue-900 hover:text-white rounded-xl transition-all duration-300 touch-manipulation">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        <span class="font-semibold">Twitter</span>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . route('articles.show', $article->slug)) }}"
                        target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-3 px-6 py-3 bg-blue-50 hover:bg-cyan-400 border border-cyan-400/30 hover:border-cyan-400
                               text-blue-900 hover:text-white rounded-xl transition-all duration-300 touch-manipulation">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span class="font-semibold">WhatsApp</span>
                    </a>
                </div>
            </div>

            {{-- Back to Beautyversity - Premium CTA --}}
            <div class="mt-16 text-center">
                <a href="{{ route('home') }}#beautyversity"
                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-900
                           hover:from-cyan-400 hover:to-blue-600 text-white font-bold text-lg rounded-full
                           transition-all duration-300 shadow-xl hover:shadow-cyan-400/50 touch-manipulation group
                           border-2 border-blue-900 hover:border-cyan-400">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to Beautyversity</span>
                </a>
            </div>

        </div>
    </div>
@endsection
