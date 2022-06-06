<template>
    <div>
        <div>
            <h2 class="text-xl font-bold border-b border-gray-300">
                Общие сведения
            </h2>
            <div class="mt-2">
                <p class="flex">
                    Всего заказов:
                    <img
                        v-if="!Object.keys(totalData).length"
                        src="/storage/img/load_table.svg"
                        style="width: 24px"
                    /><span class="font-bold pl-1"> {{ totalData.all }}</span
                    >, из них:
                </p>
                <p class="flex">
                    <img
                        v-if="!Object.keys(totalData).length"
                        src="/storage/img/load_table.svg"
                        style="width: 24px"
                    /><span class="font-bold">{{ totalData.open }}</span>
                    <span class="pl-1">{{
                        declOfNum(totalData.open, [
                            "открыт",
                            "открыто",
                            "открыто",
                        ])
                    }}</span>
                </p>
                <p class="flex">
                    <img
                        v-if="!Object.keys(totalData).length"
                        src="/storage/img/load_table.svg"
                        style="width: 24px"
                    /><span class="font-bold">{{ totalData.current }}</span
                    ><span class="pl-1"> в работе</span>
                </p>
            </div>
        </div>
        <h2 class="mt-3 text-xl font-bold border-b border-gray-300">Заказы</h2>
        <a href="dashboard/export_month" class="flex items-start w-80 space-x-1 mt-3 bg-green-500 hover:bg-green-700 dark:bg-blue-900 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                </svg>
                <span>Экспорт всех заказов за месяц</span>
        </a>
        <div class="flex flex-row items-center mt-3">
            <div
                v-if="ordersData.data"
                class="bg-white rounded right-0 flex items-center w-full max-w-xl h-10 mb-2 p-2 shadow-sm border border-gray-200"
            >
                <svg
                    class="w-5 text-gray-500 h-5 cursor-pointer"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    ></path>
                </svg>
                <input
                    type="text"
                    v-model="search"
                    name=""
                    id=""
                    placeholder="Поиск по логину, модели или полной модели (все сервисы)"
                    class="w-full pl-3 text-sm text-black border-transparent focus:border-transparent focus:ring-0 bg-transparent"
                />
            </div>
            <div class="flex items-center mb-2 ml-3">
                    <input
                            type="checkbox"
                            v-model="isOpen"
                            class="rounded focus:outline-none outline-none dark:ring-offset-gray-600 dark:focus:ring-gray-500 border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-400"
                        />
                    <span class="ml-2">Только открытые</span>
                </div>
            <div class="mb-2 ml-3" v-if="checked.length">
                <Menu as="div" class="relative inline-block text-left">
                    <div>
                        <MenuButton
                            class="px-4 py-2 inline-flex items-center text-base leading-5 font-semibold rounded-lg text-white bg-gray-700"
                        >
                            С отмеченными ({{ checked.length }}):
                            <ChevronDownIcon
                                class="w-5 h-5 ml-2 -mr-1"
                                aria-hidden="true"
                            />
                        </MenuButton>
                    </div>
                    <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                    >
                        <MenuItems
                            class="absolute z-10 left-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        >
                            <div class="px-1 py-1">
                                <MenuItem>
                                    <a
                                        href="#"
                                        onclick="confirm('Удалить выбранные заказы?') || event.stopImmediatePropagation()"
                                        status_id="1"
                                        @click.prevent="deleteOrders"
                                        class="flex space-x-1 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                        <span>Удалить</span></a
                                    >
                                </MenuItem>
                                <MenuItem>
                                    <a
                                        :href="url"
                                        status_id="2"
                                        class="flex space-x-1 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                        <span>Экспортировать</span></a
                                    >
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
            <div v-if="selectPage">
                <div class="mb-2 ml-2" v-if="selectAll">
                    {{
                        declOfNum(checked.length, [
                            "Выбран",
                            "Выбрано",
                            "Выбрано",
                        ])
                    }}
                    <strong>{{ checked.length }}</strong>
                    {{
                        declOfNum(checked.length, [
                            "заказ",
                            "заказа",
                            "заказов",
                        ])
                    }}
                    (это все, что есть...).
                </div>
                <div class="mb-2 ml-2" v-else>
                    {{
                        declOfNum(checked.length, [
                            "Выбран",
                            "Выбрано",
                            "Выбрано",
                        ])
                    }}
                    <strong>{{ checked.length }}</strong>
                    {{
                        declOfNum(checked.length, [
                            "заказ",
                            "заказа",
                            "заказов",
                        ])
                    }}. Выбрать все <strong>{{ ordersData.total }}</strong
                    >?
                    <a
                        href="#"
                        @click.prevent="selectAllOrders"
                        class="text-blue-600 hover:underline hover:text-blue-700"
                        >Выбрать</a
                    >
                </div>
            </div>

            <div class="flex justify-end items-center mb-2 ml-auto space-x-5">
                <label
                    for="services"
                    class="block text-m font-medium text-gray-900 dark:text-gray-400"
                    >Сервис</label
                >
                <select
                    id="services"
                    v-model="selectedService"
                    class="h-10 w-36 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option value="all" class="border-b border-gray-400">
                        Все сервисы
                    </option>
                    <option
                        v-for="service in services"
                        :key="service.id"
                        :value="service.id"
                        :selected="service.id == selectedService"
                    >
                        {{ service.service_name }}
                    </option>
                </select>
            </div>
        </div>
        <story ref="openStoryPopup"></story>
        <div v-if="!ordersData">
            <div
                class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                role="alert"
            >
                <span class="font-medium">Нет заказов!</span> Чтобы они
                появились, нужно нажать на кнопку выше (или попить чаёк)
            </div>
        </div>
        <div v-if="!ordersData.data">
            <img src="/storage/img/load_table.svg" style="margin: 0 auto" />
        </div>
        <table v-else class="w-full">
            <thead>
                <tr>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        <input
                            type="checkbox"
                            name=""
                            id=""
                            v-model="selectPage"
                            class="rounded focus:outline-none dark:ring-offset-gray-600 dark:focus:ring-gray-500 border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-400"
                        />
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        №
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Статус
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Создан
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Изделие
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Модель
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Комплектация
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Неисправность
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Клиент
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                       Сервис
                    </th>
                    <th
                        class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Действия
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white">
                <tr
                    class="number hover:bg-gray-200 transition-all duration-400"
                    v-for="order in ordersData.data"
                    :key="order.id"
                >
                    <td
                        class="px-2 w-12 py-2 font-medium text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        <input
                            type="checkbox"
                            :value="order.id"
                            v-model="checked"
                            class="rounded focus:outline-none outline-none dark:ring-offset-gray-600 dark:focus:ring-gray-500 border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-400"
                        />
                    </td>
                    <td
                        class="px-2 w-20 py-2 font-medium text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        <a
                            href=""
                            class="text-blue-600 hover:underline"
                            @click.prevent="openStory(order.id)"
                        >
                            {{ order.services.service_code }}-{{ leadingZeros(order.id) }}
                        </a>
                    </td>

                    <td
                        class="px-2 w-52 py-1 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ order.statuses.name }}
                    </td>

                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500"
                    >
                        <div class="flex items-center">
                            <div>
                                <div
                                    class="text-sm leading-5 font-medium text-gray-700"
                                >
                                    {{ order.users.name }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    {{ dateFormat(order.created_at) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
                    >
                        <div class="flex items-center">
                            <div>{{ order.product }}</div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500"
                    >
                        <div class="flex items-center">
                            <div>
                                <div
                                    class="text-sm leading-5 font-medium text-gray-700"
                                >
                                    {{ order.model }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    {{ order.model_full_name }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
                    >
                        <div class="flex items-center">
                            <div>{{ order.product_complection }}</div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
                    >
                        <div class="flex items-center">
                            <div>{{ order.malfunction }}</div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
                    >
                        <div class="flex items-center">
                            <div>
                                <div
                                    class="text-sm leading-5 font-medium text-gray-700"
                                >
                                    {{ order.client_login }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    {{ order.client_phone }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
                    >
                        <div class="flex items-center">
                            <div>{{ order.services.service_name }}</div>
                        </div>
                    </td>
                    <td
                        class="px-2 py-1 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
                    >
                        <div class="flex items-center">
                            <a
                                href="#"
                                class="flex space-x-1 text-blue-600 hover:underline"
                            >
                            </a>
                            <Menu
                                as="div"
                                class="relative inline-block text-left"
                            >
                                <div>
                                    <MenuButton
                                        class="flex space-x-1 text-blue-600 hover:underline"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"
                                            />
                                        </svg>
                                        <span>Перемещение</span>
                                    </MenuButton>
                                </div>
                                <transition
                                    enter-active-class="transition duration-100 ease-out"
                                    enter-from-class="transform scale-95 opacity-0"
                                    enter-to-class="transform scale-100 opacity-100"
                                    leave-active-class="transition duration-75 ease-in"
                                    leave-from-class="transform scale-100 opacity-100"
                                    leave-to-class="transform scale-95 opacity-0"
                                >
                                    <MenuItems
                                        class="absolute z-10 right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    >
                                        <div class="px-1 py-1">
                                            <MenuItem
                                                as="div"
                                                v-for="service in services"
                                                :key="service.id"
                                            >
                                                <a
                                                    href="#"
                                                    v-if="
                                                        service.id !=
                                                        order.service
                                                    "
                                                    onclick="confirm('Переместить заказ?') || event.stopImmediatePropagation()"
                                                    @click.prevent="switchService(order.id, service.id)"
                                                    class="flex space-x-1 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >
                                                    <span>{{
                                                        service.service_name
                                                    }}</span>
                                                </a>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <Pagination
                :data="ordersData"
                :limit="4"
                @pagination-change-page="getOrders"
            >
                <template #prev-nav>
                    <span>Пред.</span>
                </template>
                <template #next-nav>
                    <span>След.</span>
                </template>
            </Pagination>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import LaravelVuePagination from "laravel-vue-pagination";
import { useToast } from "vue-toastification";
import { ref } from "vue";
import axios from "axios";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/solid";
import moment, { duration } from "moment";
moment.locale("ru");
export default {
    setup() {
        const toast = useToast();
        return {
            toast,
        };
    },
    data: function () {
        return {
            ordersData: {},
            totalData: {},
            search: "",
            order_id: "",
            services: {},
            selectedService: "all",
            checked: [],
            selectPage: false,
            selectAll: false,
            url: "",
            isOpen: false
        };
    },
    watch: {
        search: function (value) {
            this.getOrders();
        },
        isOpen: function(value) {
            this.getOrders();
        },
        selectedService: function (value) {
            this.getOrders();
            this.selectPage = false;
            this.checked = [];
        },
        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.ordersData.data.forEach((order) => {
                    this.checked.push(order.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },
        checked: function (value) {
            this.url = "/orders/export/" + this.checked;
        },
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        ChevronDownIcon,
        Pagination: LaravelVuePagination,
    },
    created() {
        axios.get("/services").then((response) => {
            this.services = response.data;
        });
        this.getOrders();
        this.getData();
    },
    methods: {
        async getData() {
            await axios.get("/dashboard/total").then((response) => {
                this.totalData = response.data;
            });
        },
        selectAllOrders() {
            axios
                .get("/orders/selectAll?service=" + this.selectedService)
                .then((response) => {
                    // console.log(response.data);
                    this.checked = [];
                    this.checked = response.data;
                    this.selectAll = true;
                });
        },
        getOrders(page = 1) {
            axios
                .get(
                    "/orders/all?s=" +
                        this.s_id +
                        "&page=" +
                        page +
                        "&search=" +
                        this.search +
                        "&selectedService=" +
                        this.selectedService +
                         "&openOrders=" +
                         this.isOpen
                )
                .then((response) => {
                    this.ordersData = response.data;
                });
        },
        openStory(id) {
            this.$refs.openStoryPopup.openToStory(id);

            //console.log(this.order_id)
        },
        deleteOrders() {
            axios.get("/orders/massDelete/" + this.checked).then((response) => {
                if (response.status == 204) {
                    this.toast.success("Выбранные заказы успешно удалены.");
                    this.checked = [];
                    this.getOrders();
                } else {
                    this.toast.error("Ошибка удаления заказов.");
                }
            });
        },
        switchService(order_id, service_id) {
            axios.get("/dashboard/service/switch/" + order_id + "/" + service_id)
            .then(response => {
                this.getOrders()
                this.toast.success("Перемещение успешно завершено.")
            })
        },
        dateFormat: function (value) {
            if (value) {
                return moment(String(value))
                    .format("lll", { trim: false, useGrouping: false })
                    .replace(/,/g, "");
            }
        },
        declOfNum: function (number, titles) {
            let cases = [2, 0, 1, 1, 1, 2];
            return titles[
                number % 100 > 4 && number % 100 < 20
                    ? 2
                    : cases[number % 10 < 5 ? number % 10 : 5]
            ];
        },
        leadingZeros(number) {
            return number.toString().padStart(5, '0')
        },
    },
};
</script>
