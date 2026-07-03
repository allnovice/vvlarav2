<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
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
    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold">
                Asset QR Label
            </h2>
        </template>

        <div class="max-w-2xl mx-auto py-8 px-6">

            <div class="mb-6">
                <Link
                    :href="route('assets.show', asset.id)"
                    class="text-blue-600 hover:underline"
                >
                    ← Back to Asset
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-8">

                <h1 class="text-2xl font-bold text-center">
                    Asset QR Label
                </h1>

                <div
                    class="flex justify-center mt-8"
                    v-html="qr"
                ></div>

                <div class="mt-8 text-center">

                    <p class="text-sm uppercase tracking-widest text-gray-400">
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
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Print Label
                    </button>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
