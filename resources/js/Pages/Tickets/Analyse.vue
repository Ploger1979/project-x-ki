<template>
    <AppLayout>
        <!-- Page Title matching Screenshot 4 & 5 -->
        <h1 class="text-3xl font-bold mb-6 text-blue-800 underline decoration-blue-800 decoration-2 underline-offset-4 tracking-tight">
            KI-Ticket-Analyse
        </h1>

        <!-- Auswahl Dropdown -->
        <div class="mb-5 max-w-4xl">
            <label class="block mb-2 font-bold text-gray-800 text-sm">Ticket auswählen:</label>
            <div class="relative">
                <select
                    v-model="selectedTicketId"
                    @change="zeigeTicketDetails"
                    class="w-full bg-white border border-gray-300 text-gray-800 rounded-lg px-4 py-2.5 shadow-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition cursor-pointer"
                >
                    <option disabled value="">Bitte Ticket auswählen</option>
                    <option
                        v-for="ticket in verfuegbareTickets"
                        :key="ticket.id"
                        :value="ticket.id"
                    >
                        #{{ ticket.id }} - {{ ticket.title }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Ticket Details Box matching Screenshot 4 & 5 -->
        <div v-if="selectedTicket" class="max-w-4xl bg-[#e4effc]/80 border border-blue-200/90 p-5 rounded-xl shadow-xs mb-5 backdrop-blur-xs transition-all duration-200">
            <div class="space-y-2 text-sm md:text-base text-gray-800">
                <p><span class="font-bold text-gray-900">ID:</span> {{ selectedTicket.id }}</p>
                <p>
                    <span class="font-bold text-gray-900">Kunde:</span>
                    <span class="text-gray-700 ml-1">{{ selectedTicket.kunde?.name ?? "Unbekannt" }}</span>
                </p>
                <p><span class="font-bold text-gray-900">Betreff:</span> {{ selectedTicket.title }}</p>
                <p>
                    <span class="font-bold text-gray-900">Beschreibung:</span> 
                    <span class="text-gray-700 ml-1">{{ selectedTicket.description }}</span>
                </p>
            </div>
        </div>

        <!-- Button: An OpenAI senden -->
        <div class="mb-5 flex flex-wrap items-center gap-3">
            <button
                @click="analyseTicket"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow-xs hover:shadow transition-all duration-150 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95 cursor-pointer"
                :disabled="loading || !selectedTicket"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>An OpenAI senden</span>
            </button>

            <!-- Quick copy or save actions if answer exists -->
            <button
                v-if="antwort"
                @click="kopiereAntwort"
                class="inline-flex items-center gap-1.5 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-4 py-2.5 rounded-lg border border-gray-300 shadow-2xs transition active:scale-95 text-sm cursor-pointer"
            >
                <svg v-if="!kopiert" class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                </svg>
                <svg v-else class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ kopiert ? 'Kopiert! ✓' : 'Lösung kopieren' }}</span>
            </button>
        </div>

        <!-- Loading State: 🤖 KI denkt nach... (matching Screenshot 5) -->
        <div
            v-if="loading"
            class="max-w-4xl flex items-center gap-3 bg-yellow-100/95 border border-yellow-300 text-yellow-950 px-5 py-3.5 rounded-lg shadow-xs mb-5 animate-pulse"
        >
            <span class="text-2xl animate-bounce">🤖</span>
            <span class="font-medium text-base">KI denkt nach...</span>
        </div>

        <!-- Error Alert -->
        <div
            v-if="error"
            class="max-w-4xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg font-semibold text-sm mb-5"
        >
            {{ error }}
        </div>

        <!-- Antwort Box matching Screenshot 4 -->
        <div
            v-if="antwort"
            class="max-w-4xl relative bg-[#d1fae5]/90 border border-emerald-300 text-emerald-950 p-6 rounded-xl shadow-xs whitespace-pre-line leading-relaxed backdrop-blur-xs transition-all duration-300"
        >
            <div class="flex items-center justify-between mb-4 border-b border-emerald-200/80 pb-3">
                <span class="font-bold text-lg text-emerald-950 flex items-center gap-2">
                    <span class="text-xl">✨</span> Antwort von OpenAI:
                </span>
                <span class="text-xs bg-emerald-200/80 text-emerald-900 font-bold px-3 py-1 rounded-full">
                    GPT-4o KI-Analyse
                </span>
            </div>
            
            <div class="text-sm md:text-base text-gray-900 font-sans" v-html="formatResponse(antwort)"></div>

            <!-- Subtle AI watermark badge in bottom right corner (Screenshot 4) -->
            <div class="mt-6 flex justify-end">
                <div class="inline-flex items-center gap-1.5 text-xs text-emerald-800/80 bg-emerald-100/80 px-2.5 py-1 rounded-md border border-emerald-300/60">
                    <span class="text-base">🤖</span>
                    <span>KI-Ticket-Assistent</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    tickets: Array
});

const ticketsList = ref([]);
const selectedTicketId = ref("");
const selectedTicket = ref(null);

const antwort = ref("");
const loading = ref(false);
const error = ref("");
const kopiert = ref(false);

const verfuegbareTickets = computed(() => {
    return ticketsList.value.length ? ticketsList.value : (props.tickets || []);
});

/** Lade alle Tickets beim Start & prüfe URL-Query */
const ladeTickets = async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const queryTicketId = urlParams.get('ticket_id');

    if (props.tickets && props.tickets.length) {
        ticketsList.value = props.tickets;
        applyInitialTicket(queryTicketId);
        return;
    }

    try {
        const res = await axios.get("/api/tickets");
        if (res.data.success) {
            ticketsList.value = res.data.tickets;
            applyInitialTicket(queryTicketId);
        }
    } catch (e) {
        console.error(e);
    }
};

const applyInitialTicket = (targetId) => {
    let ticket = null;
    if (targetId) {
        ticket = ticketsList.value.find(t => String(t.id) === String(targetId));
    }
    if (!ticket) {
        // Preselect ticket #3 or #2 matching screenshot 4 & 5
        ticket = ticketsList.value.find(t => t.id === 3) || ticketsList.value.find(t => t.id === 2) || ticketsList.value[0];
    }
    if (ticket) {
        selectedTicketId.value = ticket.id;
        selectedTicket.value = ticket;
        if (ticket.ai_response) {
            antwort.value = ticket.ai_response;
        }
    }
};

/** Zeige Details vom gewählten Ticket */
const zeigeTicketDetails = () => {
    selectedTicket.value = verfuegbareTickets.value.find(
        (t) => t.id === Number(selectedTicketId.value) || t.id === selectedTicketId.value
    );
    if (selectedTicket.value && selectedTicket.value.ai_response) {
        antwort.value = selectedTicket.value.ai_response;
    } else {
        antwort.value = "";
    }
};

/** Format bold markdown into clean html tags */
const formatResponse = (text) => {
    if (!text) return "";
    return text
        .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-gray-950">$1</strong>')
        .replace(/\n/g, '<br />');
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

/** Kopiere Lösung in Zwischenablage */
const kopiereAntwort = () => {
    if (!antwort.value) return;
    navigator.clipboard.writeText(antwort.value);
    kopiert.value = true;
    setTimeout(() => {
        kopiert.value = false;
    }, 2500);
};

onMounted(() => {
    ladeTickets();
});
</script>
