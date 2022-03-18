<template>
    <div>
        <h2 class="text-xl font-bold border-b border-gray-300">Пользователи</h2>
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
                        Добавлен
                    </th>
                    <th
                        class="px-2 py-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Последний вход
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
                        {{ user.name }}
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
                        {{ dateFormat(user.created_at) }}
                    </td>
                    <td
                        class="px-2 py-3 text-sm whitespace-no-wrap border-b border-gray-200"
                    >
                        Потом добавлю
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
moment.locale("ru");
export default {
    data: function () {
        return {
            usersData: {},
        };
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
               console.log(this.usersData)
            })
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

