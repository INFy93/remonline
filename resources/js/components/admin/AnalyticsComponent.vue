<template>
    <div class="flex justify-center items-center space-x-2 mb-3">
        <div class="form-check form-check-inline">
            <input
                class="mt-1 form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-1 cursor-pointer"
                type="radio"
                name="inlineRadioOptions"
                id="inlineRadio1"
                value="all"
                v-model="selService"
            />
            <label
                class="form-check-label inline-block text-gray-800"
                for="inlineRadio10"
                >Все сервисы</label
            >
        </div>
        <div v-for="service in services" :key="service.id" class="form-check form-check-inline">
            <input
                class="mt-1 form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-1 cursor-pointer"
                type="radio"
                name="inlineRadioOptions"
                id="inlineRadio1"
                :value="service.id"
                v-model="selService"
                :checked="selService == service.id"
            />
            <label
                class="form-check-label inline-block text-gray-800"
                for="inlineRadio10"
                >{{ service.service_name }}</label
            >
        </div>

    </div>
    <Pie
        :chart-data="chartData"
        :chart-options="chartOptions"
        :width="400"
        :height="400"
    />
</template>

<script>
import { Pie } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import axios from "axios";
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale
);

export default {
    name: "PieChart",
    components: { Pie },
    data() {
        return {
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
            },
            chartData: {},
            services: {},
            selService: 1,
        };
    },
    watch: {
        selService: function(value) {
            this.getAnalyticsData();
        }
    },
    created() {
        axios.get("/services").then((response) => {
            this.services = response.data;
        });
        this.getAnalyticsData();
    },
    methods: {
        getAnalyticsData() {
            axios.get("/dashboard/analytics?service=" + this.selService).then((response) => {
                this.chartData = response.data;
                console.log(response.data)
            });
        },
    },
};
</script>
