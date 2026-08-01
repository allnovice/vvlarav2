<script setup>
defineProps({
    assets: Array,
    canPerform: Boolean,
})
const emit = defineEmits([
    'assign-schedule',
    'perform',
])
</script>

<template>
    <div class="overflow-x-auto rounded-xl bg-white dark:bg-gray-800 shadow-sm">
        <table class="min-w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left p-3">Property No.</th>
                    <th class="text-left p-3">Type</th>
                    <th class="text-left p-3">Brand</th>
                    <th class="text-left p-3">Model</th>
                    <th class="text-left p-3">Next Due</th>
                    <th class="text-left p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="asset in assets"
                    :key="asset.id"
                >
                    <td class="p-3">{{ asset.property_number }}</td>
                    <td class="p-3">{{ asset.type }}</td>
                    <td class="p-3">{{ asset.brand }}</td>
                    <td class="p-3">{{ asset.model }}</td>
                    <td class="p-3">{{ asset.next_due_date ?? 'Never Maintained' }}</td>
<td class="p-3">

<button
    v-if="canPerform && !asset.next_due_date"
    class="px-3 py-1 rounded bg-blue-600 text-white"
    @click="emit('perform', asset)"
>
    Perform First Maintenance
</button>
<button
    v-else-if="canPerform"
    class="px-3 py-1 rounded bg-green-600 text-white"
    @click="emit('perform', asset)"
>
    Perform
</button>

</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
