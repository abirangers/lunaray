@extends('layouts.guest')

@section('title', 'Lunaray Beauty Factory - Solusi Total untuk Kosmetik Berkualitas')
@section('heroTitle', 'Solusi Total untuk Kosmetik Berkualitas')
@section('heroSubtitle', 'Membantu brand kosmetik tumbuh melalui inovasi, legalitas resmi, dan layanan menyeluruh dari ide hingga produk siap edar.')

@section('showHero', true)
@section('showFeatures', true)

@section('content')

    <!-- Hero Section -->
    <main class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6">
                <h2 class="text-4xl md:text-5xl font-bold text-dark leading-tight">
                    Solusi Total untuk Kosmetik Berkualitas
                </h2>
                
                <p class="text-lg text-dark/80 leading-relaxed">
                    Beauty is a journey, not a destination: it's about unveiling the masterpiece that you already are.
                </p>
                
                <p class="text-base text-dark/70">
                    Membantu brand kosmetik tumbuh melalui inovasi, legalitas resmi, dan layanan menyeluruh dari ide hingga produk siap edar.
                </p>
                
                <!-- Stats -->
                <div class="flex space-x-8 pt-4">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-white font-bold text-lg">5</span>
                        </div>
                        <p class="text-sm text-dark/70">Years of Experience</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-white font-bold text-lg">500+</span>
                        </div>
                        <p class="text-sm text-dark/70">Produk</p>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex space-x-4 pt-6">
                    <a href="{{ route('login') }}" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary/90 transition-colors">
                        Mulai Sekarang
                    </a>
                    <a href="#" class="bg-neutral text-primary px-8 py-3 rounded-lg hover:bg-accent hover:text-white transition-colors">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            
            <!-- Right Content - Placeholder -->
            <div class="bg-gradient-to-br from-primary/10 to-secondary/10 rounded-2xl p-8 text-center">
                <div class="w-32 h-32 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-4xl font-bold">L</span>
                </div>
                <h3 class="text-xl font-semibold text-dark mb-2">Professional Beauty Solutions</h3>
                <p class="text-dark/70">Your trusted partner in cosmetic manufacturing</p>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-dark mb-4">Mengapa Memilih Lunaray?</h3>
                <p class="text-dark/70 max-w-2xl mx-auto">
                    Kami menyediakan solusi lengkap untuk pengembangan produk kosmetik berkualitas tinggi
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-dark mb-2">Legalitas Resmi</h4>
                    <p class="text-dark/70">Semua produk memenuhi standar BPOM dan regulasi terkait</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-dark mb-2">Inovasi Terdepan</h4>
                    <p class="text-dark/70">Teknologi dan formula terbaru untuk hasil optimal</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-dark mb-2">Layanan Menyeluruh</h4>
                    <p class="text-dark/70">Dari ide hingga produk siap edar dengan dukungan penuh</p>
                </div>
            </div>
        </div>
    </section>
@endsection
