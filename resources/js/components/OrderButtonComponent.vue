<template>
    <div>
        <a class="update-button">
            <button
                @click="openModal"
                class="flex items-start bg-green-500 hover:bg-green-700 dark:bg-blue-900 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                </svg>
                Заказ
            </button>
        </a>
        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal">
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="min-h-screen px-4 text-center">
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <DialogOverlay
                                class="bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0"
                            />
                        </TransitionChild>

                        <span
                            class="inline-block h-screen align-middle"
                            aria-hidden="true"
                        >
                            &#8203;
                        </span>

                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <div
                                class="inline-block w-full max-w-screen-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                            >
                                <div
                                    class="flex justify-between items-start mb-2 rounded-t border-b dark:border-gray-600"
                                >
                                    <DialogTitle
                                        as="h2"
                                        class="text-xl font-medium leading-6 text-gray-900"
                                    >
                                        Добавить заказ
                                    </DialogTitle>
                                </div>
                                <form class="mt-6">
                                    <div class="mb-6">
                                        <label
                                            for="client_login"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Логин (или ФИО, если не наш
                                            абон)*</label
                                        >
                                        <input
                                            type="text"
                                            v-model="val.new_order.client_login.$model"
                                            @keyup="searchLogins"
                                            id="cleint_login"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            :class="{'border-red-400' : val.new_order.client_login.$error}"
                                            placeholder="Логин или имя клиента"
                                            required
                                        />
                                        <div v-if="val.new_order.client_login.$error" class="text-sm text-red-500">Необходимо ввести логин или ФИО клиента.</div>

                                <Menu>

                                <MenuItems :static="show"
                                    v-if="clientData.length"
                                    class="absolute z-10 w-96 mt-1 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-for="client in clientData"
                                        :key="client.id">
                                            <a
                                                href="#"
                                                status_id="1"
                                                @click.stop.prevent
                                                @click="
                                                    autoComplete(client.client_login, client.client_phone)
                                                "
                                                class="flex flex-row  py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                >
                                                <span class="justify-start">{{client.client_login}}</span>
                                                <span class="ml-auto" >{{client.client_phone}}</span>
                                            </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                                </Menu>
                                 </div>
                                    <div class="mb-6">
                                        <label
                                            for="clent_phone"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Телефон*</label
                                        >
                                        <input
                                            v-maska="'+7 (###) ###-##-##'"
                                            type="tel"
                                            v-model="val.new_order.client_phone.$model"
                                            id="clent_phone"
                                            name="phone"
                                            required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            :class="{'border-red-400' : val.new_order.client_phone.$error}"
                                            placeholder="Телефон"
                                        />
                                        <div v-if="val.new_order.client_phone.$error" class="text-sm text-red-500">Необходимо ввести телефон.</div>
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="product"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Тип устройства*</label
                                        >
                                        <input
                                            type="text"
                                            v-model="val.new_order.product.$model"
                                            id="product"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            :class="{'border-red-400' : val.new_order.product.$error}"
                                            placeholder="ПК, нотубук, роутер..."
                                        />
                                        <div v-if="val.new_order.product.$error" class="text-sm text-red-500">Необходимо ввести тип устройства.</div>
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="model"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Бренд*</label
                                        >
                                        <input
                                            type="text"
                                            v-model="val.new_order.model.$model"
                                            id="model"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            :class="{'border-red-400' : val.new_order.model.$error}"
                                            placeholder="Asus, Acer, черный/белый/.. сис"
                                        />
                                        <div v-if="val.new_order.model.$error" class="text-sm text-red-500">Необходимо ввести модель.</div>
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="model_full_name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Модель</label
                                        >
                                        <input
                                            type="text"
                                            v-model="new_order.model_full_name"
                                            id="model_full_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="B500, RB950Ui..."
                                        />
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="malfunction"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Неисправность*</label
                                        >
                                        <div class="flex space-x-2">
                                                    <a href="#" @click="addMalfunction" class="text-sm text-blue-600 hover:underline">Перенастройка ОС</a>
                                                    <a href="#" @click="addMalfunction" class="text-sm text-blue-600 hover:underline">Черный экран</a>
                                                    <a href="#" @click="addMalfunction" class="text-sm text-blue-600 hover:underline">Не включается</a>
                                        </div>
                                        <textarea
                                            v-model="val.new_order.malfunction.$model"
                                            id="malfunction"
                                            rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            :class="{'border-red-400' : val.new_order.malfunction.$error}"
                                            placeholder="Перенастройка ОС и так далее..."
                                        ></textarea>
                                        <div v-if="val.new_order.malfunction.$error" class="text-sm text-red-500">Необходимо ввести что с устройством случилось.</div>
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="appearance"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Внешний вид</label
                                        >
                                        <input
                                            type="text"
                                            v-model="new_order.appearance"
                                            id="appearance"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        />
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="product_complection"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Комплектация</label
                                        >
                                        <div class="flex space-x-2">
                                                    <a href="#" @click="addComplection" class="text-sm text-blue-600 hover:underline">Ноут + зарядка</a>
                                                    <a href="#" @click="addComplection" class="text-sm text-blue-600 hover:underline">Ноут + зарядка + сумка</a>
                                                    <a href="#" @click="addComplection" class="text-sm text-blue-600 hover:underline">Ноут без зарядки</a>
                                                    <a href="#" @click="addComplection" class="text-sm text-blue-600 hover:underline">Полная</a>
                                                    <a href="#" @click="addComplection" class="text-sm text-blue-600 hover:underline">Со шнуром</a>
                                        </div>
                                        <textarea
                                            v-model="
                                                new_order.product_complection
                                            "
                                            id="product_complection"
                                            rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Ноут + зарядка и тд..."
                                        ></textarea>
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="marks"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Заметки</label
                                        >
                                        <textarea
                                            v-model="new_order.marks"
                                            id="marks"
                                            rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Какую ОС ставить или комменты о клиенте :)"
                                        ></textarea>
                                    </div>
                                </form>
                                <div class="mt-4 flex space-x-4 float-right">
                                    <button
                                        type="button"
                                        class="inline-flex justify-items-end px-4 py-2 text-sm font-medium text-blue-900 bg-red-300 border border-transparent rounded-md hover:bg-red-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500"
                                        @click="closeModal"
                                    >
                                        Закрыть
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex justify-end px-4 py-2 text-sm font-medium text-blue-900 bg-blue-300 border border-transparent rounded-md hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500"
                                        @click="addOrder"
                                    >
                                        Добавить
                                    </button>
                                </div>
                            </div>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useToast } from "vue-toastification";
import { Menu, MenuItems, MenuItem } from "@headlessui/vue";
import { required, email } from '@vuelidate/validators'
import useVuelidate from '@vuelidate/core'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
    DialogTitle,
} from "@headlessui/vue";
export default {
    components: {
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogOverlay,
        DialogTitle,
        MenuItems,
        MenuItem,
        Menu
    },
    setup() {
        const isOpen = ref(false);
        // Get toast interface
        const toast = useToast();
        return {
            isOpen,
            closeModal() {
                isOpen.value = false;
            },
            openModal() {
                isOpen.value = true;
            },
            toast,
            val: useVuelidate()
        };
    },
    validations () {
        return {
            new_order: {
                client_login: {required},
                client_phone: {required},
                product: {required},
                model: {required},
                malfunction: {required}
            }
        }
    },
    data: function () {
        return {
            new_order: {
                client_login: "",
                client_phone: "",
                product: "",
                model: "",
                model_full_name: "",
                product_complection: "",
                malfunction: "",
                appearance: "Царапины, потертости",
                marks: "",
                manager_id: window.Laravel.user.id
            },
            phone: "",
            show: false,
            clientData: {}
        };
    },
    methods: {
        addOrder() {
            this.val.$touch();
             if (this.val.$pending || this.val.$error) return this.toast.error("Не все поля заполнены!");
            axios
                .post("/add_order", {
                    order: this.new_order,
                })
                .then((response) => {

                    this.closeModal();
                    this.new_order.client_login = ""
                    this.new_order.client_phone = ""
                    this.new_order.product = ""
                    this.new_order.model = ""
                    this.new_order.model_full_name = ""
                    this.new_order.product_complection = ""
                    this.new_order.malfunction = ""
                    this.new_order.appearance = "Царапины, потертости"
                    this.new_order.marks = ""
                    this.$emit("add-event");
                    this.toast.success("Заказ успешно добавлен!");
                });
        },
        searchLogins: _.debounce(function () {
            if (this.new_order.client_login.length >= 3)
            {
                this.show = true
                axios.get("/search_client?q=" + this.new_order.client_login).then((response) => {
                this.clientData = response.data.client;
                })
            } else {
                this.show = false
            }
            console.log(this.show)
        }),
        autoComplete(login, phone)
        {
            this.new_order.client_login = login
            this.new_order.client_phone = phone
            this.show = false
        },
        addMalfunction(event) {
            this.new_order.malfunction = event.target.innerHTML
        },
        addComplection(event) {
            this.new_order.product_complection = event.target.innerHTML
        },
    },
};
</script>
