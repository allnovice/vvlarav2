<script setup>
import Modal from '@/Components/Modal.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

defineProps({
    show: Boolean,
    form: Object,
})

const emit = defineEmits([
    'close',
    'submit',
])
</script>

<template>
    <Modal :show="show" @close="emit('close')">

        <div class="p-6">

            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Submit Verification
            </h2>

            <div class="mt-6">

                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Remarks
                </label>

                <textarea
                    v-model="form.remarks"
                    rows="4"
                    class="w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                />

            </div>

            <div class="mt-4">

                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Supporting Document (Optional)
                </label>

                <input
                    type="file"
                    class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-100 dark:hover:file:bg-gray-600"
                    @change="form.attachment = $event.target.files[0]"
                />

            </div>

            <div class="mt-6 flex justify-end gap-3">

                <SecondaryButton
                    @click="emit('close')"
                >
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    @click="emit('submit')"
                >
                    Submit Verification
                </PrimaryButton>

            </div>

        </div>

    </Modal>
</template>
