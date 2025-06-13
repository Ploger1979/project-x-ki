<template>
    <aside
        class="bg-blue-100 w-64 min-h-screen p-6 flex flex-col gap-6 shadow-lg"
    >
        <div class="flex items-center gap-2 mb-8">
            <span class="text-4xl font-extrabold text-blue-700 underline"
                ><strong>Project-X</strong></span
            >
        </div>
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <Link
                        href="/dashboard"
                        class="flex items-center gap-2 px-4 py-3 rounded-lg hover:bg-blue-200 font-semibold"
                    >
                        <HomeIcon class="h-5 w-5 text-blue-600" /> Dashboard
                    </Link>
                </li>
                <li>
                    <Link
                        href="/tickets/list"
                        class="flex items-center gap-2 px-4 py-3 rounded-lg hover:bg-blue-200 font-semibold"
                    >
                        <ClipboardDocumentCheckIcon
                            class="h-5 w-5 text-blue-600"
                        />
                        Tickets
                    </Link>
                </li>
                <li>
                    <Link
                        href="/kunden/list"
                        class="flex items-center gap-2 px-4 py-3 rounded-lg hover:bg-blue-200 font-semibold"
                    >
                        <UsersIcon class="h-5 w-5 text-blue-600" /> Kunden
                    </Link>
                </li>
                <li>
                    <Link
                        href="/tickets/analyse"
                        class="flex items-center gap-2 px-4 py-3 rounded-lg hover:bg-blue-200 font-semibold"
                    >
                        <MagnifyingGlassIcon class="h-5 w-5 text-blue-600" />
                        KI-Ticket-Analyse
                    </Link>
                </li>
                <li>
                    <Link
                        href="/settings"
                        class="flex items-center gap-2 px-4 py-3 rounded-lg hover:bg-blue-200 font-semibold"
                    >
                        <Cog6ToothIcon class="h-5 w-5 text-blue-600" />
                        Einstellungen
                    </Link>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import {
    HomeIcon,
    ClipboardDocumentCheckIcon,
    UsersIcon,
    MagnifyingGlassIcon,
    ChatBubbleOvalLeftEllipsisIcon,
    Cog6ToothIcon,
} from "@heroicons/vue/24/outline";
</script>
