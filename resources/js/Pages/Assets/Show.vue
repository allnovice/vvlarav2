<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'

defineProps({
    asset: Object,
})
</script>

<template>
    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Asset Details
            </h2>
        </template>

        <div class="py-6 px-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="mb-6">
                    <Link
                        :href="route('assets')"
                        class="text-blue-600 hover:underline"
                    >
                        ← Back to Assets
                    </Link>
                </div>


<div class="space-y-4">

    <h3 class="text-lg font-semibold text-gray-800">
        Asset Information
    </h3>

    <div class="border rounded-lg overflow-hidden">



        <InfoRow
    label="Property Number"
    :value="asset.property_number"
/>

<InfoRow
    label="Type"
    :value="asset.type"
/>

<InfoRow label="Status">

    <StatusBadge :status="asset.status" />

</InfoRow>

<InfoRow
    label="Description"
    :value="asset.description"
/>



    </div>


<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        Specifications
    </h3>

    <div class="border rounded-lg overflow-hidden">


<InfoRow
    label="Brand"
    :value="asset.brand"
/>

<InfoRow
    label="Model"
    :value="asset.model"
/>

<InfoRow
    label="Serial Number"
    :value="asset.serial_number"
/>

<InfoRow
    label="Manufacturer"
    :value="asset.manufacturer"
/>


    </div>

</div>

<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        Assignment
    </h3>

    <div class="border rounded-lg overflow-hidden">

<InfoRow
    label="Department"
    :value="asset.department"
/>

<InfoRow
    label="Location"
    :value="asset.location"
/>

<InfoRow
    label="Assigned To"
    :value="asset.assigned_to"
/>

    </div>

</div>




<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        Acquisition
    </h3>

    <div class="border rounded-lg overflow-hidden">

        <InfoRow
            label="Acquisition Date"
            :value="asset.acquisition_date"
        />

        <InfoRow
            label="Acquisition Cost"
            :value="asset.acquisition_cost"
        />

        <InfoRow
            label="Supplier"
            :value="asset.supplier"
        />

        <InfoRow
            label="Warranty Expiry"
            :value="asset.warranty_expiry"
        />

    </div>

</div>

<div class="mt-8 flex justify-end">

    <Link
        :href="route('assets.edit', asset.id)"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
    >
        Edit Asset
    </Link>

</div>







                 </div>

            </div>

        </div>


    </AuthenticatedLayout>
</template>
