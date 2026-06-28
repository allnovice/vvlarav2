<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import Modal from '@/Components/Modal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

defineProps({
    assets: Array,
})

const showModal = ref(false)
const isEditing = ref(false)
const editingId = ref(null)

const form = useForm({
    property_number: '',
    type: '',
    description: '',
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

    form.property_number = asset.property_number
    form.type = asset.type
    form.description = asset.description

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
</script>

<template>
    <AuthenticatedLayout>

        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Assets
                </h2>
           
        </template>

        <div class="py-6 px-6">

            <div class="bg-white shadow rounded p-4">

<div class="flex justify-between items-center mb-4">

    <input
        type="text"
        placeholder="Search assets..."
        class="border rounded-md px-3 py-2 w-80"
    />

    <PrimaryButton @click="showModal = true">
        + Add Asset
    </PrimaryButton>

</div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">Property No.</th>
                            <th class="text-left p-2">Type</th>
                            <th class="text-left p-2">Description</th>
                            <th class="text-center p-2">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="asset in assets"
                            :key="asset.id"
                            class="border-b"
                        >
                            <td class="p-2">
                                {{ asset.property_number }}
                            </td>

                            <td class="p-2">
                                {{ asset.type }}
                            </td>

                            <td class="p-2">
                                {{ asset.description }}
                            </td>

                            <td class="p-2 text-center space-x-2">
    
        <SecondaryButton
    @click="editAsset(asset)"
>
    Edit
</SecondaryButton>
    

    <DangerButton
    @click="deleteAsset(asset)"
>
    Delete
</DangerButton>

</td>

                        </tr>

                        <tr v-if="assets.length === 0">
                            <td colspan="4" class="p-4 text-center">
    No assets found
</td>

                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- Modal -->
            <Modal
    :show="showModal"
    @close="closeModal"
    max-width="lg"
>
    <div class="p-6">

        <h3 class="text-lg font-bold mb-4">
            {{ isEditing ? 'Edit Asset' : 'Add Asset' }}
        </h3>

        <div class="mb-4">
    <InputLabel for="property_number" value="Property Number" />

    <TextInput
        id="property_number"
        v-model="form.property_number"
        type="text"
        class="mt-1 block w-full"
    />

    <InputError
        class="mt-2"
        :message="form.errors.property_number"
    />
</div>


        <div class="mb-4">
    <InputLabel for="type" value="Type" />

    <select
        id="type"
        v-model="form.type"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
        <option value="">Select Type</option>
        <option>Laptop</option>
        <option>Desktop</option>
        <option>Monitor</option>
        <option>Printer</option>
        <option>Scanner</option>
        <option>Server</option>
        <option>Network Device</option>
        <option>UPS</option>
        <option>Furniture</option>
        <option>Other</option>
    </select>

    <InputError
        class="mt-2"
        :message="form.errors.type"
    />
</div>


        <div class="mb-4">
    <InputLabel for="description" value="Description" />

    <textarea
        id="description"
        v-model="form.description"
        rows="4"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    ></textarea>

    <InputError
        class="mt-2"
        :message="form.errors.description"
    />
</div>

        <div class="flex justify-end gap-2">
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton @click="submit">
                {{ isEditing ? 'Update' : 'Save' }}
            </PrimaryButton>
        </div>

    </div>
</Modal>
   



        </div>
    </AuthenticatedLayout>
</template>
