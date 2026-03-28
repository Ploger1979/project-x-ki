<template>
    <AppLayout>
      <h1 class="text-3xl font-bold mb-6 text-blue-800 underline">
  KI-Suche(<span class="text-black">OpenAI</span>)
</h1>
      <form @submit.prevent="frageAbsenden" class="mb-4 flex gap-2">
        <input v-model="frage" type="text" placeholder="Was möchten Sie wissen?" class="flex-1 px-2 py-1 border rounded"/>
        <button type="submit" class="bg-blue-200 text-white px-6 py-2 rounded hover:bg-blue-600">Suchen</button>
      </form>
      <div v-if="loading" class="text-gray-500">KI denkt nach...</div>
      <div v-if="error" class="text-red-600">{{ error }}</div>
      <div v-if="antwort" class="mt-4 bg-green-100 text-green-900 p-3 rounded shadow">
        <b>Antwort von OpenAI:</b>
        <div>{{ antwort }}</div>
      </div>
    </AppLayout>
  </template>

  <script setup>
  import AppLayout from '../../Layouts/AppLayout.vue'
  import { ref } from "vue";
  import axios from "axios";

  const frage = ref("");
  const antwort = ref("");
  const loading = ref(false);
  const error = ref(null);

  const frageAbsenden = async () => {
    if (!frage.value) return;
    loading.value = true;
    error.value = null;
    antwort.value = "";
    try {
      const res = await axios.post("/api/tickets/generate-answer", {
        description: frage.value
      });
      if (res.data.success) {
        antwort.value = res.data.answer;
      }
    } catch (e) {
      error.value = "Fehler bei OpenAI!";
    } finally {
      loading.value = false;
    }
  };
  </script>
