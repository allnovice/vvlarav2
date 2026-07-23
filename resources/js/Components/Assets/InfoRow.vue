<script setup>

const props = defineProps({
    label: String,
    value: [String, Number],
    type: {
        type: String,
        default: 'text',
    },
})

const displayValue = () => {

    if (
        props.value === null ||
        props.value === undefined ||
        props.value === ''
    ) {
        return 'N/A'
    }

    if (props.type === 'currency') {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
        }).format(props.value)
    }

    if (props.type === 'date') {
        return new Date(props.value).toLocaleDateString('en-PH', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        })
    }

    return props.value
}

</script>

<template>
    <div class="grid grid-cols-3 gap-4 border-b border-gray-200 px-4 py-3 dark:border-gray-700">

        <div class="font-medium text-gray-600 dark:text-gray-400">
            {{ label }}
        </div>

        <div class="col-span-2 text-gray-900 dark:text-gray-100">
            <slot>
                {{ displayValue() }}
            </slot>
        </div>
    </div>
    
</template>
