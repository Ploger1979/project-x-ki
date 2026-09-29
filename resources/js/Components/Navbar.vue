<template>
    <header class="bg-white border-b border-gray-200/80 px-8 py-3.5 flex justify-between items-center shadow-xs">
        <h1 class="text-xl font-bold text-gray-800 tracking-tight">
            KI-gestütztes Ticket-Management
        </h1>
        <div class="flex items-center gap-4">
            <button 
                @click="logout" 
                class="bg-blue-200 hover:bg-blue-300 text-white font-semibold px-5 py-1.5 rounded-lg transition-all duration-150 text-sm shadow-xs active:scale-95 cursor-pointer"
            >
                Logout
            </button>
        </div>
    </header>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
function logout() {
    router.post('/logout')
}
</script>
