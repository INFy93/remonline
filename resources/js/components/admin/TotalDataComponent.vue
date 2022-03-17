<template>
    <div>
        <h2 class="text-xl font-bold border-b border-gray-300">Общие сведения</h2>
        <div class="mt-2">
        <p class="flex">Всего заказов: <img v-if="!Object.keys(totalData).length" src="/storage/img/load_table.svg" style="width: 24px;"><span class="font-bold pl-1"> {{ totalData.all }}</span>, из них:</p>
        <p class="flex"><img v-if="!Object.keys(totalData).length" src="/storage/img/load_table.svg" style="width: 24px;"><span class="font-bold">{{ totalData.open }}</span> <span class="pl-1">{{ wordsFormat(totalData.open, ['открыт', 'открыто', 'открыто']) }}</span></p>
        <p class="flex"><img v-if="!Object.keys(totalData).length" src="/storage/img/load_table.svg" style="width: 24px;"><span class="font-bold">{{ totalData.current }}</span><span class="pl-1"> в работе</span></p>
        </div>

    </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";

export default {
    data: function () {
        return {
            totalData: {}
        };
    },
    components: {
    },
    created() {
        this.getData();
    },
    methods: {
        getData() {
            console.log(this.totalData.length)
            axios.get("/dashboard/total").then((response) => {
                this.totalData = response.data
                console.log(Object.keys(this.totalData).length)
            })
        },
        wordsFormat: function (number, titles) {
            let cases = [2, 0, 1, 1, 1, 2];
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
        },
    },
};
</script>
