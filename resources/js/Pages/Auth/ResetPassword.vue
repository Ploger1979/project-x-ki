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
            <h2 class="text-2xl mb-6 text-center text-gray-600">
                Passwort zurücksetzen
            </h2>

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
                        autofocus
                        autocomplete="username"
                    />
                    <div
                        v-if="form.errors.email"
                        class="text-red-600 text-sm mt-2"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700"
                        >Neues Passwort</label
                    >
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        class="w-full px-3 py-2 border rounded"
                        autocomplete="new-password"
                    />
                    <div
                        v-if="form.errors.password"
                        class="text-red-600 text-sm mt-2"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700"
                        >Passwort bestätigen</label
                    >
                    <input
                        v-model="form.password_confirmation"
                        type="password"
                        required
                        class="w-full px-3 py-2 border rounded"
                        autocomplete="new-password"
                    />
                    <div
                        v-if="form.errors.password_confirmation"
                        class="text-red-600 text-sm mt-2"
                    >
                        {{ form.errors.password_confirmation }}
                    </div>
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                    :disabled="form.processing"
                >
                    Passwort speichern
                </button>
            </form>
            <p class="mt-4 text-center text-sm">
                <a href="/login" class="text-blue-600 hover:underline"
                    >Zurück zur Anmeldung</a
                >
            </p>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
const props = defineProps({
    email: { type: String, required: true },
    token: { type: String, required: true },
});
const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});
const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>
