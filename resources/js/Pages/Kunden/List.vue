<template>
    <AppLayout>
        <h1 class="text-3xl font-bold mb-6 text-blue-800 underline">
            Kunden-Liste
        </h1>
        <div class="overflow-x-auto">
            <table
                v-if="kunden && kunden.length"
                class="min-w-full bg-white shadow-md rounded-lg overflow-hidden"
            >
                <thead class="bg-blue-100">
                    <tr>
                        <th class="py-3 px-5 text-left">ID</th>
                        <th class="py-3 px-5 text-left">Name</th>
                        <th class="py-3 px-5 text-left">E-Mail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="kunde in kunden"
                        :key="kunde.id"
                        class="hover:bg-blue-50"
                    >
                        <td class="py-2 px-5">{{ kunde.id }}</td>
                        <td class="py-2 px-5">{{ kunde.name }}</td>
                        <td class="py-2 px-5">{{ kunde.email }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="text-gray-500 mt-8">Keine Kunden gefunden.</div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
defineProps({ kunden: Array });
</script>
