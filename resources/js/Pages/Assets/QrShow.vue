<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    asset: Object,
})
</script>

<template>
    <div class="max-w-md mx-auto space-y-5 p-4">

        <div>

            <h1 class="text-xl font-bold">
                {{ asset.brand }} {{ asset.model }}
            </h1>

            <Link
                :href="route('assets.show', asset.id)"
                class="text-sm text-blue-600 hover:underline"
            >
                {{ asset.property_number }}
            </Link>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ asset.type ?? '-' }}
                |
                {{ asset.location ?? '-' }}
                |
                {{ asset.assigned_to ?? 'N/A' }}
                |
                {{ asset.status }}
            </p>

        </div>

        <div>

            <div class="font-semibold">
                Verification
            </div>

            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ asset.verified_at
                    ? new Date(asset.verified_at).toLocaleDateString()
                    : '-' }}
                |
                {{ asset.next_verification_due
                    ? new Date(asset.next_verification_due).toLocaleDateString()
                    : '-' }}
            </div>

        </div>

        <div>

            <div class="font-semibold">
                Maintenance
            </div>

            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ asset.maintenance_schedule?.maintenance_date ?? '-' }}
                |
                {{ asset.maintenance_schedule?.next_due_date ?? '-' }}
            </div>

        </div>

        <div>

            <div class="mb-2 font-semibold">
                Recent History
            </div>

            <div
                v-for="entry in asset.history"
                :key="entry.id"
                class="border-t py-3"
            >

                <div class="text-xs text-gray-500">
                    {{ entry.type }} |
                    {{ new Date(entry.performed_at).toLocaleDateString() }}
                </div>

                <div class="font-medium">
                    {{ entry.title }}
                </div>

                <div
                    v-if="entry.description"
                    class="text-sm text-gray-600 dark:text-gray-300"
                >
                    {{ entry.description }}
                </div>

            </div>

            <Link
                :href="route('maintenance.index', {
                    search: asset.property_number
                })"
                class="mt-3 inline-block text-sm text-blue-600 hover:underline"
            >
                View Maintenance History →
            </Link>

        </div>

    </div>
</template>
