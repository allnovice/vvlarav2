<script setup>
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

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
</script>

<template>
<AdminLayout>
    <template #header>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Asset Requests
        </h2>

    </template>

    <div class="py-6 px-6">

        <p><strong>Requested By:</strong> {{ change.user.name }}</p>
        <p><strong>Action:</strong> {{ change.action }}</p>
        <p><strong>Status:</strong> {{ change.status }}</p>

        <hr class="my-6">

        <p><strong>Property Number:</strong> {{ change.data.property_number }}</p>
        <p><strong>Type:</strong> {{ change.data.type }}</p>
        <p><strong>Description:</strong> {{ change.data.description }}</p>
        <p><strong>Brand:</strong> {{ change.data.brand }}</p>
        <p><strong>Model:</strong> {{ change.data.model }}</p>
        <p><strong>Serial Number:</strong> {{ change.data.serial_number }}</p>
        <p><strong>Assigned To:</strong> {{ change.data.assigned_to }}</p>
        <p><strong>Department:</strong> {{ change.data.department }}</p>
        <p><strong>Location:</strong> {{ change.data.location }}</p>


<div v-if="change.status !== 'pending'" class="mt-4">
    <p>
        <strong>Processed By:</strong>
        {{ change.approver?.name }}
    </p>

    <p>
        <strong>Processed At:</strong>
        {{ formatDate(change.approved_at) }}
    </p>
</div>


    </div>
    
<div
    v-if="change.status === 'pending'"
    class="mt-8"
>
    <button @click="approve(change.id)">
        Approve
    </button>

    <button @click="reject(change.id)">
        Reject
    </button>
</div>
</AdminLayout>
</template>
