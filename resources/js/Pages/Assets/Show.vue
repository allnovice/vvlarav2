<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import AssetModal from '@/Components/Assets/AssetModal.vue'

const props = defineProps({
    asset: Object,
})
const showModal = ref(false)

const form = useForm({
    // Asset Information
    property_number: '',
    type: '',
    status: 'Active',
    description: '',

    // Specifications
    brand: '',
    model: '',
    serial_number: '',
    manufacturer: '',

    // Assignment
    assigned_to: '',
    department: '',
    location: '',

    // Acquisition
    acquisition_date: '',
    acquisition_cost: '',
    supplier: '',
    warranty_expiry: '',
})
const editAsset = () => {

    // Asset Information
    form.property_number = props.asset.property_number
    form.type = props.asset.type
    form.status = props.asset.status
    form.description = props.asset.description

    // Specifications
    form.brand = props.asset.brand
    form.model = props.asset.model
    form.serial_number = props.asset.serial_number
    form.manufacturer = props.asset.manufacturer

    // Assignment
    form.assigned_to = props.asset.assigned_to
    form.department = props.asset.department
    form.location = props.asset.location

    // Acquisition
    form.acquisition_date = props.asset.acquisition_date
    form.acquisition_cost = props.asset.acquisition_cost
    form.supplier = props.asset.supplier
    form.warranty_expiry = props.asset.warranty_expiry

    showModal.value = true
}
const submit = () => {
    form.put(route('assets.update', props.asset.id), {
        onSuccess: () => {
            showModal.value = false
        },
    })
}
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
            type="date"
        />

        <InfoRow
            label="Acquisition Cost"
            :value="asset.acquisition_cost"
            type="currency"
        />

        <InfoRow
            label="Supplier"
            :value="asset.supplier"
        />

        <InfoRow
            label="Warranty Expiry"
            :value="asset.warranty_expiry"
            type="date"
        />

    </div>

</div>

<div class="mt-8 flex justify-end">

    <button
    @click="editAsset"
    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
>
    Edit Asset
</button>

</div>







                 </div>

            </div>

        </div>

<AssetModal
    :show="showModal"
    :is-editing="true"
    :form="form"
    @close="showModal = false"
    @submit="submit"
/>

    </AuthenticatedLayout>
</template>
