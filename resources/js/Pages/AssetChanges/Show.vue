<script setup>
import { router, usePage } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import StatusBadge from '@/Components/StatusBadge.vue'

const page = usePage()
defineProps({
    change: Object,
})
function approve(id) {
    router.post(route('asset-changes.approve', id))
}
function reject(id) {
    router.post(route('asset-changes.reject', id))
}
function formatDate(date) {
    return new Date(date).toLocaleString()
}
function back() {
    router.visit(route('asset-changes.index'))
}
</script>

<template>
<MainLayout>
<template #header>
    <div class="flex items-center gap-4">
        <button
            @click="back"
            class="px-3 py-1 text-sm border rounded hover:bg-gray-100"
        >
            ← Back
        </button>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Asset Request
        </h2>
    </div>
</template>



<div
    v-if="page.props.errors.change"
    class="mb-4 rounded bg-red-100 border border-red-400 text-red-700 px-4 py-3"
>
    {{ page.props.errors.change }}
</div>


<div class="py-6 px-6">

        <div class="bg-white rounded-lg shadow p-6 mb-6">

    <h3 class="text-lg font-semibold mb-4">
        Asset Request
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500">Requested By</p>
            <p>{{ change.user.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Action</p>
            <p class="capitalize">{{ change.action }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Status</p>


<StatusBadge :status="change.status" />



        </div>

    </div>

</div>



<div class="bg-white rounded-lg shadow p-6 mb-6">

    <h3 class="text-lg font-semibold mb-4">
        Asset Information
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500">Property Number</p>
            <p>{{ change.data.property_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Type</p>
            <p>{{ change.data.type }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Brand</p>
            <p>{{ change.data.brand }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Model</p>
            <p>{{ change.data.model }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Serial Number</p>
            <p>{{ change.data.serial_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Assigned To</p>
            <p>{{ change.data.assigned_to }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Department</p>
            <p>{{ change.data.department }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Location</p>
            <p>{{ change.data.location }}</p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500">Description</p>
            <p>{{ change.data.description }}</p>
        </div>

    </div>

</div>





<div
    v-if="change.status !== 'pending'"
    class="bg-white rounded-lg shadow p-6 mb-6"
>

    <h3 class="text-lg font-semibold mb-4">
        Processing
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500">Processed By</p>
            <p>{{ change.approver?.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Processed At</p>
            <p>{{ formatDate(change.approved_at) }}</p>
        </div>

    </div>

</div>





<div
    v-if="change.status === 'pending'"
    class="bg-white rounded-lg shadow p-6"
>

    <h3 class="text-lg font-semibold mb-4">
        Actions
    </h3>

    <div class="flex gap-4">

        <button
            @click="approve(change.id)"
            class="px-6 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition"
        >
            ✓ Approve
        </button>

        <button
            @click="reject(change.id)"
            class="px-6 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition"
        >
            ✕ Reject
        </button>

    </div>

</div>



</div>
</MainLayout>
</template>
