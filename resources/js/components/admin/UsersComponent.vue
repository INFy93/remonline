<template>
    <div>
        <h2 class="text-xl font-bold border-b border-gray-300">Пользователи</h2>
    </div>
</template>
<script>
import _ from "lodash";
import axios from "axios";
export default {
    data: function () {
        return {
            usersData: {},
        };
    },
    components: {
    },
    created() {
        getUsers();
    },
    methods: {

    },
};
</script>

