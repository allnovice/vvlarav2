<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    asset: Object,
})
</script>

<template>
    <div class="max-w-md mx-auto p-4 space-y-4">

        <div>
            <h1 class="text-xl font-bold">
                {{ asset.brand }} {{ asset.model }}
            </h1>

            <p class="text-sm text-gray-500">
                {{ asset.property_number }}
            </p>
        </div>

<div class="space-y-3">

    <div>
        <div class="text-sm font-semibold">Assigned To</div>
        <div>{{ asset.assigned_to ?? '-' }}</div>
    </div>

<div>
    <div class="text-sm font-semibold">Verification</div>

    <div>
        Verified:
        {{ asset.verified_at
            ? new Date(asset.verified_at).toLocaleDateString()
            : '-' }}
    </div>

    <div>
        Next Due:
        {{ asset.next_verification_due
            ? new Date(asset.next_verification_due).toLocaleDateString()
            : '-' }}
    </div>
</div>


    <div>
        <div class="text-sm font-semibold">Maintenance</div>

        <div>
            Last:
            {{ asset.maintenance_schedule?.maintenance_date ?? '-' }}
        </div>

        <div>
            Next:
            {{ asset.maintenance_schedule?.next_due_date ?? '-' }}
        </div>
    </div>

</div>


<div>
    <div class="text-sm font-semibold mb-2">
        History
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
            class="text-sm italic text-gray-500"
        >
            {{ entry.remarks }}
        </div>
    </div>
</div>


<Link
    :href="route('assets.show', asset.id)"
    class="block mt-6 text-center text-blue-600 hover:underline"
>
    View Full Asset →
</Link>








    </div>
</template>
