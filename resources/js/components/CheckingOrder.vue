<template>
    <div class="grid grid-cols-1 justify-items-center">
        <div class="mt-4 ml-4" style="width: 25rem;">
            <label
                for="product"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                >Введите код заказа</label
            >
            <input
                type="text"
                v-model.lazy="val.orderCode.$model"
                class="w-52 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                :class="{ 'border-red-400': val.orderCode.$error }"
                placeholder="6-значный код"
            />
            <div v-for="(error, index) of val.orderCode.$errors" :key="index">
                <div class="text-sm text-red-500">{{ error.$message }}</div>
            </div>

            <a class="update-button">
                <button
                    @click="checkOrderStatus"
                    class="flex mt-3 items-start bg-green-500 hover:bg-green-700 dark:bg-blue-900 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                    Проверить
                </button>
            </a>

            <div v-if="order.id" class="mt-5" style="width: 25rem;">
                <p><strong>Сервис:</strong> {{ order.services.service_name}}</p>
                <p><strong>Номер заказа:</strong> {{ order.services.service_code }}-{{ leadingZeros(order.id) }}</p>
                <p><strong>Время приема:</strong> {{ dateFormat(order.created_at) }}</p>
                <p><strong>Последнее изменение статуса:</strong> {{ dateFormat(order.updated_at) }}</p>
                <p><strong>Статус:</strong> {{ order.statuses.name }}</p>
            </div>
            <div v-if="noOrder" class="mt-5 text-sm text-red-500" style="width: 25rem;">Заказ не найден. Проверьте правильность ввода кода заказа. </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { required, maxLength, minLength, helpers } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import moment, { duration } from "moment";
moment.locale("ru");
export default {
    data: function () {
        return {
            val: useVuelidate(),
            order: {},
            orderCode: "",
            noOrder: false,
        };
    },
    components: {},
    setup() {
        return {};
    },
    validations: {
        orderCode: {
            required: helpers.withMessage(
                "Необходимо заполнить поле",
                required
            ),
            max: helpers.withMessage("Длина кода - 6 символов", maxLength(6)),
            min: helpers.withMessage("Длина кода - 6 символов", minLength(6)),
        },
    },
    created() {},
    methods: {
        checkOrderStatus() {
            this.val.$validate();
            if (this.val.$pending || this.val.$error) return;
            this.noOrder = false
            axios.get("/client/order/" + this.orderCode).then((response) => {
                this.order = response.data;

                if (!Object.keys(this.order).length) {
                    this.noOrder = true
                }
            });
        },
        leadingZeros(number) {
            return number.toString().padStart(5, '0')
        },
          dateFormat: function (value) {
            if (value) {
                return moment(String(value))
                    .format("lll", { trim: false, useGrouping: false })
                    .replace(/,/g, "");
            }
        },
    },
};
</script>
