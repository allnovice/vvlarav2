<script setup>
import { computed } from 'vue'
import { Bar } from 'vue-chartjs'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
)

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
})

const monthNames = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
]

const chartData = computed(() => {
    const totals = Array(12).fill(0)

    props.data.forEach(item => {
        totals[item.month - 1] = item.total
    })

    return {
        labels: monthNames,
        datasets: [
            {
                label: 'Verifications',
                data: totals,
            },
        ],
    }
})
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
}
</script>

<template>
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 p-6 h-80">
        <h3 class="text-lg font-semibold mb-4">
            Monthly Verifications
        </h3>

        <Bar
            :data="chartData"
            :options="chartOptions"
        />
    </div>
</template>
