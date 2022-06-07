<template>
    <div class="block">
        <Filter class="mt-2" v-on:filter-removed="removeFilter" v-for="(modifiers, index) in filters" :key="index" :index="index" :modifiers="modifiers" v-on:payloadUpdated="updateFilterPayload" />
    </div>
    <div class="block mt-2">
        <button @click="addFilter" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <strong>+</strong>
        </button>
    </div>
    <div class="block mt-2">
        <button @click="runScan" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <strong>Run scan</strong>
        </button>
    </div>
    <div class="mt-3 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="
                    py-2
                    align-middle
                    inline-block
                    min-w-full
                    sm:px-6
                    lg:px-8
                "
            >
                <div
                    class="
                        shadow
                        overflow-hidden
                        border-b border-gray-200
                        sm:rounded-lg
                    "
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="
                                        px-6
                                        py-3
                                        text-left text-xs
                                        font-medium
                                        text-gray-500
                                        uppercase
                                        tracking-wider
                                    "
                                >
                                    Symbol
                                </th>
                                <th
                                    scope="col"
                                    class="
                                        px-6
                                        py-3
                                        text-left text-xs
                                        font-medium
                                        text-gray-500
                                        uppercase
                                        tracking-wider
                                    "
                                >
                                    Name
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Detail</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Odd row -->
                            <tr class="bg-white" v-for="(datum, index) in results" :key="index">
                                <td
                                    class="
                                        px-6
                                        py-4
                                        whitespace-nowrap
                                        text-sm
                                        font-medium
                                        text-gray-900
                                    "
                                >
                                    {{ datum.symbol }}
                                </td>
                                <td
                                    class="
                                        px-6
                                        py-4
                                        whitespace-nowrap
                                        text-sm text-gray-500
                                    "
                                >
                                    {{ datum.name }}
                                </td>
                                <td
                                    class="
                                        px-6
                                        py-4
                                        whitespace-nowrap
                                        text-sm text-gray-500
                                    "
                                >
                                    <a :href="datum.link" target="_blank">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default {
    data() {
        return {
            query: {},
            results: []
        };
    },
    computed: {
        filters () {
            return this.$store.state.filters;
        }
    },
    methods: {
        addFilter() {
            this.$store.commit('addFilter');
        },
        removeFilter(payload) {
            this.filters.splice(payload.index, 1);
        },
        updateFilterPayload(payload) {
            this.$store.commit('updateFilter', {
                index: payload.index,
                modifiers: payload.modifiers
            });
        },
        async runScan() {

            const queries = this.filters;
            const response = await axios.get('/filter', {
                params: {
                    query: JSON.stringify(queries)
                }
            });
            const data = response.data.data;

            this.results.splice(0, this.results.length);

            data.forEach((datum) => {
                this.results.push(datum);
            });
        }
    },
    mounted() {
        
    }
};
</script>