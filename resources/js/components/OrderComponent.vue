<template>
    <div>
        <open-orders-component ref="open"></open-orders-component>
        <div class="mb-5 mt-3 flex flex-row">
            <div>
                <button-component @add-event="getOrders"></button-component>
            </div>
            <div class="flex justify-end items-center ml-auto space-x-5">
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
        <edit-order-component
            @edit-event="getOrders"
            ref="openEditPopup"
        ></edit-order-component>
        <div class="flex items-center space-x-3">
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
            <div class="mb-2" v-if="checked.length">
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
                                <MenuItem v-if="!selectPage">
                                    <a
                                        href="#"
                                        onclick="confirm('Удалить выбранные заказы?') || event.stopImmediatePropagation()"
                                        status_id="1"
                                        @click.prevent="deleteOrders"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >Удалить</a
                                    >
                                </MenuItem>
                                <MenuItem>
                                    <a
                                        :href="url"
                                        status_id="2"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >Экспортировать</a
                                    >
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
        <div v-if="selectPage">
            <div class="mb-2" v-if="selectAll">
                {{
                    declOfNum(checked.length, ["Выбран", "Выбрано", "Выбрано"])
                }}
                <strong>{{ checked.length }}</strong>
                {{
                    declOfNum(checked.length, ["заказ", "заказа", "заказов"])
                }}
                (это все, что есть...).
            </div>
            <div class="mb-2" v-else>
                {{
                    declOfNum(checked.length, ["Выбран", "Выбрано", "Выбрано"])
                }}
                <strong>{{ checked.length }}</strong>
                {{ declOfNum(checked.length, ["заказ", "заказа", "заказов"]) }}.
                Выбрать все <strong>{{ ordersData.total }}</strong
                >?
                <a
                    href="#"
                    @click.prevent="selectAllOrders"
                    class="text-blue-600 hover:underline hover:text-blue-700"
                    >Выбрать</a
                >
            </div>
        </div>
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
                </tr>
            </thead>

            <tbody class="bg-white">
                <tr
                    class="number hover:bg-gray-200 transition-all duration-400"
                    @dblclick="openEdit(order.id)"
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
                        I-{{ order.id }}
                    </td>

                    <td
                        class="px-2 w-52 py-1 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="px-4 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-lg text-white"
                                    :class="'bg-' + order.statuses.color"
                                >
                                    {{ order.statuses.name }}
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
                                                status_id="1"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(1, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >Новый</a
                                            >
                                        </MenuItem>
                                        <MenuItem>
                                            <a
                                                href="#"
                                                status_id="2"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(2, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >В работе</a
                                            >
                                        </MenuItem>
                                    </div>
                                    <div class="px-1 py-1">
                                        <MenuItem>
                                            <a
                                                href="#"
                                                status_id="3"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(3, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >На согласовании</a
                                            >
                                        </MenuItem>
                                        <MenuItem>
                                            <a
                                                href="#"
                                                ref="status4"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(4, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >Ждет запчасть</a
                                            >
                                        </MenuItem>
                                    </div>
                                    <div class="px-1 py-1">
                                        <MenuItem>
                                            <a
                                                href="#"
                                                status_id="5"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(5, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >Готов</a
                                            >
                                        </MenuItem>
                                        <MenuItem>
                                            <a
                                                href="#"
                                                status_id="6"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(6, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >Закрыт</a
                                            >
                                        </MenuItem>
                                    </div>
                                    <div class="px-1 py-1">
                                        <MenuItem>
                                            <a
                                                href="#"
                                                status_id="7"
                                                @click.stop.prevent
                                                @click="
                                                    change_status(7, order.id)
                                                "
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >Отказ</a
                                            >
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
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
                        class="px-2 py-1 w-96 text-sm whitespace-no-wrap text-gray-700 border-b border-gray-200"
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
                </tr>
            </tbody>
        </table>
        <div>
            <Pagination
                :data="ordersData"
                :limit="5"
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
import axios from "axios";
import { useToast } from "vue-toastification";
import moment, { duration } from "moment";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/solid";
import OpenOrdersComponent from "./OpenOrdersComponent.vue";
import EditOrderComponent from "./EditOrderComponent.vue";
import { ContentLoader, BulletListLoader } from "vue-content-loader";
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
            search: "",
            order_id: "",
            services: {},
            selectedService: window.Laravel.user.service_id,
            s_id: "",
            checked: [],
            selectPage: false,
            selectAll: false,
            url: "",
        };
    },
    components: {
        Pagination: LaravelVuePagination,
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        ChevronDownIcon,
        OpenOrdersComponent,
        ContentLoader,
        BulletListLoader,
    },
    created() {
        axios.get("/services").then((response) => {
            this.services = response.data;
        });
        this.getOrders();
    },
    watch: {
        search: function (value) {
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
        checked: function(value) {
            this.url = "/orders/export/" + this.checked;
        }
    },
    methods: {
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
                        this.selectedService
                )
                .then((response) => {
                    this.ordersData = response.data;
                    console.log(response.data);
                });
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
        change_status(status_id, rem_id) {
            axios
                .post("/change_status", {
                    status_id: status_id,
                    rem_id: rem_id,
                    user_id: window.Laravel.user.id,
                })
                .then((response) => {
                    this.$refs.open.getOpenOrders();
                    this.getOrders(1);
                });
        },
        dateFormat: function (value) {
            if (value) {
                return moment(String(value))
                    .format("lll", { trim: false, useGrouping: false })
                    .replace(/,/g, "");
            }
        },
        openEdit(id) {
            this.$refs.openEditPopup.openToEdit(id);
            this.order_id = id;
            //console.log(this.order_id)
        },
        declOfNum(number, titles) {
            let cases = [2, 0, 1, 1, 1, 2];
            return titles[
                number % 100 > 4 && number % 100 < 20
                    ? 2
                    : cases[number % 10 < 5 ? number % 10 : 5]
            ];
        },
    },
};
</script>
