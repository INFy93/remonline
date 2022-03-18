/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 import 'flowbite';

import { createApp } from 'vue'

import Maska from 'maska'

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
const options = {
    position: "top-right",
    transition: "Vue-Toastification__fade",
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
    rtl: false
};

import VueHtmlToPaper from './plugins/VueHtmlToPaper';
const p_options = {
    styles: [
        '/css/app.css',
      ]
}
import OrdersTable from './components/OrderComponent.vue';
import OrderButton from './components/OrderButtonComponent.vue';
import OpenOrders from './components/OpenOrdersComponent.vue';
import EditOrder from './components/EditOrderComponent.vue';
import Print from './components/PrintComponent.vue';

import Admin from './components/admin/AdminComponent.vue'
import Settings from './components/admin/SettingsComponent.vue'
import Story from './components/admin/StoryComponent.vue'
import Users from './components/admin/UsersComponent.vue'
import AddUser from './components/admin/AddUserComponent.vue'
import EditUser from './components/admin/EditUserComponent.vue'

const app = createApp({});
const admin = createApp({});

app.use(VueHtmlToPaper, p_options);

app.use(Maska);
app.use(Toast, options);

app.component('orders-component', OrdersTable);
app.component('button-component', OrderButton);
app.component('open-orders-component', OrderButton);
app.component('edit-order-component', EditOrder);
app.component('print-component', Print);
app.mount('#app');

admin.component('admin-component', Admin);
admin.component('settings', Settings);
admin.component('story', Story);
admin.component('users', Users);
admin.component('add-user', AddUser);
admin.component('edit-user', EditUser);
admin.mount('#admin')
require('./bootstrap');
