<template>
    <div class="flex min-h-screen bg-slate-50/80 relative overflow-x-hidden font-sans">
        <!-- Watermark Background Logo (Centered in content area behind tables) -->
        <div class="fixed inset-0 pointer-events-none z-0 flex items-center justify-center lg:pl-64">
            <img 
                src="/images/project-x-bg.png" 
                alt="Project-X Background"
                class="w-[680px] max-w-[85vw] max-h-[85vh] object-contain opacity-20 select-none transition-opacity duration-300"
            />
        </div>

        <!-- Sidebar -->
        <Sidebar class="relative z-20 shrink-0" />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col relative z-10 min-w-0">
            <Navbar />
            <main class="flex-1 p-6 md:p-10">
                <slot />
            </main>
        </div>
    </div>
</template>

  <script setup>
  import Sidebar from '../Components/Sidebar.vue'
  import Navbar from '../Components/Navbar.vue'
  </script>
