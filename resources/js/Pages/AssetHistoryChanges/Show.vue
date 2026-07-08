<script setup>
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
    change: Object,
})

function approve(id) {
    router.post(route('asset-history-changes.approve', id))
}

function reject(id) {
    router.post(route('asset-history-changes.reject', id))
}
function formatDate(date) {
    return new Date(date).toLocaleString()
}
function formatShortDate(date) {
    return new Date(date).toLocaleDateString()
}
</script>

<template>
<AdminLayout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">
            Review History Request
        </h1>

        <p><strong>Requested By:</strong> {{ change.user.name }}</p>
        <p><strong>Asset:</strong> {{ change.asset.property_number }}</p>
        <p><strong>Status:</strong> {{ change.status }}</p>

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

        <hr class="my-6">

        <p><strong>Type:</strong> {{ change.type }}</p>
        <p><strong>Title:</strong> {{ change.title }}</p>
        <p><strong>Description:</strong> {{ change.description }}</p>
        <p><strong>Performed By:</strong> {{ change.performed_by }}</p>
        <p><strong>Performed At:</strong> {{ formatShortDate(change.performed_at) }}</p>
        <p><strong>Remarks:</strong> {{ change.remarks }}</p>

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
