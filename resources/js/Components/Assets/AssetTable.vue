<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { Link, usePage } from '@inertiajs/vue3'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'

defineProps({
    assets: Array,
    sortBy: String,
    sortDirection: String,
    isAuthenticated: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits([
    'edit',
    'delete',
    'sort',
])
const page = usePage()
</script>

<template>

<div class="overflow-x-auto">

    <table class="w-full border-collapse">

        <thead>
            <tr class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                <th
    @click="emit('sort', 'property_number')"
    class="cursor-pointer px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
>
    
    <div class="flex items-center gap-1">
    Property No.

    <span v-if="sortBy === 'property_number'">
        {{ sortDirection === 'asc' ? '▲' : '▼' }}
    </span>
</div>

</th>

                <th
    @click="emit('sort', 'type')"
    class="cursor-pointer px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
>
    
    <div class="flex items-center gap-1">
    Type

    <span v-if="sortBy === 'type'">
        {{ sortDirection === 'asc' ? '▲' : '▼' }}
    </span>
</div>

</th>

                <th
    @click="emit('sort', 'status')"
    class="cursor-pointer px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
>
    
    <div class="flex items-center gap-1">
    Status

    <span v-if="sortBy === 'status'">
        {{ sortDirection === 'asc' ? '▲' : '▼' }}
    </span>
</div>

</th>

                <th
    @click="emit('sort', 'description')"
    class="cursor-pointer px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
>
    
    <div class="flex items-center gap-1">
    Description

    <span v-if="sortBy === 'description'">
        {{ sortDirection === 'asc' ? '▲' : '▼' }}
    </span>
</div>
</th>


<th
    @click="emit('sort', 'assigned_to')"
    class="cursor-pointer px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
>
    <div class="flex items-center gap-1">
        Assigned To

        <span v-if="sortBy === 'assigned_to'">
            {{ sortDirection === 'asc' ? '▲' : '▼' }}
        </span>
    </div>
</th>




                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Actions
                </th>
            </tr>
        </thead>

        <tbody>
            <tr
                v-for="(asset, index) in assets"
                :key="asset.id"
:class="[
    index % 2 === 0
        ? 'bg-white dark:bg-gray-800'
        : 'bg-gray-50 dark:bg-gray-900',
    'border-b border-gray-100 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors'
]"
            >
                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                    {{ asset.property_number }}
                </td>

                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                    {{ asset.type }}
                </td>


                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
    <StatusBadge :status="asset.status" />

</td>


                <td class="px-4 py-3 whitespace-normal break-words">
                    {{ asset.description }}
                </td>

                



<td class="px-4 py-3 text-gray-900 dark:text-gray-100">
    {{ asset.assigned_to || '-' }}
</td>



<td class="px-4 py-3 text-center space-x-2">
<Link
    :href="route('assets.show', asset.id)"
    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
>
    View
</Link>


<template v-if="isAuthenticated">
    <template v-if="asset.pending_change">
        <span
            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium"
            :class="{
                'bg-yellow-100 text-yellow-800':
                    asset.pending_change.action === 'update',
                'bg-red-100 text-red-800':
                    asset.pending_change.action === 'delete',
            }"
        >
            Pending
            {{
                asset.pending_change.action === 'update'
                    ? 'Update'
                    : 'Deletion'
            }}
        </span>
    </template>

    <template v-else>
        <SecondaryButton
            @click="$emit('edit', asset)"
        >
            Edit
        </SecondaryButton>

        <DangerButton
            @click="$emit('delete', asset)"
        >
            Delete
        </DangerButton>
    </template>
</template>


                </td>
            </tr>

            <tr v-if="assets.length === 0">
                <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                    No assets found.
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>
