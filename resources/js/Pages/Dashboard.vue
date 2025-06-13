<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
defineProps({
    tickets: Array,
    letzteAktivitaeten: Array,
});
</script>

<template>
    <AppLayout>
        <h1 class="text-3xl font-bold mb-6 text-blue-800 underline">
            Dashboard
        </h1>
        <p class="text-gray-800 font-semibold mb-4">
            Willkommen zum Project-X Dashboard. Hier sehen Sie eine Übersicht
            der aktuellen Tickets und Systemstatistiken.
        </p>

        <!-- Cards Bereich -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- 🟢 Total Tickets -->
            <div class="bg-blue-200 p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold text-blue-800">Total Tickets</h2>
                <p class="text-3xl mt-2">{{ tickets.length }}</p>
            </div>

            <!-- 🟢 Open Tickets -->
            <div class="bg-green-200 p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold text-green-800">Offene Tickets</h2>
                <p class="text-3xl mt-2">
                    {{ tickets.filter((t) => t.status === "offen").length }}
                </p>
            </div>

            <!-- 🟡 In Progress Tickets -->
            <div class="bg-yellow-200 p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold text-yellow-800">
                    In Bearbeitung
                </h2>
                <p class="text-3xl mt-2">
                    {{
                        tickets.filter((t) => t.status === "in_progress").length
                    }}
                </p>
            </div>

            <!-- 🔴 Closed Tickets -->
            <div class="bg-red-200 p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold text-red-800">
                    Geschlossene Tickets
                </h2>
                <p class="text-3xl mt-2">
                    {{
                        tickets.filter((t) => t.status === "geschlossen").length
                    }}
                </p>
            </div>
        </div>

        <!-- Letzte 5 Tickets -->
        <h2 class="text-xl font-bold mb-2 text-blue-800">Neueste Tickets</h2>
        <table
            class="w-full text-left table-auto border-collapse text-blue-600 bg-blue-100 rounded mb-6"
        >
            <thead class="bg-blue-100 text-sm uppercase">
                <tr>
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Kunde</th>
                    <th class="p-3 border-b">Betreff</th>
                    <th class="p-3 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="ticket in tickets.slice(0, 5)"
                    :key="ticket.id"
                    class="hover:bg-gray-50 text-sm"
                >
                    <td class="p-3 border-b">{{ ticket.id }}</td>
                    <td class="p-3 border-b">{{ ticket.kunde?.name }}</td>
                    <!-- هنا 👈 هيظهر اسم العميل -->
                    <td class="p-3 border-b">{{ ticket.title }}</td>
                    <!-- هنا 👈 هيظهر عنوان التذكرة -->
                    <td class="p-3 border-b">{{ ticket.status }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Letzte Aktivitäten (Dummy Logs) -->
        <h2 class="text-xl font-bold mb-2 text-blue-800">Letzte Aktivitäten</h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li
                v-for="(log, idx) in letzteAktivitaeten"
                :key="idx"
                v-html="log"
            ></li>
        </ul>
    </AppLayout>
</template>
