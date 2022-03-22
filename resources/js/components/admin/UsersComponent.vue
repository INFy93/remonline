<template>
    <div>
        <h2 class="text-xl font-bold border-b border-gray-300">Пользователи</h2>
        <div class="mt-3">
            <add-user @add-user="getUsers"></add-user>
        </div>
        <edit-user
            @edit-event="getUsers"
            ref="openEditPopup"
        ></edit-user>
        <div v-if="!usersData.length">
            <img src="/storage/img/load_table.svg" style="margin: 0 auto" />
        </div>
         <table v-else class="w-full mt-3">
            <thead>
                <tr>
                     <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Имя
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Логин
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Роль
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        EMAIL
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Сервис
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Добавлен
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Последний вход
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        IP
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                 <tr
                    class="hover:bg-gray-200 transition-all duration-400"
                    v-for="user in usersData"
                    :key="user.id"
                >
                    <td
                        class="px-2 w-40 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                    <a
                    href="#"
                    v-if="user_id != user.id"
                    class="text-blue-600 hover:underline"
                    @click.prevent="openUser(user.id)"
                    >
                        {{ user.name }}
                    </a>
                    <span v-else>{{ user.name }}</span>
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                       <strong>{{ user.login }}</strong>
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ user.roles.role_slug }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ user.email }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ user.services.service_name }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ dateFormat(user.created_at) }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ user.last_login == null ? 'Не заходил' : dateFormat(user.last_login)  }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        {{ user.last_login_ip == null ? '-' : user.last_login_ip  }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        <a href="#"
                        class="flex space-x-1 text-blue-600 hover:underline"
                        onclick="confirm('Удалить пользователя?') || event.stopImmediatePropagation()"
                        @click.prevent="deleteUser(user.id)"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Удалить</span>
                        </a>
                    </td>
                 </tr>
            </tbody>
         </table>
    </div>
</template>
<script>
import _ from "lodash";
import axios from "axios";
import moment, { duration } from "moment";
import { useToast } from "vue-toastification";
moment.locale("ru");
export default {
    setup() {
        const toast = useToast();
        return {
            toast,
        }
    },
    data: function () {
        return {
            usersData: {},
            user_id: window.Laravel.user.id,
        };
    },
    watch: {

    },
    components: {
    },
    created() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            axios.get("/dashboard/users/all").then(response => {
               this.usersData = response.data
            })
        },
        deleteUser(id) {
            axios.get("dashboard/user/delete/" + id).then(response => {
                this.toast.warning("Пользователь удален успешно!")
                this.getUsers();
            })
        },
        openUser(id) {
            this.$refs.openEditPopup.editUser(id);
            //console.log(this.order_id)
        },
        dateFormat: function (value) {
            if (value) {
                return moment(String(value))
                    .format("lll", { trim: false, useGrouping: false })
                    .replace(/,/g, "");
            }
        }
    },
};
</script>

