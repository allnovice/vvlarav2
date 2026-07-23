<script setup>
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

defineProps({
    form: Object,
})
</script>

<template>

    <h4 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Acquisition
    </h4>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <InputLabel
                for="acquisition_date"
                value="Acquisition Date"
            />

            <TextInput
                id="acquisition_date"
                v-model="form.acquisition_date"
                type="date"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.acquisition_date"
                class="mt-2"
            />
        </div>

        <div>
            <InputLabel
                for="warranty_expiry"
                value="Warranty Expiry"
            />

            <TextInput
                id="warranty_expiry"
                v-model="form.warranty_expiry"
                type="date"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.warranty_expiry"
                class="mt-2"
            />
        </div>

        <div>
            <InputLabel
                for="acquisition_cost"
                value="Acquisition Cost"
            />

            <TextInput
                id="acquisition_cost"
                v-model="form.acquisition_cost"
                type="number"
                step="0.01"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.acquisition_cost"
                class="mt-2"
            />
        </div>

        <div>
            <InputLabel
                for="supplier"
                value="Supplier"
            />

            <TextInput
                id="supplier"
                v-model="form.supplier"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.supplier"
                class="mt-2"
            />
        </div>

    </div>

</template>
