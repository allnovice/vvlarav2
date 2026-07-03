<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >

<div class="p-6">
    <h1 class="text-3xl font-bold">
        Computerized Maintenance Management System
    </h1>

    <p class="mt-2 text-gray-600">
        Manage organizational assets, maintenance activities, and work requests.
    </p>
</div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>
