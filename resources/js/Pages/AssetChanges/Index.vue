<script setup>
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
    changes: Array,
    status: String,
});

function approve(id) {
    router.post(route('asset-changes.approve', id))
}
function filterStatus(event) {
    router.get(route('asset-changes.index'), {
        status: event.target.value,
    })
}
</script>
<template>
<MainLayout>
    <div class="p-6">
        

<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">
        Asset Requests
    </h1>

    <select
        :value="status"
        @change="filterStatus"
    >
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
        <option value="all">All</option>
    </select>
</div>


        <table class="min-w-full border">
            <thead>
                <tr>
                    <th>Property#</th>
                    <th>Type</th>
                    <th>Requested By</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="change in changes" :key="change.id">
                    

<td>{{ change.data.property_number }}</td>
<td>{{ change.data.type }}</td>
<td>{{ change.user.name }}</td>
<td>{{ change.action }}</td>
<td>{{ change.status }}</td>


<td>
    <button
    @click="router.get(route('asset-changes.show', change.id))">
        View
    </button>
</td>
                </tr>
            </tbody>
        </table>
    </div>
</MainLayout>
</template>
