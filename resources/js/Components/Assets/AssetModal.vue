<script setup>
import Modal from '@/Components/Modal.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
    show: Boolean,
    isEditing: Boolean,
    form: Object,
})

const emit = defineEmits([
    'close',
    'submit',
])

</script>

<template>

            <Modal
    :show="show"
    @close="emit('close')"
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
    <InputLabel
        for="status"
        value="Status"
    />

    <select
        id="status"
        v-model="form.status"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
        <option value="Active">Active</option>
        <option value="Under Repair">Under Repair</option>
        <option value="Borrowed">Borrowed</option>
        <option value="Archived">Archived</option>
    </select>

    <InputError
        class="mt-2"
        :message="form.errors.status"
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
            <SecondaryButton @click="emit('close')">
                Cancel
            </SecondaryButton>

            <PrimaryButton @click="emit('submit')">
                {{ isEditing ? 'Update' : 'Save' }}
            </PrimaryButton>
        </div>

    </div>
</Modal>

</template>
