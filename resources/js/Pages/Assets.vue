<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import Modal from '@/Components/Modal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import AssetModal from '@/Components/Assets/AssetModal.vue'
import AssetToolbar from '@/Components/Assets/AssetToolbar.vue'
import AssetTable from '@/Components/Assets/AssetTable.vue'
import AssetPagination from '@/Components/Assets/AssetPagination.vue'

const props = defineProps({
    assets: Object,
})

const showModal = ref(false)
const isEditing = ref(false)
const editingId = ref(null)
const search = ref('')
const statusFilter = ref('All')
const sortBy = ref('property_number')
const sortDirection = ref('asc')

const filteredAssets = computed(() => {
    const term = search.value.toLowerCase()

    const results = props.assets.data.filter(asset => {
        const matchesSearch =
            asset.property_number.toLowerCase().includes(term) ||
            asset.type.toLowerCase().includes(term) ||
            asset.description.toLowerCase().includes(term)

        const matchesStatus =
            statusFilter.value === 'All' ||
            asset.status === statusFilter.value

        return matchesSearch && matchesStatus
    })

    results.sort((a, b) => {
        const first = String(a[sortBy.value] ?? '').toLowerCase()
        const second = String(b[sortBy.value] ?? '').toLowerCase()

        if (first < second)
            return sortDirection.value === 'asc' ? -1 : 1

        if (first > second)
            return sortDirection.value === 'asc' ? 1 : -1

        return 0
    })

    return results
})

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

const submit = () => {
    if (isEditing.value) {
        form.put(route('assets.update', editingId.value), {
            onSuccess: () => closeModal(),
        })

    } else {
        form.post(route('assets.store'), {
            onSuccess: () => closeModal(),
        })

    }
}
const editAsset = (asset) => {
    isEditing.value = true
    editingId.value = asset.id

    // Asset Information
    form.property_number = asset.property_number
    form.type = asset.type
    form.status = asset.status
    form.description = asset.description

    // Specifications
    form.brand = asset.brand
    form.model = asset.model
    form.serial_number = asset.serial_number
    form.manufacturer = asset.manufacturer

    // Assignment
    form.assigned_to = asset.assigned_to
    form.department = asset.department
    form.location = asset.location

    // Acquisition
    form.acquisition_date = asset.acquisition_date
    form.acquisition_cost = asset.acquisition_cost
    form.supplier = asset.supplier
    form.warranty_expiry = asset.warranty_expiry

    showModal.value = true
}
const deleteAsset = (asset) => {
    if (!confirm(`Delete asset "${asset.property_number}"?`)) {
        return
    }

    form.delete(route('assets.destroy', asset.id))
}
const closeModal = () => {
    showModal.value = false
    isEditing.value = false
    editingId.value = null
    form.reset()
}
const sort = (column) => {
    if (sortBy.value === column) {
        sortDirection.value =
            sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortBy.value = column
        sortDirection.value = 'asc'
    }
}
</script>

<template>
    <AuthenticatedLayout>

        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Assets
                </h2>
           
        </template>

        <div class="py-6 px-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">

 <!-- Toolbar -->
<AssetToolbar
    :search="search"
    :statusFilter="statusFilter"
    @update:search="search = $event"
    @update:statusFilter="statusFilter = $event"
    @addAsset="showModal = true"
/>

<AssetTable
    :assets="filteredAssets"
    :sortBy="sortBy"
    :sortDirection="sortDirection"
    @edit="editAsset"
    @delete="deleteAsset"
    @sort="sort"
/>

            </div>

<div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 bg-gray-50 rounded-b-xl">

    <p class="text-sm text-gray-600">
    Showing {{ assets.data.length }} asset<span v-if="assets.data.length !== 1">s</span>
</p>

</div>

<AssetPagination
    :links="assets.links"
/>

          </div>
            <!-- Modal -->
<AssetModal
    :show="showModal"
    :form="form"
    :isEditing="isEditing"
    @submit="submit"
    @close="closeModal"
/>        
    </AuthenticatedLayout>
</template>
