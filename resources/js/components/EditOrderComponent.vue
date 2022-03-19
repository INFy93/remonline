<template>
    <div>
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
                                        class=" flex-start text-xl font-medium leading-6 text-gray-900"
                                    >
                                        Редактировать заказ: {{order.client_login}}

                                    </DialogTitle>
                                    <div id="printMe" class="hidden">
                                        <print-component :userdata="order"></print-component>
                                    </div>
                                    <div class="mb-2 space-x-4 float-right">
                                    <button
                                        type="button"
                                        class="inline-flex justify-items-end px-4 py-2 text-sm font-medium text-blue-900 bg-blue-300 border border-transparent rounded-md hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500"
                                        @click="print"
                                    >
                                        Печать
                                    </button>
                                        </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="mt-6">
                                        <form>
                                            <div class="mb-6">
                                                <label
                                                    for="client_login"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >Логин (или ФИО, если не наш
                                                    абон)*</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="order.client_login"
                                                    @keyup="searchLogins"
                                                    id="cleint_login"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Логин или имя клиента"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-6">
                                                <label
                                                    for="clent_phone"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >Телефон*</label
                                                >
                                                <input
                                                    v-maska="
                                                        '+7 (###) ###-##-##'
                                                    "
                                                    type="tel"
                                                    v-model="order.client_phone"
                                                    id="clent_phone"
                                                    name="phone"
                                                    required
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Телефон"
                                                />
                                            </div>
                                            <div class="mb-6">
                                                <label
                                                    for="product"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >Тип устройства*</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="order.product"
                                                    id="product"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    required
                                                    placeholder="ПК, нотубук, роутер..."
                                                />
                                            </div>
                                            <div class="mb-6">
                                                <label
                                                    for="model"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >Бренд*</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="order.model"
                                                    id="model"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    required
                                                    placeholder="Asus, Acer, черный/белый/.. сис"
                                                />
                                            </div>
                                            <div class="mb-6">
                                                <label
                                                    for="model_full_name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >Модель</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        order.model_full_name
                                                    "
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
                                                <textarea
                                                    v-model="order.malfunction"
                                                    id="malfunction"
                                                    rows="4"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Перенастройка ОС и так далее..."
                                                ></textarea>
                                            </div>
                                            <div class="mb-6">
                                                <label
                                                    for="appearance"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >Внешний вид</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="order.appearance"
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
                                                <textarea
                                                    v-model="
                                                        order.product_complection
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
                                                    v-model="order.marks"
                                                    id="marks"
                                                    rows="4"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Какую ОС ставить или комменты о клиенте :)"
                                                ></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-6 ml-3">
                                    История
                                     <div v-if="!story.length"> <img src="/storage/img/load_table.svg" style="width: 15%"> </div>
                                    <div v-else v-for="(event, i) in story" :key="event.id" class="text-sm">
                                        <div v-if="i == '0'" class="mt-2 mb-2">
                                            <div class="block ml-auto mr-auto">
                                                <span>
                                                    <strong>Cоздан:</strong>
                                                </span>
                                            </div>

                                            <span>
                                                <i>{{ event.users.name }}</i> -> {{ dateFormat(event.created_at) }}
                                            </span>
                                            <div class="mt-3"></div>
                                        </div>
                                       <div v-else class="mt-2 mb-2">
                                            <div class="block ml-auto mr-auto">
                                                <span>
                                                    <strong>{{ event.statuses.name }}</strong>
                                                </span>
                                            </div>

                                            <span>
                                                <i>{{ event.users.name }}</i> -> {{ dateFormat(event.created_at) }}
                                            </span>
                                        </div>

                                    </div>
                                    </div>
                                </div>
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
                                        @click="editOrder(order.id)"
                                    >
                                       Обновить
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
import moment, { duration } from "moment";
moment.locale("ru");
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
    DialogTitle,
} from "@headlessui/vue";
export default {
    data: function () {
        return {
            order: {
                client_login: "",
                client_phone: "",
                product: "",
                model: "",
                model_full_name: "",
                product_complection: "",
                malfunction: "",
                appearance: "Царапины, потертости",
                marks: "",
                id: "",
                created_at: ""
            },
            phone: "",
            show: false,
            clientData: {},
            order_id: "",
            story: {}
        };
    },
    components: {
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogOverlay,
        DialogTitle,
        MenuItems,
        MenuItem,
        Menu,
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
        };
    },
    methods: {
         dateFormat: function (value) {
            if (value) {
                return moment(String(value))
                    .format("lll", { trim: false, useGrouping: false })
                    .replace(/,/g, "");
            }
         },
        openToEdit(id) {
            this.story = {}
            this.openModal();
            axios.all([
                 axios.get("/order/edit/" + id),
                 axios.get("/order/story/" + id)
            ]).then(axios.spread((data1, data2) => {

            this.order.client_login = data1.data.client_login;
                this.order.client_phone = data1.data.client_phone;
                this.order.product = data1.data.product;
                this.order.model = data1.data.model;
                this.order.model_full_name = data1.data.model_full_name;
                this.order.product_complection =
                    data1.data.product_complection;
                this.order.malfunction = data1.data.malfunction;
                this.order.appearance = data1.data.appearance;
                this.order.marks = data1.data.marks;
                this.order.id = data1.data.id;
                this.order.created_at = data1.data.created_at;

                this.story = data2.data;
            }));
        },
        editOrder(id) {
            axios
                .post("/update_order", {
                    ord_id: id,
                    order: this.order,
                })
                .then((response) => {
                   // console.log(response)

                    this.closeModal();
                    this.order.client_login = "";
                    this.order.client_phone = "";
                    this.order.product = "";
                    this.order.model = "";
                    this.order.model_full_name = "";
                    this.order.product_complection = "";
                    this.order.malfunction = "";
                    this.order.appearance = "Царапины, потертости";
                    this.order.marks = "";
                    this.$emit("edit-event");
                    this.toast.success("Заказ успешно обновлен!");
                });
        },
        print() {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    }
    },
};
</script>
