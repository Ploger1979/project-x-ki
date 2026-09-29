<template>
    <aside
        class="bg-[#e4effc] w-64 min-h-screen p-6 flex flex-col gap-6 shadow-sm border-r border-blue-200/60"
    >
        <!-- Logo matching Screenshot 2: Project-X with blue underline -->
        <div class="flex items-center gap-2 mb-6 pt-2">
            <Link href="/dashboard" class="group">
                <span class="text-3xl font-black text-blue-700 underline decoration-blue-700 decoration-3 underline-offset-4 tracking-tight group-hover:text-blue-800 transition-colors">
                    Project-X
                </span>
            </Link>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <Link
                        href="/dashboard"
                        :class="[
                            'flex items-center gap-3 px-4 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150',
                            isActive('/dashboard')
                                ? 'bg-blue-200/90 text-blue-900 shadow-sm'
                                : 'text-gray-700 hover:bg-blue-200/50 hover:text-blue-900'
                        ]"
                    >
                        <HomeIcon class="h-5 w-5 text-blue-600" />
                        <span>Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/tickets/list"
                        :class="[
                            'flex items-center gap-3 px-4 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150',
                            isActive('/tickets/list')
                                ? 'bg-blue-200/90 text-blue-900 shadow-sm'
                                : 'text-gray-700 hover:bg-blue-200/50 hover:text-blue-900'
                        ]"
                    >
                        <ClipboardDocumentCheckIcon class="h-5 w-5 text-blue-600" />
                        <span>Tickets</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/kunden/list"
                        :class="[
                            'flex items-center gap-3 px-4 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150',
                            isActive('/kunden/list')
                                ? 'bg-blue-200/90 text-blue-900 shadow-sm'
                                : 'text-gray-700 hover:bg-blue-200/50 hover:text-blue-900'
                        ]"
                    >
                        <UsersIcon class="h-5 w-5 text-blue-600" />
                        <span>Kunden</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/tickets/analyse"
                        :class="[
                            'flex items-center gap-3 px-4 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150',
                            isActive('/tickets/analyse')
                                ? 'bg-blue-200/90 text-blue-900 shadow-sm'
                                : 'text-gray-700 hover:bg-blue-200/50 hover:text-blue-900'
                        ]"
                    >
                        <MagnifyingGlassIcon class="h-5 w-5 text-blue-600" />
                        <span>KI-Ticket-Analyse</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/settings"
                        :class="[
                            'flex items-center gap-3 px-4 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150',
                            isActive('/settings')
                                ? 'bg-blue-200/90 text-blue-900 shadow-sm'
                                : 'text-gray-700 hover:bg-blue-200/50 hover:text-blue-900'
                        ]"
                    >
                        <Cog6ToothIcon class="h-5 w-5 text-blue-600" />
                        <span>Einstellungen</span>
                    </Link>
                </li>
            </ul>
        </nav>

        <!-- Quick System Status Badge at bottom of sidebar -->
        <div class="pt-4 border-t border-blue-200/60">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-blue-700">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>KI-Engine: Online</span>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import {
    HomeIcon,
    ClipboardDocumentCheckIcon,
    UsersIcon,
    MagnifyingGlassIcon,
    Cog6ToothIcon,
} from "@heroicons/vue/24/outline";

const page = usePage();

const isActive = (path) => {
    return page.url === path || page.url.startsWith(path + "/");
};
</script>
