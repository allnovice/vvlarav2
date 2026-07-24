<script setup>
import { useForm, Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import AssetModal from '@/Components/Assets/AssetModal.vue'
import AssetSummaryCard from '@/Components/Assets/Cards/AssetSummaryCard.vue'
import SpecificationsCard from '@/Components/Assets/Cards/SpecificationsCard.vue'
import AssignmentCard from '@/Components/Assets/Cards/AssignmentCard.vue'
import AcquisitionCard from '@/Components/Assets/Cards/AcquisitionCard.vue'
import VerificationCard from '@/Components/Assets/Cards/VerificationCard.vue'
import HistoryCard from '@/Components/Assets/Cards/HistoryCard.vue'
import AdditionalPhotosCard from '@/Components/Assets/Cards/AdditionalPhotosCard.vue'

const props = defineProps({
    asset: Object,
    approvedPhotoCount: Number,
    pendingPhotoCount: Number,
    maxPhotoCount: Number,
})
const showModal = ref(false)
const page = usePage()

const user = computed(() => page.props.auth?.user ?? null)

const isAuthenticated = computed(() => !!user.value)
const form = useForm({
    // Asset Information
    property_number: '',
    type: '',
    status: 'Active',
    description: '',
    photo: null,

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

    form.photo = null

    showModal.value = true
}
const submit = () => {

form.put(route('assets.update', props.asset.id), {
    forceFormData: true,
    onSuccess: () => {
        showModal.value = false
    },
})

}

</script>

<template>
    <MainLayout>

        <template #header>
            <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-100">
                Asset Details
            </h2>
        </template>

        <div class="py-6 px-6">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <div class="mb-6">
                    <Link
                        :href="route('assets')"
                        class="text-blue-600 hover:underline dark:text-blue-400"
                    >
                        ← Back to Assets
                    </Link>
                </div>


<div class="space-y-4">

<AssetSummaryCard
    :asset="asset"
    :isAuthenticated="isAuthenticated"    
    @edit="editAsset"
/>
<SpecificationsCard :asset="asset" />
<AssignmentCard :asset="asset" />
<AcquisitionCard :asset="asset" />
<VerificationCard :asset="asset" />
<AdditionalPhotosCard
    :asset-id="asset.id"
    :photos="asset.photos"
    :approved-photo-count="approvedPhotoCount"
    :pending-photo-count="pendingPhotoCount"
    :max-photo-count="maxPhotoCount"
/>
<HistoryCard :asset="asset" />










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

    </MainLayout>
</template>
