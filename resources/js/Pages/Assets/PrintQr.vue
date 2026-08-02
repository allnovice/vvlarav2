<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'

const props = defineProps({
    asset: Object,
    qr: String,
})

const printLabel = () => {
    window.print()
}
</script>

<template>
    <MainLayout>

        <template #header>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                Asset QR Label
            </h2>
        </template>

        <div class="max-w-2xl mx-auto py-8 px-6">

            <div class="mb-6">
                <Link
                    :href="route('assets.show', asset.id)"
                    class="text-blue-600 hover:underline dark:text-blue-400"
                >
                    ← Back to Asset
                </Link>
            </div>

            <div class="rounded-xl border bg-white p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <h1 class="text-center text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Asset QR Label
                </h1>

                <div
                    class="flex justify-center mt-8"
                    v-html="qr"
                ></div>

                <div class="mt-8 text-center">

                    <p class="text-sm uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        Brand
                    </p>

                    <p class="text-xl font-semibold">
                        {{ asset.brand }}
                    </p>

                    <p class="text-lg text-gray-600">
                        {{ asset.model }}
                    </p>

                </div>

                <div class="mt-6 text-center">

                    <p class="text-sm uppercase tracking-widest text-gray-400">
                        Property Number
                    </p>

                    <p class="text-xl font-bold">
                        {{ asset.property_number }}
                    </p>

                </div>

                <div class="mt-6 flex justify-center">
                    <StatusBadge :status="asset.status" />
                </div>

                <div class="mt-10 flex justify-center">

                    <button
                        @click="printLabel"
                        class="rounded-lg bg-blue-600 px-6 py-2 text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        Print Label
                    </button>

                </div>

            </div>

        </div>

    </MainLayout>
</template>
