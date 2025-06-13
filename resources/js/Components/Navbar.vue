<template>
    <header class="bg-white border-b shadow-sm px-8 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-gray-800">KI-gestütztes Ticket-Management</h1>
      <button @click="logout" class="bg-blue-200 text-white px-4 py-2 rounded hover:bg-blue-600">Logout</button>
    </header>
  </template>

  <script setup>
  import { router } from '@inertiajs/vue3'
  function logout() {
    router.post('/logout')
  }
  </script>
