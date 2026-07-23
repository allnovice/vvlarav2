<script setup>
import { ref, computed } from 'vue'
import { router, usePage, useForm } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
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
    search: String,
})
const showModal = ref(false)
const isEditing = ref(false)
const editingId = ref(null)
const search = ref(props.search ?? '')
const statusFilter = ref('All')
const sortBy = ref('property_number')
const sortDirection = ref('asc')

const performSearch = () => {
    router.get(route('assets'), {
        search: search.value,
    }, {
        preserveState: true,
        replace: true,
    })
}

const updateSearch = (value) => {
    search.value = value
    performSearch()
}
const updateStatusFilter = (value) => {
    statusFilter.value = value

    router.get(route('assets'), {
        search: search.value,
        status: statusFilter.value,
        sort: sortBy.value,
        direction: sortDirection.value,
    }, {
        preserveState: true,
        replace: true,
    })
}
const page = usePage()

console.log('AUTH =', page.props.auth)
console.log('USER =', page.props.auth?.user)
console.log('PROPS KEYS =', Object.keys(page.props))

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

const submit = () => {
    if (isEditing.value) {
        form.put(route('assets.update', editingId.value), {
            forceFormData: true,
            onSuccess: () => closeModal(),
        })

    } else {
        form.post(route('assets.store'), {
            forceFormData: true, 
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
    if (!isAuthenticated.value) return

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

    router.get(route('assets'), {
        search: search.value,
        sort: sortBy.value,
        direction: sortDirection.value,
    }, {
        preserveState: true,
        replace: true,
    })

}

</script>

<template>
    <MainLayout>

        <template #header>
                <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-100">
                    Assets
                </h2>
           
        </template>

        <div class="py-6 px-6">

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

 <!-- Toolbar -->
<AssetToolbar
    :search="search"
    :statusFilter="statusFilter"
    :isAuthenticated="isAuthenticated"
    @update:search="updateSearch"
    @update:statusFilter="updateStatusFilter"
    @addAsset="showModal = true"
/>

<AssetTable
    :assets="props.assets.data"
    :sortBy="sortBy"
    :sortDirection="sortDirection"
    :isAuthenticated="isAuthenticated"
    @edit="editAsset"
    @delete="deleteAsset"
    @sort="sort"
/>

            </div>

<div class="flex items-center justify-between rounded-b-xl border-t border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900">

    <p class="text-sm text-gray-600 dark:text-gray-400">
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


    </MainLayout>
</template>
