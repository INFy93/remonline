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
                                class="inline-block w-full max-w-screen-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                            >
                                <div
                                    class="flex justify-between items-start mb-2 rounded-t border-b dark:border-gray-600"
                                >
                                    <DialogTitle
                                        as="h2"
                                        class="flex-start text-xl font-medium leading-6 text-gray-900"
                                    >
                                        Данные по заказу:
                                        {{ order.client_login }}
                                    </DialogTitle>
                                    <div class="mb-2 space-x-4 float-right">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="mt-2">
                                        <div v-if="!order.client_login">
                                                <img
                                                    src="/storage/img/load_table.svg"
                                                    style="width: 15%; margin: 0 auto;"
                                                />
                                            </div>
                                        <div v-else>
                                            <p>
                                                <span class="font-medium">Логин клиента:</span> {{ order.client_login }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Телефон:</span> {{ order.client_phone }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Тип устройства:</span> {{ order.product }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Бренд:</span> {{ order.model }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Модель:</span> {{ order.model_full_name == null ? '-' : order.model_full_name }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Неисправность:</span> {{ order.malfunction }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Внешний вид:</span> {{ order.appearance }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Комплектация:</span> {{ order.product_complection == null ? '-' : order.product_complection }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Заметки:</span> {{ order.marks == null ? '-' : order.marks }}
                                            </p>
                                        </div>
                                    </div>
                                        <div class="mt-2">
                                            <div v-if="!story.length">
                                                <img
                                                    src="/storage/img/load_table.svg"
                                                    style="width: 15%; margin: 0 auto;"
                                                />
                                            </div>
                                            <div
                                                v-else
                                                v-for="(event, i) in story"
                                                :key="event.id"
                                                class="text-sm"
                                            >
                                                <div
                                                    v-if="i == '0'"
                                                    class="mt-2 mb-2"
                                                >
                                                    <div
                                                        class="block ml-auto mr-auto"
                                                    >
                                                        <span>
                                                            <strong>Cоздан:</strong>
                                                        </span>
                                                    </div>

                                                    <span>
                                                        <i>{{
                                                            event.users.name
                                                        }}</i>
                                                        ->
                                                        {{
                                                            dateFormat(
                                                                event.created_at
                                                            )
                                                        }}
                                                    </span>
                                                    <div class="mt-3"></div>
                                                </div>
                                                <div v-else class="mt-2 mb-2">
                                                    <div
                                                        class="block ml-auto mr-auto"
                                                    >
                                                        <span>
                                                            <strong>{{
                                                                event.statuses.name
                                                            }}</strong>
                                                        </span>
                                                    </div>

                                                    <span>
                                                        <i>{{
                                                            event.users.name
                                                        }}</i>
                                                        ->
                                                        {{
                                                            dateFormat(
                                                                event.created_at
                                                            )
                                                        }}
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
            order: {},
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
        openToStory(id) {
            this.story = {}
            this.order = {}
            this.openModal();
            axios.all([
                 axios.get("/order/edit/" + id),
                 axios.get("/order/story/" + id)
            ]).then(axios.spread((data1, data2) => {

                this.order = data1.data;
                this.story = data2.data;
            }));
        },
    },
};
</script>
