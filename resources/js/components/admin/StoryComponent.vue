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
                                     <div v-if="!story"> <img src="/storage/img/load_table.svg" style="width: 15%"> </div>
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
