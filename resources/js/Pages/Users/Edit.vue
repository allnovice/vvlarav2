<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    user: Object,
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    department: props.user.department ?? '',
    position: props.user.position ?? '',
    contact_no: props.user.contact_no ?? '',
    role: props.user.role,
    is_active: props.user.is_active,
})
</script>

<template>
    <MainLayout>
        <template #header>
            Edit User
        </template>

        <div class="max-w-3xl mx-auto p-6">
            <h2 class="text-xl font-semibold mb-6">
                {{ user.name }}
            </h2>

<form @submit.prevent="form.patch(route('users.update', user.id))">
    <div class="mb-6">
        <label class="block mb-2 text-sm font-medium">
            Name
        </label>

        <input
            v-model="form.name"
            type="text"
            class="w-full rounded border-gray-300"
        />

        <p
            v-if="form.errors.name"
            class="mt-1 text-sm text-red-600"
        >
            {{ form.errors.name }}
        </p>
    </div>


<div class="mb-6">
    <label class="block mb-2 text-sm font-medium">Email</label>

    <input
        v-model="form.email"
        type="email"
        class="w-full rounded border-gray-300"
    />
<p
    v-if="form.errors.email"
    class="mt-1 text-sm text-red-600"
>
    {{ form.errors.email }}
</p>
</div>

<div class="mb-6">
    <label class="block mb-2 text-sm font-medium">Department</label>

    <input
        v-model="form.department"
        type="text"
        class="w-full rounded border-gray-300"
    />
<p
    v-if="form.errors.department"
    class="mt-1 text-sm text-red-600"
>
    {{ form.errors.department }}
</p>
</div>

<div class="mb-6">
    <label class="block mb-2 text-sm font-medium">Position</label>

    <input
        v-model="form.position"
        type="text"
        class="w-full rounded border-gray-300"
    />
<p
    v-if="form.errors.position"
    class="mt-1 text-sm text-red-600"
>
    {{ form.errors.position }}
</p>
</div>

<div class="mb-6">
    <label class="block mb-2 text-sm font-medium">Contact Number</label>

    <input
        v-model="form.contact_no"
        type="text"
        class="w-full rounded border-gray-300"
    />
</div>

<div class="mb-6">
    <label class="block mb-2 text-sm font-medium">Role</label>

    <select
        v-model="form.role"
        class="w-full rounded border-gray-300"
    >
        <option value="admin">Admin</option>
        <option value="property_supply_officer">
            Property Supply Officer
        </option>
        <option value="technician">Technician</option>
        <option value="employee">Employee</option>
    </select>
</div>

<div class="mb-6">
    <label class="flex items-center gap-2">
        <input
            v-model="form.is_active"
            type="checkbox"
        />

        Active User
    </label>
</div>








<button
    type="submit"
    :disabled="form.processing"
    class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
>
    {{ form.processing ? 'Saving...' : 'Save Changes' }}
</button>



</form>





        </div>
    </MainLayout>
</template>
