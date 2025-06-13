<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md p-6 bg-white rounded shadow">
            <img
                src="https://enodia-software.de/wp-content/uploads/2023/04/enodia-logo-white.png"
                width="350"
                height="120"
                alt="Enodia Software"
                class="mx-auto mb-6 text-center text-gray-600"
            />
            <h2 class="text-2xl mb-6 text-center text-gray-600">Anmeldung</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700"
                        >E-Mail</label
                    >
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700"
                        >Passwort</label
                    >
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <div v-if="form.errors.email" class="text-red-600 text-sm mb-4">
                    {{ form.errors.email }}
                </div>

                <div class="text-right mt-2">
                    <a
                        href="/forgot-password"
                        class="text-blue-500 hover:underline"
                    >
                        Passwort vergessen?
                    </a>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                >
                    Einloggen
                </button>
            </form>
            <!-- ✅ Hier kommt der Link zur Registrierung -->
            <p class="mt-4 text-center text-sm">
                Noch kein Konto?
                <a href="/register" class="text-blue-600 hover:underline"
                    >Registrieren</a
                >
            </p>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
});

const submit = () => {
    form.post("/login");
};
</script>
