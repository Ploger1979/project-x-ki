<template>
  <div
    class="min-h-screen flex flex-col items-center justify-center relative"
    style="background-image: url('/images/image 4.png'); background-size: cover; background-position: center;"
  >
    <!-- Header: أزرار الدخول والتسجيل فوق يمين -->
    <header class="absolute top-0 left-0 w-full flex justify-end p-8 z-10">
      <div class="flex gap-8">
        <Link href="/login" class="font-semibold text-xl rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">Login</Link>
        <Link href="/register" class="font-semibold text-xl rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">Register</Link>
      </div>
    </header>

    <!-- محتوى الصفحة الرئيسي -->
    <div class="flex flex-col items-center justify-center flex-1 w-full">
      <h1 class="text-4xl font-bold text-white mb-12 mt-28 text-center" style="text-shadow: 2px 2px 10px #000;">
        Willkommen bei Enodia Software
      </h1>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-10 left-0 w-full text-center">
            <img
                src="https://enodia-software.de/wp-content/uploads/2023/04/enodia-logo-white.png"
                width="350"
                height="120"
                alt="Enodia Software"
                class="mx-auto mt-4"
            />
            <div id="footer-info" class="font-bold text-2xl text-white">
                Enodia Software 2025
            </div>
        </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
