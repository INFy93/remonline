<template>
    <div>
        <a class="update-button">
            <button
                @click="openModal"
                class="flex items-start w-48 bg-green-500 hover:bg-green-700 dark:bg-blue-900 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
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
                Пользователь
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
                                        Добавить пользователя
                                    </DialogTitle>
                                </div>
                                <form class="mt-6">
                                    <div class="mb-6">
                                        <label
                                            for="user_name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Имя пользователя*</label
                                        >
                                        <input
                                            type="text"
                                            v-model="userData.userName"
                                            id="user_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Имя и фамилия"
                                            required
                                        />
                                 </div>
                                    <div class="mb-6">
                                        <label
                                            for="user_login"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Логин*</label
                                        >
                                        <input
                                            id="clent_phone"
                                            v-model="userData.userLogin"
                                            name="user_login"
                                            required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Логин пользователя"
                                        />
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="user_email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >E-mail*</label
                                        >
                                        <input
                                            type="email"
                                            v-model="userData.userEmail"
                                            id="user_email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="E-mail пользователя"
                                            required
                                        />
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="user_pass"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Пароль*</label
                                        >
                                        <input
                                            type="password"
                                            v-model="userData.userPass"
                                            id="user_pass"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required
                                        />
                                    </div>
                                    <div class="mb-6">
                                        <label
                                            for="user_pass_confirm"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Подтверждение пароля*</label
                                        >
                                        <input
                                            type="password"
                                            v-model="userData.userConfirmPass"
                                            id="user_pass_confirm"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required
                                        />
                                    </div>
                                    <div class="mb-4">
                                        <label
                                            for="services"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Сервис</label
                                        >
                                        <select
                                            id="services"
                                            v-model="selectedService"
                                            class="h-10 w-44 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
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
                                    <div class="mb-4 border-t">
                                        <div class="mt-3">
                                            <input type="checkbox" v-model="userData.userIsAdmin" class="rounded focus:outline-none focus:ring dark:ring-offset-gray-600 dark:focus:ring-gray-500 border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-400">
                                            <span class="px-2">Администратор</span>
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <div>
                                            <input type="checkbox" class="rounded focus:outline-none focus:ring dark:ring-offset-gray-600 dark:focus:ring-gray-500 border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-400">
                                            <span class="px-2">Может получать уведомления на почту (пока еще заглушка)</span>
                                        </div>

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
                                        @click="addUser"
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
            userData: {
                userName: '',
                userLogin: '',
                userEmail: '',
                userPass: '',
                userConfirmPass: '',
                userIsAdmin: false
            },
            services: {},
            selectedService: 1
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
        };
    },
    created() {
         axios.get("/services").then((response) => {
            this.services = response.data;
        });
    },
    methods: {
        addUser() {
            if (this.userData.userPass != this.userData.userConfirmPass)
            {
                this.toast.error('Пароли не совпадают!')
            }
            else
            {
                axios.post("/dashboard/user/add", {
                    service: this.selectedService,
                    user: this.userData
                }).then(response => {
                    this.closeModal();
                    this.userData.userName = ''
                    this.userData.userLogin = ''
                    this.userData.userEmail = ''
                    this.userData.userPass = ''
                    this.userData.userConfirmPass = ''
                    this.userData.userIsAdmin = false
                    this.toast.success("Пользователь " + this.userData.userName + " успешно добавлен!")
                    this.$emit("add-user");
                })
            }
        }
    },
};
</script>
