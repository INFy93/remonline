<template>
    <main>
        <div class="py-3 bg-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 flex justify-between">
                        <div class="px-4 sm:px-0">
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-gray-400"
                            >
                                Персональные данные
                            </h3>
                            <p
                                class="mt-1 text-sm text-gray-600 dark:text-gray-500"
                            >
                                Сменить имя и e-mail
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form id="update_info">
                            <div
                                class="px-4 py-5 bg-white dark:bg-gray-600 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md"
                            >
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-4">
                                        <label
                                            class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                            for="name"
                                        >
                                            Имя
                                        </label>
                                        <input
                                            v-model="
                                                val.userData.userName.$model
                                            "
                                            class="border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                            :class="{
                                                'border-red-400':
                                                    val.userData.userName
                                                        .$error,
                                            }"
                                            id="name"
                                            type="text"
                                        />
                                        <div
                                            v-if="val.userData.userName.$error"
                                            class="text-sm text-red-500"
                                        >
                                            Необходимо заполнить поле.
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-4">
                                        <label
                                            class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                            for="email"
                                        >
                                            Email
                                        </label>
                                        <input
                                            v-model="
                                                val.userData.userEmail.$model
                                            "
                                            class="border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                            :class="{
                                                'border-red-400':
                                                    val.userData.userEmail
                                                        .$error,
                                            }"
                                            id="email"
                                            type="email"
                                        />
                                        <div
                                            v-if="val.userData.userEmail.$error"
                                            class="text-sm text-red-500"
                                        >
                                            Необходимо заполнить поле.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-600 border-t dark:border-gray-500 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
                            >
                                <div
                                    class="info_field text-sm text-gray-600 mr-3"
                                ></div>
                                <button
                                    @click.prevent="saveUser()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                >
                                    Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto mt-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 flex justify-between">
                        <div class="px-4 sm:px-0">
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-gray-400"
                            >
                                Смена пароля
                            </h3>
                            <p
                                class="mt-1 text-sm text-gray-600 dark:text-gray-500"
                            >
                                Пароль должен быть длиннее 8 символов и
                                использовать буквы разного регистра и специмволы
                                ("", - и тп).
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form id="update_info">
                            <div
                                class="px-4 py-5 bg-white dark:bg-gray-600 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md"
                            >
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-4">
                                        <label
                                            class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                            for="pass"
                                        >
                                            Новый пароль
                                        </label>
                                        <input
                                            v-model.lazy="val.userPass.$model"
                                            class="border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                            :class="{
                                                'border-red-400':
                                                    val.userPass.$error,
                                            }"

                                            id="pass"
                                            type="password"
                                        />
                                        <div
                                            v-for="(error, index) of val
                                                .userPass.$errors"
                                            :key="index"
                                        >
                                            <div class="text-sm text-red-500">
                                                {{ error.$message }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-4">
                                        <label
                                            class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                            for="confirm_pass"
                                        >
                                            Подтверждение
                                        </label>
                                        <input
                                            v-model.lazy="
                                                val.userConfirmPass.$model
                                            "
                                            class="border-gray-300 dark:border-gray-600 dark:bg-gray-500 dark:text-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                            :class="{
                                                'border-red-400':
                                                    val.userConfirmPass.$error,
                                                'border-red-400':
                                                   passwordsNotSame
                                            }"
                                            id="confirm_pass"
                                            type="password"
                                        />
                                        <div
                                            v-for="(error, index) of val
                                                .userConfirmPass.$errors"
                                            :key="index"
                                        >
                                            <div class="text-sm text-red-500">
                                                {{ error.$message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-600 border-t dark:border-gray-500 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
                            >
                                <div
                                    class="info_field text-sm text-gray-600 mr-3"
                                ></div>
                                <button
                                    @click.prevent="changePassword()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                >
                                    Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "axios";
import { useToast } from "vue-toastification";
import { required, minLength, helpers} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
export default {
    data: function () {
        return {
            val: useVuelidate(),
            userData: {
                userName: "",
                userEmail: "",
            },
            userPass: "",
            userConfirmPass: "",
        };
    },
    setup() {
        const toast = useToast();
        return {
            toast,
        };
    },
    validations() {
        return {
            userData: {
                userName: {required},
                userEmail: {required},
            },
            userPass: {
                required: helpers.withMessage("Необходимо заполнить поле", required),
                minLength: helpers.withMessage("Минимум 8 символов", minLength(8)),
            },
            userConfirmPass: {
                required: helpers.withMessage("Необходимо заполнить поле", required),
                minLength: helpers.withMessage("Минимум 8 символов", minLength(8)),
            },
        }
    },
    created() {
        this.getUser();
    },
    methods: {
        getUser() {
            axios.get("/user/" + window.Laravel.user.id).then((response) => {
                this.userData.userName = response.data.name;
                this.userData.userEmail = response.data.email;
            });
        },
        saveUser() {
           this.val.userData.userName.$touch();
           this.val.userData.userEmail.$touch();
             if (this.val.$pending || this.val.$error) return this.toast.error("Не все поля заполнены!");
            axios
                .post("/user/store", {
                    user_id: window.Laravel.user.id,
                    user: this.userData,
                })
                .then((response) => {
                    this.toast.success("Данные обновлены!");
                    this.getUser();
                });
        },
        changePassword() {
            this.passwordsNotSame = false
            this.val.userPass.$validate();
            this.val.userConfirmPass.$validate();
            if (this.val.$pending || this.val.$error) return;
            if (this.userPass != this.userConfirmPass) {
                this.toast.error("Пароли не совпадают!")
            } else
            {
                axios.post("/user/password/store", {
                    user_id: window.Laravel.user.id,
                    newPass: this.userPass
                }).then(response => {
                    this.toast.success("Пароль изменен!")
                })

            }

        }
    },
};
</script>
