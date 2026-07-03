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
        Laptop Specifications
    </h4>

    <div class="grid grid-cols-2 gap-4">

        <div>
            <InputLabel value="CPU" />
            <TextInput
                v-model="form.cpu"
                class="mt-1 block w-full"
            />
            <InputError :message="form.errors.cpu" />
        </div>

        <div>
            <InputLabel value="RAM" />
            <TextInput
                v-model="form.ram"
                class="mt-1 block w-full"
            />
            <InputError :message="form.errors.ram" />
        </div>

        <div>
            <InputLabel value="Storage" />
            <TextInput
                v-model="form.storage"
                class="mt-1 block w-full"
            />
            <InputError :message="form.errors.storage" />
        </div>

        <div>
            <InputLabel value="Operating System" />
            <TextInput
                v-model="form.operating_system"
                class="mt-1 block w-full"
            />
            <InputError :message="form.errors.operating_system" />
        </div>

    </div>

</template>
