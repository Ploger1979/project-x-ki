<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
defineProps({ tickets: Array });
</script>

<template>
    <AppLayout>
        <h2 class="text-3xl font-bold mb-6 text-blue-800 underline">
            Ticket-Liste
        </h2>
        <div class="overflow-x-auto">
            <table
                v-if="tickets && tickets.length"
                class="min-w-full bg-white shadow rounded-lg"
            >
                <thead class="bg-blue-100">
                    <tr>
                        <th class="py-3 px-5 text-left">ID</th>
                        <th class="py-3 px-5 text-left">Titel</th>
                        <th class="py-3 px-5 text-left">Beschreibung</th>
                        <th class="py-3 px-5 text-left">Status</th>
                        <th class="py-3 px-5 text-left">Kunde</th>
                        <th class="py-3 px-5 text-left">Datum</th>
                        <th class="py-3 px-5 text-left">Uhrzeit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="ticket in tickets"
                        :key="ticket.id"
                        class="hover:bg-blue-50"
                    >
                        <td class="py-2 px-5">{{ ticket.id }}</td>
                        <td class="py-2 px-5">{{ ticket.title }}</td>
                        <td class="py-2 px-5">{{ ticket.description }}</td>
                        <td class="py-2 px-5">{{ ticket.status }}</td>
                        <td class="py-2 px-5">
                            {{ ticket.kunde ? ticket.kunde.name : "Unbekannt" }}
                            <span
                                v-if="ticket.kunde"
                                class="block text-xs text-gray-400"
                                >{{ ticket.kunde.email }}</span
                            >
                        </td>
                        <td class="py-2 px-5">{{ ticket.date }}</td>
                        <td class="py-2 px-5">{{ ticket.time }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="text-gray-500 mt-8">Keine Tickets gefunden.</div>
        </div>
    </AppLayout>
</template>
