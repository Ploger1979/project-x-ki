<template>
    <AppLayout>
        <h1 class="text-3xl font-bold mb-6 text-blue-800 underline">
            KI-Ticket-Analyse
        </h1>

        <!-- Auswahl Dropdown -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Ticket auswählen:</label>
            <select
                v-model="selectedTicketId"
                @change="zeigeTicketDetails"
                class="w-full border rounded px-2 py-1"
            >
                <option disabled value="">Bitte Ticket auswählen</option>
                <option
                    v-for="ticket in tickets"
                    :key="ticket.id"
                    :value="ticket.id"
                >
                    #{{ ticket.id }} - {{ ticket.title }}
                </option>
            </select>
        </div>

        <!-- Ticket Details -->
        <div v-if="selectedTicket" class="bg-blue-50 p-4 rounded shadow mb-4">
            <p><strong>ID:</strong> {{ selectedTicket.id }}</p>
            <p>
                <strong>Kunde:</strong>
                {{ selectedTicket.kunde?.name ?? "Unbekannt" }}
            </p>
            <p><strong>Betreff:</strong> {{ selectedTicket.title }}</p>
            <p>
                <strong>Beschreibung:</strong> {{ selectedTicket.description }}
            </p>
        </div>

        <!-- Button für automatische Analyse -->
        <button
            @click="analyseTicket"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
            :disabled="loading || !selectedTicket"
        >
            An OpenAI senden
        </button>

        <!-- Loading -->
        <div
            v-if="loading"
            class="flex items-center gap-2 mt-3 bg-yellow-100 px-4 py-2 rounded shadow"
        >
            <span class="animate-bounce text-xl">🤖</span>
            KI denkt nach...
        </div>

        <!-- Fehler mit Pilz-Effekt -->
        <transition name="pilz">
            <div
                v-if="error"
                class="mt-3 text-center font-semibold text-red-700 text-base"
            >
                {{ error }}
            </div>
        </transition>

        <!-- Antwort -->
        <div
            v-if="antwort"
            class="mt-4 bg-green-100 text-green-900 p-4 rounded shadow whitespace-pre-line"
        >
            <b>Antwort von OpenAI:</b>
            <div>{{ antwort }}</div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { ref, onMounted } from "vue";

const tickets = ref([]);
const selectedTicketId = ref("");
const selectedTicket = ref(null);

const antwort = ref("");
const loading = ref(false);
const error = ref("");

/** Lade alle Tickets beim Start */
const ladeTickets = async () => {
    try {
        const res = await axios.get("/api/tickets");
        if (res.data.success) {
            tickets.value = res.data.tickets;
        }
    } catch (e) {
        console.error(e);
    }
};

/** Zeige Details vom gewählten Ticket */
const zeigeTicketDetails = () => {
    selectedTicket.value = tickets.value.find(
        (t) => t.id === selectedTicketId.value
    );
};

/** Sende die Beschreibung des Tickets an OpenAI */
const analyseTicket = async () => {
    if (!selectedTicket.value) return;
    loading.value = true;
    error.value = "";
    antwort.value = "";

    try {
        const res = await axios.post("/api/tickets/generate-answer", {
            description: selectedTicket.value.description,
        });

        if (res.data.success) {
            antwort.value = res.data.answer;
        } else {
            error.value = "Fehler bei der OpenAI-Antwort.";
        }
    } catch (e) {
        error.value = "Fehler bei der Anfrage.";
        console.error(e);
    } finally {
        loading.value = false;
    }
};

// Beim Start → lade Tickets
onMounted(() => {
    ladeTickets();
});
</script>

<style>
.pilz-enter-active {
    animation: pilz-aufpoppen 0.4s cubic-bezier(0.36, 1.13, 0.5, 1.1);
}
@keyframes pilz-aufpoppen {
    0% {
        transform: scaleY(0.3) scaleX(0.9) translateY(50px);
        opacity: 0;
    }
    80% {
        transform: scaleY(1.08) scaleX(1.05) translateY(-3px);
        opacity: 1;
    }
    100% {
        transform: scaleY(1) scaleX(1) translateY(0);
        opacity: 1;
    }
}
</style>
