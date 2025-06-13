<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md p-6 bg-white rounded shadow">
            <!-- لوجو الشركة فوق -->
            <img
                src="https://enodia-software.de/wp-content/uploads/2023/04/enodia-logo-white.png"
                width="350"
                height="120"
                alt="Enodia Software"
                class="mx-auto mb-6 text-center text-gray-600"
            />
            <h2 class="text-2xl mb-6 text-center text-gray-600">Passwort vergessen</h2>
            <div class="mb-4 text-sm text-gray-600 text-center">
                Passwort vergessen? Gib deine E-Mail-Adresse ein. Du bekommst einen Link zum Zurücksetzen des Passworts.
            </div>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">E-Mail</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        class="w-full px-3 py-2 border rounded"
                        autofocus
                        autocomplete="username"
                    />
                    <div v-if="form.errors.email" class="text-red-600 text-sm mt-2">
                        {{ form.errors.email }}
                    </div>
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                    :disabled="form.processing"
                >
                    Passwort-Reset-Link senden
                </button>
            </form>
            <!-- Link zurück zum Login -->
            <p class="mt-4 text-center text-sm">
                <a href="/login" class="text-blue-600 hover:underline">Zurück zur Anmeldung</a>
            </p>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
const props = defineProps({
    status: { type: String, default: "" },
});
const form = useForm({
    email: '',
});
const submit = () => {
    form.post(route('password.email'));
};
</script>