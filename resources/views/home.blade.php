<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunaray Beauty Factory - Solusi Total untuk Kosmetik Berkualitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-neutral min-h-screen">
    <!-- Header -->
    <header class="bg-primary text-white">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">LUNARAY</h1>
                        <p class="text-xs text-secondary">BEAUTY FACTORY</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-6">
                    <a href="#" class="hover:text-secondary transition-colors">Home</a>
                    <a href="#" class="hover:text-secondary transition-colors">About Us</a>
                    <a href="#" class="hover:text-secondary transition-colors">Services</a>
                    <a href="#" class="hover:text-secondary transition-colors">Contact Us</a>
                </nav>
                
                <!-- CTA Button -->
                <a href="/auth/google/redirect" class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-accent transition-colors">
                    GET STARTED
                </a>
            </div>
        </div>
    </header>

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
                    <a href="/auth/google/redirect" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary/90 transition-colors">
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

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">L</span>
                        </div>
                        <div>
                            <h4 class="font-bold">LUNARAY</h4>
                            <p class="text-xs text-secondary">BEAUTY FACTORY</p>
                        </div>
                    </div>
                    <p class="text-secondary text-sm">
                        Solusi total untuk kosmetik berkualitas dengan inovasi dan legalitas resmi.
                    </p>
                </div>
                
                <div>
                    <h5 class="font-semibold mb-4">Perusahaan</h5>
                    <ul class="space-y-2 text-sm text-secondary">
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Layanan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Portfolio</a></li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="font-semibold mb-4">Dukungan</h5>
                    <ul class="space-y-2 text-sm text-secondary">
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="font-semibold mb-4">Ikuti Kami</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center hover:bg-accent transition-colors">
                            <span class="text-white text-sm font-bold">f</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center hover:bg-accent transition-colors">
                            <span class="text-white text-sm font-bold">ig</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center hover:bg-accent transition-colors">
                            <span class="text-white text-sm font-bold">tw</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center hover:bg-accent transition-colors">
                            <span class="text-white text-sm font-bold">in</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-primary/20 mt-8 pt-8 text-center">
                <p class="text-secondary text-sm">
                    © 2024 Lunaray Beauty Factory. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
