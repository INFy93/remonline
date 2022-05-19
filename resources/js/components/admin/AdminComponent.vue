<template>
    <div>
        <TabGroup>
            <TabList class="flex w-2/3 p-1 space-x-1 bg-blue-400 rounded-xl">
                <Tab v-slot="{ selected }" as="template">
                    <button
                        :class="[
                            'w-full py-2.5 text-sm leading-5 font-medium text-blue-700 rounded-lg',
                            'focus:outline-none focus:ring-2 ring-offset-2 ring-offset-blue-400 ring-white ring-opacity-60',
                            selected
                                ? 'bg-white shadow'
                                : 'text-blue-100 hover:bg-white/[0.12] hover:text-white',
                        ]"
                    >
                        Заказы
                    </button>
                </Tab>
                <Tab v-slot="{ selected }" as="template">
                    <button
                        :class="[
                            'w-full py-2.5 text-sm leading-5 font-medium text-blue-700 rounded-lg',
                            'focus:outline-none focus:ring-2 ring-offset-2 ring-offset-blue-400 ring-white ring-opacity-60',
                            selected
                                ? 'bg-white shadow'
                                : 'text-blue-100 hover:bg-white/[0.12] hover:text-white',
                        ]"
                    >
                        Пользователи
                    </button>
                </Tab>
                <Tab v-slot="{ selected }" as="template">
                    <button
                        :class="[
                            'w-full py-2.5 text-sm leading-5 font-medium text-blue-700 rounded-lg',
                            'focus:outline-none focus:ring-2 ring-offset-2 ring-offset-blue-400 ring-white ring-opacity-60',
                            selected
                                ? 'bg-white shadow'
                                : 'text-blue-100 hover:bg-white/[0.12] hover:text-white',
                        ]"
                    >
                        Аналитика
                    </button>
                </Tab>
            </TabList>
            <TabPanels class="mt-2">
                <TabPanel
                :class="[
                    'bg-gray-100 rounded-xl p-3'
                ]"
                ><settings></settings></TabPanel>
                <TabPanel
                :class="[
                    'bg-gray-100 rounded-xl p-3'
                ]"
                ><users></users></TabPanel>
                <TabPanel
                :class="[
                    'bg-gray-100 rounded-xl p-3'
                ]"
                ><analytics></analytics></TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
export default {
    data: function () {
        return {
            selected: '',
        };
    },
    components: {
        TabGroup,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
    },
    created() {},
    methods: {},
};
</script>
