<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    asset: Object,
    qr: String,
})

</script>

<template>
    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold">
                Print QR
            </h2>
        </template>

        <div class="max-w-xl mx-auto p-8">

            <div class="bg-white rounded-xl shadow p-8">

                <h2 class="text-2xl font-bold">
                    {{ asset.brand }}
                </h2>

                <p class="text-gray-500">
                    {{ asset.model }}
                </p>

                <p class="mt-2">
                    {{ asset.property_number }}
                </p>

<div
    class="mt-6 flex justify-center"
    v-html="qr"
></div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
