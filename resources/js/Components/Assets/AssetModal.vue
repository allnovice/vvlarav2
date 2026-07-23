<script setup>
import Modal from '@/Components/Modal.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import AssetInformationForm from '@/Components/Assets/Forms/AssetInformationForm.vue'
import SpecificationsForm from '@/Components/Assets/Forms/SpecificationsForm.vue'
import AssignmentForm from '@/Components/Assets/Forms/AssignmentForm.vue'
import AcquisitionForm from '@/Components/Assets/Forms/AcquisitionForm.vue'

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
    <div class="bg-white p-6 dark:bg-gray-800">

        <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-gray-100">
            {{ isEditing ? 'Edit Asset' : 'Add Asset' }}
        </h3>

        
<AssetInformationForm :form="form" />
<SpecificationsForm :form="form" />
<AssignmentForm :form="form" />
<AcquisitionForm :form="form" />

<div class="mb-4">

    <InputLabel
        for="photo"
        value="Asset Photo"
    />

    <input
        id="photo"
        type="file"
        accept="image/*"
        class="mt-1 block w-full text-gray-900 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-200 dark:text-gray-100 dark:file:bg-gray-700 dark:file:text-gray-100 dark:hover:file:bg-gray-600"
        @change="e => form.photo = e.target.files[0]"
    />

    <InputError
        class="mt-2"
        :message="form.errors.photo"
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
