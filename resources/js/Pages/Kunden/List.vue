<template>
    <AppLayout>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h1 class="text-3xl font-bold text-blue-800 underline decoration-blue-800 decoration-2 underline-offset-4 tracking-tight">
                Kunden-Liste
            </h1>

            <!-- Instant Search Input (Cool Trick) -->
            <div class="relative w-full sm:w-72">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Kunde oder E-Mail suchen..."
                    class="w-full bg-white/90 border border-blue-200 rounded-lg pl-9 pr-4 py-2 text-sm text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-2xs backdrop-blur-xs"
                />
                <svg class="w-4 h-4 text-blue-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Kunden Table matching Screenshot 3 -->
        <div class="overflow-x-auto rounded-lg shadow-xs border border-blue-200/80 bg-[#e4effc]/70 backdrop-blur-xs">
            <table
                v-if="gefilterteKunden && gefilterteKunden.length"
                class="min-w-full text-left table-auto border-collapse"
            >
                <thead class="bg-[#d5e6fb] text-sm text-blue-900 border-b border-blue-200/80">
                    <tr>
                        <th class="py-3 px-5 font-bold w-20">ID</th>
                        <th class="py-3 px-5 font-bold">Name</th>
                        <th class="py-3 px-5 font-bold">E-Mail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-200/60 font-medium text-sm">
                    <tr
                        v-for="kunde in gefilterteKunden"
                        :key="kunde.id"
                        class="hover:bg-blue-100/60 transition-colors duration-150"
                    >
                        <td class="py-2.5 px-5 text-gray-800 font-bold">{{ kunde.id }}</td>
                        <td class="py-2.5 px-5 text-gray-900">{{ kunde.name }}</td>
                        <td class="py-2.5 px-5 text-gray-700">
                            <a :href="`mailto:${kunde.email}`" class="hover:text-blue-700 hover:underline">
                                {{ kunde.email }}
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="text-gray-500 p-8 text-center font-medium">
                Keine Kunden gefunden{{ searchQuery ? ` für "${searchQuery}"` : '' }}.
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ kunden: Array });
const searchQuery = ref("");

const gefilterteKunden = computed(() => {
    if (!props.kunden) return [];
    if (!searchQuery.value) return props.kunden;
    const q = searchQuery.value.toLowerCase();
    return props.kunden.filter(
        (k) =>
            k.name.toLowerCase().includes(q) ||
            k.email.toLowerCase().includes(q) ||
            String(k.id).includes(q)
    );
});
</script>
