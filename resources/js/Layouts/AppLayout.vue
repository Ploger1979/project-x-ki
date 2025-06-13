<template>
    <div class="flex min-h-screen bg-gray-50">
      <img 
      src="/images/project-x-bg.png" 
      alt="Project-X Logo"
      class="fixed top-0 left-0 w-full h-full object-contain opacity-15 pointer-events-none"
      style="z-index:0;"
    />
      <Sidebar />
      <div class="flex-1 flex flex-col">
        <Navbar />
        <main class="flex-1 p-10">
          <slot />
        </main>
      </div>
    </div>
  </template>

  <script setup>
  import Sidebar from '../Components/Sidebar.vue'
  import Navbar from '../Components/Navbar.vue'
  </script>
