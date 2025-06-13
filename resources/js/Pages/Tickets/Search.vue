<template>
    <AppLayout>
      <h1 class="text-2xl font-bold mb-4">Tickets suchen</h1>
      <form @submit.prevent="doSearch" class="mb-4 flex gap-2">
        <input v-model="query" type="text" placeholder="Suchbegriff..." class="flex-1 px-2 py-1 border rounded"/>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-800">Suchen</button>
      </form>
      <div v-if="loading" class="text-gray-500">Sucht...</div>
      <div v-if="error" class="text-red-600">{{ error }}</div>
      <table v-if="!loading && tickets.length" class="min-w-full border text-left bg-white rounded shadow">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-3 py-2">ID</th>
            <th class="px-3 py-2">Titel</th>
            <th class="px-3 py-2">Beschreibung</th>
            <th class="px-3 py-2">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets" :key="ticket.id" class="hover:bg-gray-100">
            <td class="px-3 py-2">{{ ticket.id }}</td>
            <td class="px-3 py-2">{{ ticket.title }}</td>
            <td class="px-3 py-2">{{ ticket.description }}</td>
            <td class="px-3 py-2">{{ ticket.status }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else-if="!loading && query" class="text-gray-500">Keine Ergebnisse.</div>
    </AppLayout>
  </template>

  <script setup>
  import AppLayout from '../../Layouts/AppLayout.vue'
  import { ref } from "vue";
  import axios from "axios";

  const query = ref("");
  const tickets = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const doSearch = async () => {
      if (!query.value) return;
      loading.value = true;
      error.value = null;
      try {
          const response = await axios.get("/api/tickets/search", {
              params: { query: query.value },
          });
          if (response.data.success) {
              tickets.value = response.data.tickets;
          }
      } catch (err) {
          error.value = "Fehler beim Suchen!";
      } finally {
          loading.value = false;
      }
  };
  </script>
