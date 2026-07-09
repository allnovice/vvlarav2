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

            <h2 class="text-lg font-semibold">
                Submit Verification
            </h2>

            <div class="mt-6">

                <label class="block text-sm font-medium mb-2">
                    Remarks
                </label>

                <textarea
                    v-model="form.remarks"
                    rows="4"
                    class="w-full rounded-md border-gray-300"
                />

            </div>

            <div class="mt-4">

                <label class="block text-sm font-medium mb-2">
                    Supporting Document (Optional)
                </label>

                <input
                    type="file"
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
