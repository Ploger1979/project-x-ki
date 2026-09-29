<template>
    <AppLayout>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h1 class="text-3xl font-bold text-blue-800 underline decoration-blue-800 decoration-2 underline-offset-4 tracking-tight">
                Ticket-Liste
            </h1>

            <!-- Instant Search Input -->
            <div class="relative w-full sm:w-72">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Ticket suchen..."
                    class="w-full bg-white/90 border border-blue-200 rounded-lg pl-9 pr-4 py-2 text-sm text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-2xs backdrop-blur-xs"
                />
                <svg class="w-4 h-4 text-blue-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Tickets Table matching Screenshot style -->
        <div class="overflow-x-auto rounded-lg shadow-xs border border-blue-200/80 bg-[#e4effc]/70 backdrop-blur-xs">
            <table
                v-if="gefilterteTickets && gefilterteTickets.length"
                class="min-w-full text-left table-auto border-collapse"
            >
                <thead class="bg-[#d5e6fb] text-sm text-blue-900 border-b border-blue-200/80">
                    <tr>
                        <th class="py-3 px-5 font-bold w-16">ID</th>
                        <th class="py-3 px-5 font-bold">Titel</th>
                        <th class="py-3 px-5 font-bold">Beschreibung</th>
                        <th class="py-3 px-5 font-bold">Status</th>
                        <th class="py-3 px-5 font-bold">Kunde</th>
                        <th class="py-3 px-5 font-bold">Datum</th>
                        <th class="py-3 px-5 font-bold text-right">Aktion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-200/60 font-medium text-sm">
                    <tr
                        v-for="ticket in gefilterteTickets"
                        :key="ticket.id"
                        class="hover:bg-blue-100/60 transition-colors duration-150"
                    >
                        <td class="py-2.5 px-5 text-gray-800 font-bold">{{ ticket.id }}</td>
                        <td class="py-2.5 px-5 text-gray-900 font-semibold">{{ ticket.title }}</td>
                        <td class="py-2.5 px-5 text-gray-700 max-w-xs truncate">{{ ticket.description }}</td>
                        <td class="py-2.5 px-5">
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
                        <td class="py-2.5 px-5">
                            <span class="text-gray-900 font-medium">{{ ticket.kunde ? ticket.kunde.name : "Unbekannt" }}</span>
                            <span
                                v-if="ticket.kunde"
                                class="block text-xs text-gray-500"
                            >{{ ticket.kunde.email }}</span>
                        </td>
                        <td class="py-2.5 px-5 text-gray-700 whitespace-nowrap text-xs">{{ ticket.date }}</td>
                        <td class="py-2.5 px-5 text-right whitespace-nowrap">
                            <Link 
                                :href="`/tickets/analyse?ticket_id=${ticket.id}`"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 hover:text-blue-900 bg-white/80 hover:bg-white px-3 py-1 rounded-md border border-blue-200 transition shadow-2xs"
                            >
                                <span>🤖 Analysieren</span>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="text-gray-500 p-8 text-center font-medium">
                Keine Tickets gefunden{{ searchQuery ? ` für "${searchQuery}"` : '' }}.
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ tickets: Array });
const searchQuery = ref("");

const gefilterteTickets = computed(() => {
    if (!props.tickets) return [];
    if (!searchQuery.value) return props.tickets;
    const q = searchQuery.value.toLowerCase();
    return props.tickets.filter(
        (t) =>
            t.title.toLowerCase().includes(q) ||
            t.description.toLowerCase().includes(q) ||
            (t.kunde && t.kunde.name.toLowerCase().includes(q)) ||
            String(t.id).includes(q)
    );
});
</script>
