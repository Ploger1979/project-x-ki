<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    tickets: Array,
    letzteAktivitaeten: Array,
});

// Interactive Filter Feature (Trick: Click a card to filter table)
const activeFilter = ref("all");

const setFilter = (filter) => {
    if (activeFilter.value === filter) {
        activeFilter.value = "all";
    } else {
        activeFilter.value = filter;
    }
};

const gefilterteTickets = computed(() => {
    if (!props.tickets) return [];
    if (activeFilter.value === "all") {
        return props.tickets.slice(0, 8);
    }
    if (activeFilter.value === "offen") {
        return props.tickets.filter((t) => t.status === "offen").slice(0, 8);
    }
    if (activeFilter.value === "in_bearbeitung") {
        return props.tickets.filter((t) => t.status === "in_bearbeitung" || t.status === "in_progress").slice(0, 8);
    }
    if (activeFilter.value === "geschlossen") {
        return props.tickets.filter((t) => t.status === "geschlossen").slice(0, 8);
    }
    return props.tickets.slice(0, 8);
});
</script>

<template>
    <AppLayout>
        <!-- Page Title matching Screenshot 2 -->
        <h1 class="text-3xl font-bold mb-3 text-blue-800 underline decoration-blue-800 decoration-2 underline-offset-4 tracking-tight">
            Dashboard
        </h1>
        <p class="text-gray-800 font-semibold mb-6 text-sm md:text-base">
            Willkommen zum Project-X Dashboard. Hier sehen Sie eine Übersicht der aktuellen Tickets und Systemstatistiken.
        </p>

        <!-- 4 Stat Cards matching Screenshot 2 colors and layout (Clickable to Filter!) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <!-- 🔵 Total Tickets (Soft Blue) -->
            <div 
                @click="setFilter('all')"
                :class="[
                    'bg-[#b9d6fd] border border-blue-300 p-5 rounded-lg shadow-xs text-center cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:shadow-md select-none',
                    activeFilter === 'all' ? 'ring-2 ring-blue-600 scale-[1.02]' : 'opacity-95'
                ]"
            >
                <h2 class="text-lg md:text-xl font-bold text-blue-900">Total Tickets</h2>
                <p class="text-3xl md:text-4xl font-black text-gray-900 mt-2">{{ tickets?.length ?? 0 }}</p>
                <span class="text-xs text-blue-800/80 font-medium block mt-1">Alle Tickets anzeigen</span>
            </div>

            <!-- 🟢 Offene Tickets (Soft Green) -->
            <div 
                @click="setFilter('offen')"
                :class="[
                    'bg-[#bbf7d0] border border-green-300 p-5 rounded-lg shadow-xs text-center cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:shadow-md select-none',
                    activeFilter === 'offen' ? 'ring-2 ring-emerald-600 scale-[1.02]' : 'opacity-95'
                ]"
            >
                <h2 class="text-lg md:text-xl font-bold text-green-950">Offene Tickets</h2>
                <p class="text-3xl md:text-4xl font-black text-gray-900 mt-2">
                    {{ tickets?.filter((t) => t.status === "offen").length ?? 0 }}
                </p>
                <span class="text-xs text-emerald-800/80 font-medium block mt-1">Klicken zum Filtern</span>
            </div>

            <!-- 🟡 In Bearbeitung (Soft Yellow) -->
            <div 
                @click="setFilter('in_bearbeitung')"
                :class="[
                    'bg-[#fef08a] border border-yellow-300 p-5 rounded-lg shadow-xs text-center cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:shadow-md select-none',
                    activeFilter === 'in_bearbeitung' ? 'ring-2 ring-amber-500 scale-[1.02]' : 'opacity-95'
                ]"
            >
                <h2 class="text-lg md:text-xl font-bold text-amber-950">In Bearbeitung</h2>
                <p class="text-3xl md:text-4xl font-black text-gray-900 mt-2">
                    {{ tickets?.filter((t) => t.status === "in_bearbeitung" || t.status === "in_progress").length ?? 0 }}
                </p>
                <span class="text-xs text-amber-800/80 font-medium block mt-1">Klicken zum Filtern</span>
            </div>

            <!-- 🔴 Geschlossene Tickets (Soft Red) -->
            <div 
                @click="setFilter('geschlossen')"
                :class="[
                    'bg-[#fecdd3] border border-red-300 p-5 rounded-lg shadow-xs text-center cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:shadow-md select-none',
                    activeFilter === 'geschlossen' ? 'ring-2 ring-rose-500 scale-[1.02]' : 'opacity-95'
                ]"
            >
                <h2 class="text-lg md:text-xl font-bold text-rose-950">Geschlossene Tickets</h2>
                <p class="text-3xl md:text-4xl font-black text-gray-900 mt-2">
                    {{ tickets?.filter((t) => t.status === "geschlossen").length ?? 0 }}
                </p>
                <span class="text-xs text-rose-800/80 font-medium block mt-1">Klicken zum Filtern</span>
            </div>
        </div>

        <!-- Neueste Tickets Table matching Screenshot 2 with Watermark visibility -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-bold text-blue-900 tracking-tight">
                    Neueste Tickets
                    <span v-if="activeFilter !== 'all'" class="text-sm font-normal text-blue-700 ml-2">
                        (Filter: {{ activeFilter }})
                    </span>
                </h2>
                <button 
                    v-if="activeFilter !== 'all'"
                    @click="activeFilter = 'all'"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-800 underline cursor-pointer"
                >
                    Filter zurücksetzen
                </button>
            </div>

            <div class="overflow-x-auto rounded-lg shadow-xs border border-blue-200/80 bg-[#e4effc]/70 backdrop-blur-xs">
                <table class="w-full text-left table-auto border-collapse">
                    <thead class="bg-[#d5e6fb] text-sm uppercase text-blue-900 border-b border-blue-200/80">
                        <tr>
                            <th class="py-3 px-5 font-bold">ID</th>
                            <th class="py-3 px-5 font-bold">KUNDE</th>
                            <th class="py-3 px-5 font-bold">BETREFF</th>
                            <th class="py-3 px-5 font-bold">STATUS</th>
                            <th class="py-3 px-5 font-bold text-right">AKTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-200/60 font-medium text-sm">
                        <tr
                            v-for="ticket in gefilterteTickets"
                            :key="ticket.id"
                            class="hover:bg-blue-100/60 transition-colors duration-150"
                        >
                            <td class="py-3 px-5 text-gray-800 font-bold">{{ ticket.id }}</td>
                            <td class="py-3 px-5 text-gray-900">{{ ticket.kunde?.name ?? "Unbekannt" }}</td>
                            <td class="py-3 px-5 text-gray-800">{{ ticket.title }}</td>
                            <td class="py-3 px-5">
                                <span 
                                    class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold"
                                    :class="{
                                        'text-emerald-800 bg-emerald-100/90 border border-emerald-300': ticket.status === 'offen',
                                        'text-amber-800 bg-amber-100/90 border border-amber-300': ticket.status === 'in_bearbeitung' || ticket.status === 'in_progress',
                                        'text-rose-800 bg-rose-100/90 border border-rose-300': ticket.status === 'geschlossen'
                                    }"
                                >
                                    {{ ticket.status }}
                                </span>
                            </td>
                            <td class="py-3 px-5 text-right">
                                <Link 
                                    :href="`/tickets/analyse?ticket_id=${ticket.id}`"
                                    class="inline-flex items-center gap-1 text-xs font-bold text-blue-700 hover:text-blue-900 bg-white/70 hover:bg-white px-2.5 py-1 rounded border border-blue-200 transition-colors shadow-2xs"
                                    title="Mit KI analysieren"
                                >
                                    <span>🤖 KI-Analyse</span>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Letzte Aktivitäten -->
        <div class="bg-white/70 border border-slate-200/80 rounded-xl p-5 shadow-xs backdrop-blur-xs">
            <h2 class="text-xl font-bold mb-3 text-blue-900 tracking-tight">Letzte Aktivitäten</h2>
            <ul class="divide-y divide-gray-100 text-gray-700 text-sm">
                <li
                    v-for="(log, idx) in letzteAktivitaeten"
                    :key="idx"
                    class="py-2.5 flex items-center gap-2"
                >
                    <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                    <span v-html="log"></span>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
