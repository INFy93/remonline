<template>
    <div class="flex justify-end items-center ml-auto">
        <div class="wrapper w-36 bg-gray-700 rounded-lg cursor-pointer" :class="{'bg-gray-500': isOpen}" @click="showOnlyOpen">
            <div  class="flex text-white rounded-lg py-2 px-2 space-x-3 justify-left  items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-xl" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
            </div>
            <div class="pr-3">
                <span class="font-medium">{{ openOrders }} {{ declOfNum(openOrders, ['заказ', 'заказа', 'заказов']) }}</span>
                <br>
                <span >{{ declOfNum(openOrders, ['открыт', 'открыто', 'открыто']) }}</span>
            </div>
            </div>

        </div>

    </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";
import { ContentLoader, BulletListLoader } from 'vue-content-loader';
export default {
    data: function () {
        return {
            openOrders: null,
            isOpen: false
        };
    },
    components: {
        ContentLoader,
        BulletListLoader
    },
    created() {
        this.getOpenOrders();
    },
    methods: {
        getOpenOrders() {
            axios.get("/open_orders").then((response) => {
                if (response.data !== '0')
                {
                    this.openOrders = response.data;
                } else
                {
                    this.openOrders = 0
                }
            });
        },
        showOnlyOpen() {
            this.isOpen = !this.isOpen
            this.$emit('showOpen', this.isOpen)
        },
        declOfNum(number, titles) {
            let cases = [2, 0, 1, 1, 1, 2];
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
        }
    },
};
</script>
