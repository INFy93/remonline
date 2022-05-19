<template>

  <Pie :chart-data="chartData" :chart-options="chartOptions" :width="400" :height="400" />
</template>

<script>
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Pie },
   setup() {
      const chartOptions = {
      responsive: true,
      maintainAspectRatio: false
    }
   },
  data() {
    return {
      chartOptions: {
      responsive: true,
      maintainAspectRatio: false
      },
      chartData: {
        labels: [ 'Открытые заказы', 'Выполненные заказы', 'Закрытые заказы'],
        datasets: [
          {
            label: 'Data One',
            backgroundColor: ['#3f83f8', '#1f2937', '#4b5563'],
            data: [40, 20, 12]
          }
        ]
      }
    }
  }
}
</script>
