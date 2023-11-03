<script setup>
const props = defineProps({
    data: Object
})

const series = ref([])
const chartOptions = ref({
    chart: {
        width: '100%',
        type: 'pie',
    },
    labels: [],
    theme: {
        monochrome: {
            enabled: true
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                offset: -5
            }
        }
    },
    title: {
        text: "在留資格"
    },
    dataLabels: {
        formatter(val, opts) {
            const name = opts.w.globals.labels[opts.seriesIndex]
            return [name, val.toFixed(1) + '%']
        }
    },
    legend: {
        show: false
    }
})
onMounted(() => {
    Object.keys(props.data).forEach(i => {
        chartOptions.value.labels.push(i)
        series.value.push(props.data[i])
    })
})
</script>
<template>
    <div>
        <apexchart type="pie" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>

