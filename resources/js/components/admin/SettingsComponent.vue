<template>
    <div>
        <h2 class="text-xl font-bold border-b border-gray-300">Заказы</h2>
        <div class="mt-2">
            <div class="flex space-x-3 items-center">
                <div>Считать заказ закрытым, если он имеет статус</div>
                <div>
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="px-4 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-lg text-white bg-gray-700"
                            >
                                Закрыт
                                <ChevronDownIcon
                                    class="w-5 h-5 ml-2 -mr-1"
                                    aria-hidden="true"
                                />
                            </MenuButton>
                        </div>
                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute z-10 left-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <div class="px-1 py-1">
                                    <MenuItem>
                                        <a
                                            href="#"
                                            status_id="1"
                                            @click.stop.prevent
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Закрыт</a
                                        >
                                    </MenuItem>
                                    <MenuItem>
                                        <a
                                            href="#"
                                            status_id="2"
                                            @click.stop.prevent
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Готов</a
                                        >
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
            <div class="flex space-x-3 items-center mt-2">
                <div>Пагинация:</div>
                <div>
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="px-4 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-lg text-white bg-gray-700"
                            >
                                Да
                                <ChevronDownIcon
                                    class="w-5 h-5 ml-2 -mr-1"
                                    aria-hidden="true"
                                />
                            </MenuButton>
                        </div>
                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute z-10 left-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <div class="px-1 py-1">
                                    <MenuItem>
                                        <a
                                            href="#"
                                            status_id="1"
                                            @click.stop.prevent
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Да</a
                                        >
                                    </MenuItem>
                                    <MenuItem>
                                        <a
                                            href="#"
                                            status_id="2"
                                            @click.stop.prevent
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Нет</a
                                        >
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
            <div class="flex flex-row items-center space-x-3 mt-2">
                <div>
                    Кол-во заказов на одной странице:
                </div>
                <div>
                    <input
                        type="text"
                        name=""
                        id=""
                        value="30"
                        class="w-12 h-1 pl-3 text-sm bg-white text-black border-transparent focus:border-transparent focus:ring-0"
                    />
                </div>
            </div>
            <div class="flex space-x-3 items-center mt-2">
                <div>Разрешить юзерам смотреть заказы других сервисов:</div>
                <div>
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="px-4 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-lg text-white bg-gray-700"
                            >
                                Да
                                <ChevronDownIcon
                                    class="w-5 h-5 ml-2 -mr-1"
                                    aria-hidden="true"
                                />
                            </MenuButton>
                        </div>
                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute z-10 left-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <div class="px-1 py-1">
                                    <MenuItem>
                                        <a
                                            href="#"
                                            status_id="1"
                                            @click.stop.prevent
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Да</a
                                        >
                                    </MenuItem>
                                    <MenuItem>
                                        <a
                                            href="#"
                                            status_id="2"
                                            @click.stop.prevent
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Нет</a
                                        >
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import { ref } from "vue";
import axios from "axios";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/solid";

export default {
    data: function () {
        return {
            selected: "",
            active: "",
        };
    },
    components: {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        ChevronDownIcon,
    },
    created() {},
    methods: {
        wordsFormat: function (number, titles) {
            let cases = [2, 0, 1, 1, 1, 2];
            return titles[
                number % 100 > 4 && number % 100 < 20
                    ? 2
                    : cases[number % 10 < 5 ? number % 10 : 5]
            ];
        },
    },
};
</script>
