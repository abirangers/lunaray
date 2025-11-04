@extends('layouts.guest')

@section('showHero', false)
@section('showFeatures', false)

@section('content')
    {{-- ============================================
         HERO SECTION
         ============================================ --}}
    <div class="relative w-full overflow-hidden">
        {{-- Hero Background Slider --}}
        @if($heroes->count() > 0)
            <div class="hero-slider-container relative">
                {{-- Gradient Overlay for Better Text Contrast --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/20 z-10 pointer-events-none"></div>

                <div class="splide hero-slider">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach($heroes as $hero)
                                <li class="splide__slide">
                                    @if($hero->hasMedia('hero_image'))
                                        <img src="{{ $hero->getFirstMediaUrl('hero_image', 'large') }}"
                                            alt="{{ $hero->name }}"
                                            class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh] xl:h-screen object-cover object-center">
                                    @else
                                        <img src="{{ asset('images/lunaray-landing/newbackground.webp') }}"
                                            alt="Lunaray Beauty Factory - Where Science and Innovation Meet Beauty"
                                            class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh] xl:h-screen object-cover object-center">
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="relative w-full overflow-hidden">
                {{-- Gradient Overlay for Better Text Contrast --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/20 z-10 pointer-events-none"></div>

                <img src="{{ asset('images/lunaray-landing/newbackground.webp') }}"
                    alt="Lunaray Beauty Factory - Where Science and Innovation Meet Beauty"
                    class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh] xl:h-screen object-cover object-center">
            </div>
        @endif
    </div>

    {{-- ============================================
         TAGLINE SECTION
         ============================================ --}}
    <div class="bg-[#000d1a] py-8 sm:py-10 md:py-12 lg:py-16 px-4 sm:px-6 md:px-12 text-center font-adolphus" style="z-index: 9999 !important;">
        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-script text-white italic tracking-wide sm:tracking-wider leading-tight">
            Beauty Manufacturing Made Simple
        </h2>
    </div>

    {{-- ============================================
         PRODUCTS SECTION WITH CATEGORIES
         ============================================ --}}
         <div class="min-h-screen bg-[url('/images/lunaray-landing/bg-section2.webp')] bg-cover bg-center overflow-hidden px-8">

            {{-- Section Header --}}
            <div class="pt-16 pb-10 space-y-4 max-w-6xl mx-auto">
                <div class="text-right">
                    <h1 class="text-6xl text-blue-900 font-script">
                        Transforming <span class="font-bold">Dreams</span> <br>
                        Into <span class="font-bold">Reality</span>
                    </h1>
                </div>
                <div class="text-right">
                    <p class="text-base text-blue-900 font-script">
                        Dari riset ilmiah hingga produk berkualitas tinggi, Lunaray Beauty Factory
                        menjembatani sains dan estetika untuk melahirkan inovasi kosmetik yang bermakna.
                        Dengan fasilitas CPKB Grade A dan tim ahli berpengalaman, kami mewujudkan
                        visi brand Anda menjadi produk yang siap bersaing di pasar.
                    </p>
                </div>
            </div>
    
            {{-- Product Categories & Grid --}}
            <div x-data="{ activeTab: '{{ $categories->first()->slug ?? 'skincare' }}' }">
                @if ($categories->isNotEmpty())
                    {{-- Category Tabs (Dynamic) --}}
                    <div class="flex flex-wrap gap-2 justify-center text-center">
                        <div class="bg-black p-2 rounded-lg">
                            @foreach ($categories as $category)
                                <button @click="activeTab = '{{ $category->slug }}'"
                                    :class="activeTab === '{{ $category->slug }}' ? 'text-cyan-400' : 'text-white'"
                                    class="px-3 py-1 font-semibold text-[21px] hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700 transition-colors">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
    
                    {{-- Products Slider (Dynamic) --}}
                    <div class="product-slider-container">
                        @foreach($categories as $category)
                            <div x-show="activeTab === '{{ $category->slug }}'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="splide category-slider"
                                 data-category="{{ $category->slug }}"
                                 x-init="$watch('activeTab', value => {
                                     if (value === '{{ $category->slug }}') {
                                         setTimeout(() => initCategorySlider('{{ $category->slug }}'), 50);
                                     }
                                 })">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @php
                                            $categoryProducts = $products->where('product_category_id', $category->id);
                                        @endphp
                                        @forelse($categoryProducts as $product)
                                            <li class="splide__slide">
                                                <div class="flex-shrink-0 w-full relative overflow-hidden rounded-lg">
                                                    <div class="relative flex flex-col items-center justify-center">
                                                        {{-- Product Image --}}
                                                        @if ($product->hasMedia('product_image'))
                                                            <img class="w-full h-72 object-cover"
                                                                src="{{ $product->getFirstMediaUrl('product_image', 'medium') }}"
                                                                alt="{{ $product->name }}" loading="lazy">
                                                        @else
                                                            <div class="w-full h-72 bg-neutral-200 flex items-center justify-center">
                                                                <svg class="w-24 h-24 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        {{-- Product Name --}}
                                                        <div>
                                                            <span class="justify-center ml-auto text-xl text-center text-black flex mt-4">
                                                                {{ $product->name }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="splide__slide">
                                                <div class="text-center py-8">
                                                    <p class="text-neutral-600">No products available in this category.</p>
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Static Fallback Categories --}}
                    <div class="flex flex-wrap gap-2 justify-center text-center">
                        <div class="bg-black p-2 rounded-lg">
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-cyan-400 hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Skincare
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Bodycare
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Haircare
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Babycare
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Mommycare
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Mancare
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Therapeutic
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Decorative
                            </button>
                            <button
                                class="px-3 py-1 font-semibold text-[21px] text-white hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700">
                                Perfume
                            </button>
                        </div>
                    </div>
    
                    {{-- Static Fallback Products --}}
                    <div class="p-4 flex flex-wrap justify-center gap-4">
                        {{-- Body Wash Product --}}
                        <div class="flex-shrink-0 w-80 relative overflow-hidden rounded-lg">
                            <div class="relative flex flex-col items-center justify-center">
                                <img class="w-full h-72 object-cover"
                                    src="{{ asset('images/lunaray-landing/body_wash_lunaray.webp') }}" alt="Body Wash">
                                <div>
                                    <span class="justify-center ml-auto text-xl text-center text-black flex">
                                        Body Wash
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        {{-- Facial Mask Product --}}
                        <div class="flex-shrink-0 w-80 relative overflow-hidden rounded-lg">
                            <div class="relative flex flex-col items-center justify-center">
                                <img class="w-full h-72 object-cover"
                                    src="{{ asset('images/lunaray-landing/Facial-Mask.webp') }}" alt="Facial Mask">
                                <div>
                                    <span class="justify-center ml-auto text-xl text-center text-black flex">
                                        Facial Mask
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        {{-- Facial Scrub Product --}}
                        <div class="flex-shrink-0 w-80 relative overflow-hidden rounded-lg">
                            <div class="relative flex flex-col items-center justify-center">
                                <img class="w-full h-72 object-cover"
                                    src="{{ asset('images/lunaray-landing/Facial-Scrub.webp') }}" alt="Facial Scrub">
                                <div>
                                    <span class="justify-center ml-auto text-xl text-center text-black flex">
                                        Facial Scrub
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
    
            {{-- ============================================
                 QUOTE & DISCOVER SECTION
                 ============================================ --}}
                 <section class="relative py-10 sm:py-12 md:py-16 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 text-center">
                    <div class="max-w-4xl mx-auto relative z-10">
                        {{-- Quote --}}
                        <div class="mb-6 sm:mb-8 md:mb-12">
                            <p class="font-rhinetta text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl tracking-wide italic font-normal text-blue-900 leading-relaxed">
                                "From research to radiance <br class="hidden sm:block">
                                every drop tells the story of science meet beauty."
                            </p>
                        </div>
        
                        {{-- Description with Discover Button --}}
                        <div class="max-w-6xl mx-auto relative">
                            {{-- Discover Button - Responsive positioning --}}
                            <div class="hidden lg:block absolute -top-20 -right-20 z-20">
                                <a href="#"
                                    class="border border-blue-400 text-blue-600 font-semibold rounded-lg px-5 py-2 text-xl hover:bg-blue-50 transition inline-block bg-white/90 backdrop-blur-sm text-center">
                                    DISCOVER
                                    <span class="block text-xs text-blue-400 font-normal -mt-1">
                                        our product range
                                    </span>
                                </a>
                            </div>
        
                            {{-- Description Text --}}
                            <p class="text-sm sm:text-base md:text-lg text-black leading-relaxed text-center mb-6 lg:mb-0">
                                Sebagai maklon skincare berbasis riset ilmiah, Lunaray menjembatani sains dan estetika untuk
                                melahirkan
                                produk kosmetik yang tidak hanya indah secara tampilan, tapi juga bermakna secara ilmiah dan etis.
                                Melalui
                                riset multidisipliner, keahlian, pengalaman, teknologi, dan kolaborasi global, kami mewujudkan mimpi
                                setiap
                                brand menjadi inovasi yang berdaya saing tinggi yang membantu mewujudkan impian anda.
                            </p>
        
                            {{-- Discover Button - Mobile/Tablet centered --}}
                            <div class="lg:hidden flex justify-center mt-6 sm:mt-8">
                                <a href="#"
                                    class="border-2 border-blue-400 text-blue-600 font-semibold rounded-lg px-6 py-3 text-base sm:text-lg hover:bg-blue-50 transition inline-block bg-white/90 backdrop-blur-sm text-center touch-manipulation">
                                    DISCOVER
                                    <span class="block text-xs sm:text-sm text-blue-400 font-normal -mt-0.5">
                                        our product range
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
        </div>

    {{-- ============================================
         THE SCIENTIST'S CHOICE SECTION
         ============================================ --}}
    <section class="relative w-full min-h-screen overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/lunaray-landing/bg-innovation.png') }}" class="w-full h-full object-cover"
                alt="Science Background">
        </div>

        {{-- Content Container --}}
        <div
            class="relative z-10 min-h-screen flex items-center justify-center lg:justify-end px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-8 sm:py-10 md:py-12 lg:py-16 max-w-7xl mx-auto">
            <div class="w-full max-w-2xl flex flex-col items-center justify-center">
                {{-- Section Title --}}
                <div class="mb-6 sm:mb-8 md:mb-10">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-rhinetta text-white font-normal leading-tight text-center">
                        The Scientist's Choice
                    </h2>
                </div>

                {{-- Featured Product Image --}}
                <div class="mb-6 sm:mb-8 md:mb-10 flex justify-center w-full">
                    <img src="{{ asset('images/lunaray-landing/Facial-Mask.webp') }}"
                        class="w-full max-w-xs sm:max-w-sm md:max-w-md h-64 sm:h-72 md:h-80 lg:h-96 object-contain" alt="Facial Mask">
                </div>

                {{-- Description Text --}}
                <div class="px-4 sm:px-6 md:px-8">
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-white leading-relaxed max-w-xl text-center">
                        Setiap formulasi unggulan ini kami pilih berdasarkan hasil riset ilmiah dan pengujian mendalam.
                        Dirancang bukan sekadar menarik — tapi efektif, aman, dan bermanfaat bagi kulit anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================
         INNOVATION SECTION
         ============================================ --}}
    <section class="relative w-full min-h-screen overflow-hidden">
        {{-- Background Container --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/lunaray-landing/innovation-background.png') }}"
                alt="Lunaray Beauty Innovation Background" class="w-full h-full object-cover">
        </div>

        {{-- Content Container --}}
        <div class="relative z-10 min-h-screen px-6 md:px-12 lg:px-16 py-12">
            <div class="max-w-7xl mx-auto">

                {{-- Text Content Section --}}
                <div class="mb-12 md:mb-16">
                    {{-- Main Header --}}
                    <div class="mb-4">
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-blue-900">
                            Lunaray <br> Beauty Innovation
                        </h2>
                    </div>

                    {{-- Sub Header --}}
                    <div class="mb-6">
                        <h3 class="text-xl md:text-2xl lg:text-3xl text-blue-900 italic">
                            AI-Powered, Nature-Inspired.
                        </h3>
                    </div>

                    {{-- Description Paragraphs --}}
                    <div class="space-y-4 max-w-4xl">
                        <p class="text-base md:text-lg text-blue-900 leading-relaxed">
                            Kami melihat riset bukan sekadar data tapi seni untuk memahami kebutuhan manusia melalui sains.
                        </p>
                        <p class="text-base md:text-lg text-blue-900 leading-relaxed">
                            Kami memadukan riset ilmiah, kecerdasan buatan (AI), dan kolaborasi global untuk menciptakan
                            formula masa depan.
                            Lunaray menjadi jembatan antara data, penelitian, dan keindahan.
                        </p>
                        <p class="text-base md:text-lg text-blue-900 leading-relaxed">
                            Lunaray menjalin kemitraan aktif dengan institusi dan laboratorium dalam dan luar negeri serta
                            lembaga riset dan institusi akademik.
                            Kolaborasi ini memperkuat riset formulasi, teknologi produksi, dan pengembangan bahan aktif
                            lokal agar dapat bersaing di tingkat global.
                        </p>
                    </div>
                </div>

                {{-- Innovation Cards Section --}}
                <div class="flex flex-wrap gap-4 md:gap-6">
                    {{-- Card 1: Inovasi Bahan Aktif --}}
                    <div class="w-32 md:w-36 lg:w-40">
                        <img src="{{ asset('images/lunaray-landing/cards/inovasi-bahan-aktif.webp') }}"
                            alt="Inovasi Bahan Aktif" class="w-full h-auto object-cover">
                    </div>

                    {{-- Card 2: Inovasi Formulasi --}}
                    <div class="w-32 md:w-36 lg:w-40">
                        <img src="{{ asset('images/lunaray-landing/cards/inovasi-formulasi.webp') }}"
                            alt="Inovasi Formulasi" class="w-full h-auto object-cover">
                    </div>

                    {{-- Card 3: Inovasi AI dan Teknologi --}}
                    <div class="w-32 md:w-36 lg:w-40">
                        <img src="{{ asset('images/lunaray-landing/cards/inovasi-ai-dan-teknologi.webp') }}"
                            alt="Inovasi AI dan Teknologi" class="w-full h-auto object-cover">
                    </div>

                    {{-- Card 4: AI Product Concept --}}
                    <a href="https://product-concept.lunaray.id" class="w-32 md:w-36 lg:w-52 -mt-10 block focus:outline-none focus:ring-2 focus:ring-accent rounded-lg transition-shadow hover:shadow-lg" title="AI Product Concept">
                        <img src="{{ asset('images/lunaray-landing/cards/ai-product-concept.webp') }}"
                            alt="AI Product Concept" class="w-full h-auto object-cover">
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================
     CREATE YOUR JOURNEY SECTION
     ============================================ --}}
    <section class="relative w-full min-h-screen overflow-hidden">
        {{-- Background Container --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/lunaray-landing/journey-background.webp') }}" alt="Create Your Journey Background"
                class="w-full h-full object-cover">
        </div>

        {{-- Content Container --}}
        <div class="relative z-10 min-h-screen px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-8 sm:py-10 md:py-12 lg:py-16">
            <div class="max-w-7xl mx-auto">

                {{-- Header Section --}}
                <div class="text-center mb-6 sm:mb-8 md:mb-10 lg:mb-12">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-3 sm:mb-4 md:mb-5 lg:mb-6">
                        Create Your <span class="text-white">Journey...</span>
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-white leading-relaxed max-w-4xl mx-auto px-4 sm:px-6">
                        Lunaray hadir untuk mendampingi beautypreneur di setiap tahap perjalanan,
                        dari ide pertama hingga inovasi yang siap memasuki pasar.
                    </p>
                </div>

                {{-- Circular Service Cards --}}
                <div class="flex flex-wrap justify-center items-start gap-4 sm:gap-6 md:gap-8 lg:gap-10 xl:gap-12 mb-8 sm:mb-10 md:mb-12 lg:mb-16">

                    {{-- Card 1: Private Label --}}
                    <div class="text-center w-32 sm:w-36 md:w-40 lg:w-44 xl:w-48">
                        <div
                            class="w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 xl:w-48 xl:h-48 rounded-full border-3 sm:border-4 md:border-[5px] lg:border-[6px] border-white flex items-center justify-center mb-3 sm:mb-4 bg-transparent backdrop-blur-sm touch-manipulation">
                            <div class="text-center">
                                <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white leading-tight">
                                    PRIVATE<br>LABEL
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: OEM / ODM --}}
                    <div class="text-center w-32 sm:w-36 md:w-40 lg:w-44 xl:w-48">
                        <div
                            class="w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 xl:w-48 xl:h-48 rounded-full border-3 sm:border-4 md:border-[5px] lg:border-[6px] border-white flex items-center justify-center mb-3 sm:mb-4 bg-transparent backdrop-blur-sm touch-manipulation">
                            <div class="text-center">
                                <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white leading-tight">
                                    OEM /<br>ODM
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: OBM / IPM (First) --}}
                    <div class="text-center w-32 sm:w-36 md:w-40 lg:w-44 xl:w-48">
                        <div
                            class="w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 xl:w-48 xl:h-48 rounded-full border-3 sm:border-4 md:border-[5px] lg:border-[6px] border-white flex items-center justify-center mb-3 sm:mb-4 bg-transparent backdrop-blur-sm touch-manipulation">
                            <div class="text-center">
                                <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white leading-tight">
                                    OBM /<br>IPM
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- Card 4: OBM / IPM (Second) --}}
                    <div class="flex flex-col items-center text-center w-32 sm:w-36 md:w-40 lg:w-44 xl:w-48">
                        <div
                            class="w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 xl:w-48 xl:h-48 rounded-full border-3 sm:border-4 md:border-[5px] lg:border-[6px] border-white flex items-center justify-center mb-3 sm:mb-4 bg-transparent backdrop-blur-sm touch-manipulation">
                            <div class="text-center">
                                <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white leading-tight">
                                    OBM /<br>IPM
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Bottom Description --}}
                <div class="max-w-5xl mx-auto text-center px-4 sm:px-6 md:px-8">
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-white leading-relaxed">
                        Melalui ekosistem manufaktur kosmetik terpadu, kami menyediakan layanan maklon kosmetik terbaik dan
                        menyeluruh:
                        Private Label, OEM/ODM, OBM hingga IPM. Bersama para ahli kosmetik, dermatolog, dan dokter
                        spesialis,
                        kami merancang formulasi yang tidak hanya indah dalam hasil, tapi juga kuat dalam sains dan
                        bernilai.
                    </p>
                </div>

            </div>
        </div>
    </section>
    {{-- ============================================
     BEAUTYVERSITY SECTION
     ============================================ --}}
    <section class="relative w-full min-h-screen overflow-hidden bg-blue-300 py-16 md:py-20">

        {{-- Content Container --}}
        <div class="relative z-10 px-6 md:px-12 lg:px-16">
            <div class="max-w-7xl mx-auto">

                {{-- Section Header --}}
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                        Beauty<span class="font-normal">versity</span>
                    </h2>
                </div>

                {{-- Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">

                    {{-- Card 1: Phytosync --}}
                    <div class="flex flex-col">
                        {{-- Image Container with Border --}}
                        <div class="mb-4">
                            <div class="aspect-[4/3] overflow-hidden rounded">
                                <img src="{{ asset('images/lunaray-landing/articles/fruitable.webp') }}"
                                    alt="Phytosync Inovasi Bahan Aktif" class="w-full h-full object-contain">
                            </div>
                        </div>

                        {{-- Card Content --}}
                        <div class="space-y-3">
                            <h3 class="text-xl md:text-2xl font-bold text-blue-950">
                                Phytosync : Inovasi Bahan Aktif dari Ekstrak hayati
                            </h3>
                            <p class="text-sm md:text-base text-blue-950 leading-relaxed">
                                Kekayaan alam Indonesia melimpah ruah. LabCos Universitas Padjadjaran bekerjasama
                                dengan Beautylatory dan Lunaray Beauty Factory memperkenalkan Beautylatory Phytosync Series—
                                inovasi bahan aktif dari ekstrak hayati lokal yang dikembangkan melalui riset ilmiah mendalam.
                            </p>
                            <a href="#"
                                class="inline-block text-blue-950 font-semibold hover:text-blue-600 transition">
                                Baca selengkapnya >>
                            </a>
                        </div>
                    </div>

                    {{-- Card 2: Cosmobeauté --}}
                    <div class="flex flex-col">
                        {{-- Image Container with Border --}}
                        <div class="mb-4">
                            <div class="aspect-[4/3] overflow-hidden rounded">
                                <img src="{{ asset('images/lunaray-landing/articles/cosmebeauty.webp') }}"
                                    alt="Cosmobeauté Indonesia 2025" class="w-full h-full object-contain">
                            </div>
                        </div>

                        {{-- Card Content --}}
                        <div class="space-y-3">
                            <h3 class="text-xl md:text-2xl font-bold text-blue-950">
                                Lunaray menghadirkan beragam inovasi di Cosmobeauté 2025
                            </h3>
                            <p class="text-sm md:text-base text-blue-950 leading-relaxed">
                                Lunaray Beauty Factory memamerkan beragam inovasi terkini di ajang Cosmobeauté Indonesia 2025—
                                dari formulasi berbasis AI hingga bahan aktif lokal hasil riset kolaboratif.
                                Event ini menjadi bukti komitmen kami dalam menghadirkan solusi kosmetik berkelas global.
                            </p>
                            <a href="#"
                                class="inline-block text-blue-950 font-semibold hover:text-blue-600 transition">
                                Baca selengkapnya >>
                            </a>
                        </div>
                    </div>

                    {{-- Card 3: 5 Kesalahan Fatal --}}
                    <div class="flex flex-col">
                        {{-- Image Container with Border --}}
                        <div class="mb-4">
                            <div class="aspect-[4/3] overflow-hidden rounded">
                                <img src="{{ asset('images/lunaray-landing/articles/brand.webp') }}"
                                    alt="5 Kesalahan Fatal Brand Kosmetik" class="w-full h-full object-contain">
                            </div>
                        </div>

                        {{-- Card Content --}}
                        <div class="space-y-3">
                            <h3 class="text-xl md:text-2xl font-bold text-blue-950">
                                5 Kesalahan Fatal Saat Memulai Brand Kosmetik
                            </h3>
                            <p class="text-sm md:text-base text-blue-950 leading-relaxed">
                                Memulai brand kosmetik tanpa persiapan matang berisiko merugikan. Dari pemilihan maklon yang salah
                                hingga mengabaikan legalitas BPOM dan Halal—pelajari 5 kesalahan fatal yang sering terjadi
                                dan cara menghindarinya untuk kesuksesan brand Anda.
                            </p>
                            <a href="#"
                                class="inline-block text-blue-950 font-semibold hover:text-blue-600 transition">
                                Baca selengkapnya >>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </section>

    {{-- ============================================
     CTA SECTION - Ready to Build the Future
     ============================================ --}}
    <section class="relative w-full min-h-screen overflow-hidden">

        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/lunaray-landing/cta-background.webp') }}"
                alt="Ready to Build the Future of Beauty" class="w-full h-full object-cover">
        </div>

        {{-- Dark Overlay (optional for better text readability) --}}
        <div class="absolute inset-0 bg-black/20"></div>

        {{-- Content Container --}}
        <div
            class="relative z-10 min-h-screen flex flex-col justify-between items-center px-6 md:px-12 lg:px-16 py-12 md:py-16">

            {{-- Main Heading (Top) --}}
            <div class="w-full max-w-6xl text-center pt-8 md:pt-12">
                <h2 class="font-rhinetta text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-script text-white italic leading-tight">
                    Ready to Build the Future of <br class="hidden md:block">
                    Beauty Together?
                </h2>
            </div>

            {{-- Description Paragraph (Bottom) --}}
            <div class="w-full max-w-5xl text-center pb-8 md:pb-12">
                <p class="text-base md:text-lg lg:text-xl text-white leading-relaxed">
                    Lunaray Beauty Factory hadir sebagai solusi end-to-end jasa <span class="text-cyan-300">maklon kosmetik
                        terbaik</span> untuk pebisnis
                    yang ingin menembus pasar dengan produk berkualitas <span class="text-cyan-300">tinggi dan
                        legal</span>. Dengan pengalaman lebih
                    dari 25 tahun dibidang formulasi dan produksi, Ilmuan <span class="text-cyan-300">dan tim</span> kami
                    memastikan setiap produk dipro-
                    duksi dengan standar tertinggi, sesuai dengan <span class="text-cyan-300">sertifikasi</span> CPKB,
                    BPOM, Halal, dan HKI.
                </p>
            </div>

        </div>

    </section>
    {{-- ============================================
     CONTACT US SECTION
     ============================================ --}}
    <section class="relative w-full min-h-screen overflow-hidden">

        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/lunaray-landing/contact-background.webp') }}" alt="Contact Us Background"
                class="w-full h-full object-cover">
        </div>

        {{-- Content Container --}}
        <div class="relative z-10 min-h-screen px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-8 sm:py-10 md:py-12 lg:py-16">
            <div class="max-w-7xl mx-auto">

                {{-- Section Header --}}
                <div class="mb-6 sm:mb-8 md:mb-10 lg:mb-12">
                    <h2 class="font-rhinetta text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-script text-white italic mb-4 sm:mb-5 md:mb-6">
                        Contact Us
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-white leading-relaxed max-w-4xl px-2 sm:px-0">
                        Mari mulai perjalanan kolaborasi yang berlandaskan riset, inovasi, dan kepercayaan.
                        Bersama Lunaray, setiap ide bisa berkembang menjadi produk yang membawa nilai, keindahan, dan
                        dampak positif bagi industri kecantikan.
                    </p>
                </div>

                {{-- Map and Address Container --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 md:gap-10 lg:gap-12 mb-8 sm:mb-10 md:mb-12 lg:mb-16">

                    {{-- Map Container --}}
                    <div class="w-full">
                        <div class="bg-white rounded-lg overflow-hidden shadow-xl">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d534.5142302632032!2d107.53438010185985!3d-6.953537014431402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ef41d28a661f%3A0x3c7c9ff88afdf20c!2sLunaray%20Beauty%20Factory%20(Maklon%20Kosmetik)!5e0!3m2!1sid!2sid!4v1762153395993!5m2!1sid!2sid"
                            width="100%"
                            height="300"
                            class="sm:h-[350px] md:h-[400px] lg:h-[450px]"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        </div>
                    </div>

                    {{-- Address Container with Futuristic Frame --}}
                    <div class="relative flex items-center justify-center min-h-[300px] sm:min-h-[350px] md:min-h-[400px] lg:min-h-[450px]">
                        {{-- Background Frame Image --}}
                        <div class="absolute inset-0 flex items-center justify-center p-4">
                            <img src="{{ asset('images/lunaray-landing/address-container.webp') }}"
                                alt="Address Container Frame" class="w-full h-auto max-w-xs sm:max-w-sm md:max-w-md lg:max-w-2xl">
                        </div>
                    </div>

                </div>

                {{-- Bottom Section: Certification Badge & Social Media --}}
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 sm:gap-8">

                    {{-- Certification Badge --}}
                    <div class="flex-shrink-0 flex items-center gap-3 sm:gap-4 md:gap-5">
                        <img src="{{ asset('images/lunaray-landing/CPKB.webp') }}" alt="CPKB Certification"
                            class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 object-contain">
                        <img src="{{ asset('images/lunaray-landing/BPOM.webp') }}" alt="BPOM Certification"
                            class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 object-contain">
                        <img src="{{ asset('images/lunaray-landing/HALAL.webp') }}" alt="HALAL Certification"
                            class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 object-contain">
                    </div>

                    {{-- Social Media Icons --}}
                    <div class="flex items-center gap-4 sm:gap-5 md:gap-6">
                        {{-- Facebook --}}
                        <a href="#" class="group touch-manipulation">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 border-3 sm:border-4 border-cyan-400 rounded-lg sm:rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 text-cyan-400 group-hover:text-white transition"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </div>
                        </a>

                        {{-- Instagram --}}
                        <a href="#" class="group touch-manipulation">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 border-3 sm:border-4 border-cyan-400 rounded-lg sm:rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 text-cyan-400 group-hover:text-white transition"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </div>
                        </a>

                        {{-- YouTube --}}
                        <a href="#" class="group touch-manipulation">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 border-3 sm:border-4 border-cyan-400 rounded-lg sm:rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 text-cyan-400 group-hover:text-white transition"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </div>
                        </a>
                    </div>

                    <span style="visibility: hidden;">lorem ipsum dolor sit amet consectetur</span>
                </div>

            </div>
        </div>

    </section>
@endsection
