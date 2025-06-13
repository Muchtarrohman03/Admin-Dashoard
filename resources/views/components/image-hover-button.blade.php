<div class="relative overflow-hidden group" 
     x-data="{ isHovered: false }" 
     @mouseenter="isHovered = true" 
     @mouseleave="isHovered = false">

    <!-- Gambar Produk -->
    <img 
        class="w-full sm:h-72 md:max-h-80 xl:h-96 object-cover border border-slate-200 rounded-md transition-transform duration-300"
        :class="{ 'scale-105': isHovered }"
        src="{{ asset('storage/' . $image) }}" 
        alt="{{ $alt }}"
    >

    <!-- Overlay & Tombol -->
    <div 
        class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 transition-all duration-300 rounded-md"
        :class="{ 'opacity-100': isHovered }"
    >
        <a 
            href="{{ $buttonLink }}"
            class="btn bg-accent font-bold text-secondary px-5 py-2 rounded-full shadow-lg transform transition-all duration-300"
            :class="{ 'translate-y-0': isHovered, 'translate-y-4': !isHovered }"
        >
            {{ $buttonText }}
        </a>
    </div>
</div>
