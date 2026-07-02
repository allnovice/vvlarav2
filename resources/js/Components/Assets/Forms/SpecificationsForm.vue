<script setup>
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

defineProps({
    form: Object,
})
</script>

<template>

<h4 class="text-lg font-semibold mt-8 mb-4">
    Specifications
</h4>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <InputLabel for="brand" value="Brand" />
        <TextInput
            id="brand"
            v-model="form.brand"
            class="mt-1 block w-full"
        />
        <InputError
            :message="form.errors.brand"
            class="mt-2"
        />
    </div>

    <div>
        <InputLabel for="model" value="Model" />
        <TextInput
            id="model"
            v-model="form.model"
            class="mt-1 block w-full"
        />
        <InputError
            :message="form.errors.model"
            class="mt-2"
        />
    </div>

    <div>
        <InputLabel for="serial_number" value="Serial Number" />
        <TextInput
            id="serial_number"
            v-model="form.serial_number"
            class="mt-1 block w-full"
        />
        <InputError
            :message="form.errors.serial_number"
            class="mt-2"
        />
    </div>

    <div>
        <InputLabel for="manufacturer" value="Manufacturer" />
        <TextInput
            id="manufacturer"
            v-model="form.manufacturer"
            class="mt-1 block w-full"
        />
        <InputError
            :message="form.errors.manufacturer"
            class="mt-2"
        />
    </div>

</div>

</template>
