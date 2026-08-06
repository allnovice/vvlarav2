<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { Link, usePage } from '@inertiajs/vue3'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import { CheckBadgeIcon } from '@heroicons/vue/24/solid'
import {
    Laptop,
    Computer,
    Cpu,
    Monitor,
    Keyboard,
    Printer,
    ScanLine,
    Server,
    Router,
    Battery,
    Armchair,
    Package,
} from '@lucide/vue'

const typeIcons = {
    Laptop,
    Desktop: Computer,
    CPU: Cpu,
    Monitor,
    Keyboard,
    Printer,
    Scanner: ScanLine,
    Server,
    'Network Device': Router,
    UPS: Battery,
    Furniture: Armchair,
    Other: Package,
}
defineProps({
    assets: Array,
    sortBy: String,
    sortDirection: String,
    isAuthenticated: {
        type: Boolean,
        default: false,
    },
    selectable: {
        type: Boolean,
        default: false,
    },
    selectedAssets: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits([
    'edit',
    'delete',
    'sort',
    'toggle-select',
])
const page = usePage()
</script>

<template>

<div class="overflow-x-auto">

    <table class="w-full border-collapse">

        <thead>
            <tr class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">

<th
    v-if="selectable"
    class="w-10 px-4 py-3"
>
</th>


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

<td
    v-if="selectable"
    class="px-4 py-3"
>
<input
    type="checkbox"
    :checked="selectedAssets.some(a => a.id === asset.id)"
    @change="$emit('toggle-select', asset.id, $event.target.checked)"
>   
</td>

<td class="px-4 py-3 whitespace-nowrap">
    <Link
        :href="route('assets.show', asset.id)"
        class="font-semibold text-indigo-600 hover:underline dark:text-indigo-400"
    >
        {{ asset.property_number }}
    </Link>

<div class="mt-1 flex flex-wrap items-center gap-1">
    <StatusBadge :status="asset.status" />

    <StatusBadge
        :status="
            asset.pending_verification
                ? 'Pending Verification'
                : asset.verified_at
                    ? 'Verified'
                    : 'Not Verified'
        "
    />

    <component
        :is="typeIcons[asset.type]"
        v-if="typeIcons[asset.type]"
        class="h-4 w-4 text-slate-600 dark:text-slate-300"
        :title="asset.type"
    />
</div>


</td>

<td class="px-4 py-3 whitespace-normal break-words">
                    {{ asset.description }}
                </td>

<td class="px-4 py-3 text-gray-900 dark:text-gray-100">
    {{ asset.assigned_to || '-' }}
</td>
            </tr>

            <tr v-if="assets.length === 0">
                <td :colspan="selectable ? 4 : 3" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                    No assets found.
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>
