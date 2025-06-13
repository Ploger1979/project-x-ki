<template>
    <AppLayout>
        <h1 class="text-3xl font-bold mb-6 text-blue-800 underline">
            Einstellungen
        </h1>

        <!-- Cards für Einstellungen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="p-6 bg-blue-100 rounded shadow">
                <h2 class="font-semibold mb-2">Aktuelles OpenAI Modell:</h2>
                <p class="text-lg text-blue-900">
                    {{ model || "Noch nicht geladen" }}
                </p>
            </div>
            <div class="p-6 bg-gray-100 rounded shadow">
                <h2 class="font-semibold mb-2">Benutzer:</h2>
                <p>{{ user?.name || user?.email || "Unbekannt" }}</p>
                <p v-if="user?.email && user?.name">{{ user.email }}</p>
            </div>
        </div>

        <!-- Aktionen -->
        <div class="flex gap-4 mb-6">
            <button
                @click="leereCache"
                class="bg-yellow-300 hover:bg-yellow-400 px-4 py-2 rounded shadow"
            >
                Cache leeren
            </button>
            <button
                @click="testVerbindung"
                class="bg-green-300 hover:bg-green-400 px-4 py-2 rounded shadow"
            >
                Test Verbindung
            </button>
        </div>

        <!-- Ergebnis / Fehler -->
        <div
            v-if="ergebnis"
            class="p-4 bg-green-100 text-green-900 rounded shadow mb-4"
        >
            {{ ergebnis }}
        </div>
        <div
            v-if="error"
            class="p-4 bg-red-100 text-red-900 rounded shadow mb-4"
        >
            {{ error }}
        </div>

        <!-- Aktivitäten-Log -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-2">Letzte Aktivitäten</h2>
            <table class="w-full bg-white rounded shadow">
                <tbody>
                    <tr v-for="(log, i) in logs" :key="i">
                        <td>{{ log.text }}</td>
                        <td class="text-right">{{ log.time }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import axios from "axios";

// احنا بناخد كل حاجة من الكنترولر كـ Props!
const props = defineProps({
    user: Object,
    logs: Array,
    model: String,
});

const ergebnis = ref('');
const error = ref('');

// Cache leeren
const leereCache = async () => {
    ergebnis.value = '';
    error.value = '';
    try {
        await axios.post("/api/settings/clear-cache");
        ergebnis.value = "✅ Cache erfolgreich geleert!";
    } catch (e) {
        error.value = "Fehler beim Leeren des Cache.";
    }
};

// Verbindung testen
const testVerbindung = async () => {
    ergebnis.value = '';
    error.value = '';
    try {
        const res = await axios.post("/api/settings/test-connection");
        if (res.data.message.includes("Fehler")) {
            ergebnis.value = "❌ Fehler beim Test der Verbindung!";
        } else {
            ergebnis.value = "✅ Verbindung erfolgreich getestet!";
        }
    } catch (e) {
        error.value = "Fehler beim Test der Verbindung.";
    }
};
</script>
