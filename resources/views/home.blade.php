@extends('layouts.guest')

@section('showHero', false)
@section('showFeatures', false)

@section('content')
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-neutral-900 mb-4 sm:mb-6 leading-tight">
                Solusi Total untuk<br class="hidden sm:block">Kosmetik Berkualitas
            </h1>
            <p class="text-lg sm:text-xl text-neutral-600 mb-8 sm:mb-12 max-w-2xl mx-auto leading-relaxed">
                Membantu brand kosmetik tumbuh melalui inovasi, legalitas resmi, dan layanan menyeluruh dari ide hingga produk siap edar.
            </p>
            <a href="{{ route('login') }}" class="inline-flex items-center bg-neutral-900 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-medium hover:bg-neutral-800 transition-colors">
                Mulai Sekarang
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-3 sm:mb-4">
                    Mengapa Memilih Lunaray?
                </h2>
                <p class="text-base sm:text-lg text-neutral-600 max-w-2xl mx-auto">
                    Kami menyediakan solusi lengkap untuk pengembangan produk kosmetik berkualitas tinggi
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-neutral-900 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-neutral-900 mb-3 sm:mb-4">Legalitas Resmi</h3>
                    <p class="text-sm sm:text-base text-neutral-600">Semua produk memenuhi standar BPOM dan regulasi terkait</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-neutral-900 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-neutral-900 mb-3 sm:mb-4">Inovasi Terdepan</h3>
                    <p class="text-sm sm:text-base text-neutral-600">Teknologi dan formula terbaru untuk hasil optimal</p>
                </div>
                
                <div class="text-center sm:col-span-2 lg:col-span-1">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-neutral-900 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-neutral-900 mb-3 sm:mb-4">Layanan Menyeluruh</h3>
                    <p class="text-sm sm:text-base text-neutral-600">Dari ide hingga produk siap edar dengan dukungan penuh</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-1 sm:mb-2">5+</div>
                    <div class="text-xs sm:text-sm text-neutral-600">Years Experience</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-1 sm:mb-2">500+</div>
                    <div class="text-xs sm:text-sm text-neutral-600">Products Created</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-1 sm:mb-2">100+</div>
                    <div class="text-xs sm:text-sm text-neutral-600">Happy Clients</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-1 sm:mb-2">24/7</div>
                    <div class="text-xs sm:text-sm text-neutral-600">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4 sm:mb-6">
                Siap Memulai Proyek Kosmetik Anda?
            </h2>
            <p class="text-base sm:text-lg text-neutral-300 mb-6 sm:mb-8 max-w-2xl mx-auto">
                Konsultasikan ide produk kosmetik Anda dengan tim ahli kami dan wujudkan impian brand kosmetik yang sukses.
            </p>
            <a href="{{ route('login') }}" class="inline-flex items-center bg-white text-neutral-900 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-medium hover:bg-neutral-100 transition-colors">
                Konsultasi Gratis
            </a>
        </div>
    </section>
@endsection
