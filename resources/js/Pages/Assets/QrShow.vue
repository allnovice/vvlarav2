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

    <div>
        Last:
        {{
            asset.maintenance_schedule?.maintenance_date
                ? new Date(asset.maintenance_schedule.maintenance_date)
                    .toLocaleDateString(undefined, {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    })
                : '-'
        }}
    </div>

    <div>

        Next Due:

        <Link
            :href="route('operations.index', {
                search: asset.property_number
            })"
            class="font-semibold text-blue-600 hover:underline"
        >
            {{
                asset.maintenance_schedule?.next_due_date
                    ? new Date(asset.maintenance_schedule.next_due_date)
                        .toLocaleDateString(undefined, {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                        })
                    : 'Not Scheduled'
            }}
        </Link>

    </div>

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
                
                <div
                    v-if="entry.remarks"
                    class="mt-1 text-sm italic text-gray-500 dark:text-gray-400"
                >
                    {{ entry.remarks }}
                </div>

            </div>



        </div>

    </div>
</template>
