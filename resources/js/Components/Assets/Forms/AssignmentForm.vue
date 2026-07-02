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
        Assignment
    </h4>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <InputLabel
                for="assigned_to"
                value="Assigned To"
            />

            <TextInput
                id="assigned_to"
                v-model="form.assigned_to"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.assigned_to"
                class="mt-2"
            />
        </div>

        <div>
            <InputLabel
                for="department"
                value="Department"
            />

            <TextInput
                id="department"
                v-model="form.department"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.department"
                class="mt-2"
            />
        </div>

        <div class="md:col-span-2">
            <InputLabel
                for="location"
                value="Location"
            />

            <TextInput
                id="location"
                v-model="form.location"
                class="mt-1 block w-full"
            />

            <InputError
                :message="form.errors.location"
                class="mt-2"
            />
        </div>

    </div>

</template>
