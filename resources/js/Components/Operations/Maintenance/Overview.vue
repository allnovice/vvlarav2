<script setup>
import { ref, computed, watch, watchEffect } from 'vue'
import FilterSelect from '@/Components/Common/FilterSelect.vue'
import FilterSummary from '@/Components/Common/FilterSummary.vue'
import StatCard from '@/Components/Operations/Shared/StatCard.vue'
import AssetSearchInput from '@/Components/Assets/AssetSearchInput.vue'

const emit = defineEmits([
    'update:filteredAssets',
    'update:activeFilter',
])

const props = defineProps({
    assets: {
        type: Array,
        default: () => [],
    },
})

const department = ref('All')
const type = ref('All')
const year = ref('All')
const activeFilter = ref('all')
const search = ref('')
const departmentOptions = computed(() => [
    'All',
    ...new Set(
        props.assets
            .map(asset => asset.department)
            .filter(Boolean)
    ),
])

const typeOptions = computed(() => {
    let assets = props.assets

    if (department.value !== 'All') {
        assets = assets.filter(
            asset => asset.department === department.value
        )
    }

    return [
        'All',
        ...new Set(
            assets
                .map(asset => asset.type)
                .filter(Boolean)
        ),
    ]
})

const yearOptions = computed(() => {
    let assets = props.assets

    if (department.value !== 'All') {
        assets = assets.filter(
            asset => asset.department === department.value
        )
    }

    if (type.value !== 'All') {
        assets = assets.filter(
            asset => asset.type === type.value
        )
    }

    return [
        'All',
        ...new Set(
            assets
                .map(asset => asset.property_number?.substring(0, 4))
                .filter(Boolean)
        ),
    ].sort((a, b) => b.localeCompare(a))
})

const filteredAssets = computed(() => {
    let assets

    switch (activeFilter.value) {
        case 'neverMaintained':
            assets = props.assets.filter(
                asset => !asset.maintenance_date
            )
            break

        case 'dueSoon':
            assets = props.assets.filter(asset => {
                if (!asset.next_due_date) return false

                const due = new Date(asset.next_due_date)
                const today = new Date()
                const next30 = new Date()

                next30.setDate(today.getDate() + 30)

                return due >= today && due <= next30
            })
            break

        case 'overdue':
            assets = props.assets.filter(asset => {
                if (!asset.next_due_date) return false
                return new Date(asset.next_due_date) < new Date()
            })
            break

        case 'coverage':
            assets = props.assets.filter(
                asset => asset.next_due_date !== null
            )
            break

        default:
            assets = props.assets
    }

    if (department.value !== 'All') {
        assets = assets.filter(
            asset => asset.department === department.value
        )
    }

    if (type.value !== 'All') {
        assets = assets.filter(
            asset => asset.type === type.value
        )
    }

    if (year.value !== 'All') {
        assets = assets.filter(
            asset => asset.property_number?.substring(0, 4) === year.value
        )
    }

if (!search.value) {
    return assets
}

const q = search.value.toLowerCase()

return assets.filter(asset =>
    (asset.property_number ?? '').toLowerCase().includes(q) ||
    (asset.description ?? '').toLowerCase().includes(q) ||
    (asset.type ?? '').toLowerCase().includes(q) ||
    (asset.department ?? '').toLowerCase().includes(q)
)

})

const filteredStats = computed(() => {
    const assets = filteredAssets.value

    const neverMaintained = assets.filter(
        asset => !asset.maintenance_date
    ).length

    const dueSoon = assets.filter(asset => {
        if (!asset.next_due_date) return false

        const due = new Date(asset.next_due_date)
        const today = new Date()
        const next30 = new Date()

        next30.setDate(today.getDate() + 30)

        return due >= today && due <= next30
    }).length

    const overdue = assets.filter(asset => {
        if (!asset.next_due_date) return false

        return new Date(asset.next_due_date) < new Date()
    }).length

    const scheduled = assets.filter(
        asset => asset.next_due_date
    ).length

    const coverage = assets.length
        ? Math.round((scheduled / assets.length) * 100)
        : 0

    return {
        total: assets.length,
        neverMaintained,
        dueSoon,
        overdue,
        coverage,
    }
})
watch(department, () => {
    type.value = 'All'
    year.value = 'All'
})

watch(type, () => {
    year.value = 'All'
})
watchEffect(() => {
    emit('update:filteredAssets', filteredAssets.value)
})
</script>
<template>
    
    <div class="space-y-4">
<AssetSearchInput
    v-model="search"
    placeholder="Search assets..."
/>

        <div class="mt-4 flex flex-wrap gap-4">
            <FilterSelect
                label="Department"
                v-model="department"
                :options="departmentOptions"
            />

            <FilterSelect
                label="Type"
                v-model="type"
                :options="typeOptions"
            />

            <FilterSelect
                label="Year"
                v-model="year"
                :options="yearOptions"
            />
        </div>

        <FilterSummary
            :count="filteredAssets.length"
            :filters="[
                { label: 'Department', value: department },
                { label: 'Type', value: type },
                { label: 'Year', value: year },
            ]"
        />

        <div class="grid grid-cols-5 gap-2">
            <StatCard
                title="Total Assets"
                :value="filteredStats.total"
                :active="activeFilter === 'all'"
                @click="activeFilter = 'all'"
            />

            <StatCard
                title="Never Maintained"
                :value="filteredStats.neverMaintained"
                :active="activeFilter === 'neverMaintained'"
                @click="activeFilter = 'neverMaintained'"
            />

            <StatCard
                title="Due Soon"
                :value="filteredStats.dueSoon"
                :active="activeFilter === 'dueSoon'"
                @click="activeFilter = 'dueSoon'"
            />

            <StatCard
                title="Overdue"
                :value="filteredStats.overdue"
                :active="activeFilter === 'overdue'"
                @click="activeFilter = 'overdue'"
            />

            <StatCard
                title="Coverage"
                :value="`${filteredStats.coverage}%`"
                :active="activeFilter === 'coverage'"
                @click="activeFilter = 'coverage'"
            />
        </div>

    </div>
</template>
