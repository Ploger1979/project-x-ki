<template>
  <div
    class="min-h-screen flex flex-col items-center justify-between relative overflow-hidden font-sans select-none"
    style="background-image: url('/images/image-4-pro.png'); background-size: cover; background-position: center center; background-repeat: no-repeat;"
  >
    <!-- Subtle overlay for text readability while keeping image natural -->
    <div class="absolute inset-0 bg-black/10 pointer-events-none"></div>

    <!-- Header: Login & Register links at top right -->
    <header class="relative w-full flex justify-end items-center px-8 py-6 z-20">
      <div class="flex items-center gap-6 font-bold text-lg">
        <Link 
          href="/login" 
          class="text-white hover:text-blue-300 transition-colors drop-shadow-[0_2px_6px_rgba(0,0,0,0.8)] font-semibold tracking-wide"
        >
          Login
        </Link>
        <Link 
          href="/register" 
          class="text-white hover:text-blue-300 transition-colors drop-shadow-[0_2px_6px_rgba(0,0,0,0.8)] font-semibold tracking-wide"
        >
          Register
        </Link>
      </div>
    </header>

    <!-- Main Hero: "Willkommen bei Enodia Software" -->
    <main class="relative z-10 flex flex-col items-center justify-center text-center px-4 my-auto">
      <h1 
        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-wide drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)] animate-fade-in"
      >
        Willkommen bei Enodia Software
      </h1>

      <p class="text-white/90 text-lg md:text-xl font-medium max-w-xl mb-4 drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]">
        KI-gestütztes Ticket-Management System
      </p>
    </main>

    <!-- Footer: Enodia Software Logo without white background -->
    <footer class="relative z-10 w-full flex flex-col items-center pb-8 pt-4">
      <div class="relative group cursor-pointer">
        <img
          src="/images/enodia-logo-clean.png"
          alt="Enodia Software"
          class="h-20 md:h-24 object-contain drop-shadow-[0_4px_16px_rgba(0,0,0,0.7)] group-hover:scale-105 transition-all duration-300"
        />
        <!-- Subtle pulsing glow under logo -->
        <div class="absolute -inset-2 bg-teal-400/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fadeIn 0.8s ease-out forwards;
}
</style>
