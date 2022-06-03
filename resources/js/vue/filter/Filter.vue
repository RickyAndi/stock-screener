<template>
    <div class="flex gap-x-2 align-baseline">
        <div v-for="(modifier, modifierIndex) in filter.modifiers" :key="modifierIndex">
            <component :is="modifier.type" :modifier="modifier" :index="modifierIndex" :filterIndex="index" />
        </div>
        <div>
            <select @change="addModifier" v-model="selectedModifierType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <optgroup v-for="(modifier, index) in availableModifiers" :label="modifier.name" :key="index">
                    <option v-for="(option, optionIndex) in modifier.options" :key="optionIndex" :value="option.component">
                        {{ option.name }}
                    </option>
                </optgroup>
            </select>
        </div>
        <button @click="removeFilter" type="button" class="my-auto inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
</template>

<script>
export default {
    name: 'Filter',
    computed: {
        hasComparisonOperator() {
            const comparisonTypes = [
                "Equals",
                "NotEquals",
                "GreaterThan",
                "GreaterThanEqualTo",
                "LessThan",
                "LessThanEqualTo"
            ];

            return this.filter.modifiers.some((modifier) => {
                return comparisonTypes.includes(modifier.type);
            });
        },
        availableModifiers() {

            if (this.filter.modifiers.length % 2 != 0) {
                if (this.hasComparisonOperator) {
                    return [
                        {
                            name: "Arithmetic Operation",
                            parentType: "Arithmetic Operation",
                            options: [
                                {
                                    name: "+",
                                    component: "Plus"
                                },
                                {
                                    name: "-",
                                    component: "Minus"
                                },
                                {
                                    name: "*",
                                    component: "Time"
                                },
                                {
                                    name: "/",
                                    component: "Divide"
                                }
                            ]
                        }
                    ];
                }

                return [
                    {
                        name: "Arithmetic Operation",
                        parentType: "Arithmetic Operation",
                        options: [
                            {
                                name: "+",
                                component: "Plus"
                            },
                            {
                                name: "-",
                                component: "Minus"
                            },
                            {
                                name: "*",
                                component: "Time"
                            },
                            {
                                name: "/",
                                component: "Divide"
                            }
                        ]
                    },
                    {
                        name: "Comparison Operation",
                        parentType: "Comparison Operation",
                        options: [
                            {
                                name: "=",
                                component: "Equals"
                            },
                            {
                                name: "!=",
                                component: "NotEquals"
                            },
                            {
                                name: ">",
                                component: "GreaterThan"
                            },
                            {
                                name: ">=",
                                component: "GreaterThanEqualTo"
                            },
                            {
                                name: "<",
                                component: "LessThan"
                            },
                            {
                                name: "<=",
                                component: "LessThanEqualTo"
                            },
                        ]
                    }
                ];
            }

            if (this.hasComparisonOperator) {
                return [
                    {
                        name: "Measures",
                        parentType: "Measures",
                        options: [
                            {
                                name: "Number",
                                component: "Number"
                            }
                        ]
                    },
                    {
                        name: "Stock Attributes",
                        parentType: "StockAttribute",
                        options: [
                            {
                                name: "Open",
                                component: "Open"
                            },
                            {
                                name: "High",
                                component: "High"
                            },
                            {
                                name: "Low",
                                component: "Low"
                            },
                            {
                                name: "Close",
                                component: "Close"
                            }
                        ]
                    },
                    {
                        name: "Arithmetic Operation",
                        parentType: "Arithmetic Operation",
                        options: [
                            {
                                name: "+",
                                component: "Plus"
                            },
                            {
                                name: "-",
                                component: "Minus"
                            },
                            {
                                name: "*",
                                component: "Time"
                            },
                            {
                                name: "/",
                                component: "Divide"
                            }
                        ]
                    },
                ];
            }

            return [
                {
                    name: "Measures",
                    parentType: "Measures",
                    options: [
                        {
                            name: "Number",
                            component: "Number"
                        }
                    ]
                },
                {
                    name: "Stock Attributes",
                    parentType: "StockAttribute",
                    options: [
                        {
                            name: "Open",
                            component: "Open"
                        },
                        {
                            name: "High",
                            component: "High"
                        },
                        {
                            name: "Low",
                            component: "Low"
                        },
                        {
                            name: "Close",
                            component: "Close"
                        }
                    ]
                },
                {
                    name: "Arithmetic Operation",
                    parentType: "Arithmetic Operation",
                    options: [
                        {
                            name: "+",
                            component: "Plus"
                        },
                        {
                            name: "-",
                            component: "Minus"
                        },
                        {
                            name: "*",
                            component: "Time"
                        },
                        {
                            name: "/",
                            component: "Divide"
                        }
                    ]
                },
                {
                    name: "Comparison Operation",
                    parentType: "Comparison Operation",
                    options: [
                        {
                            name: "Equals",
                            component: "Equals"
                        },
                        {
                            name: "Not Equals",
                            component: "NotEquals"
                        },
                        {
                            name: "Greater Than",
                            component: "GreaterThan"
                        },
                        {
                            name: "Greater Than Equal To",
                            component: "GreaterThanEqualTo"
                        },
                        {
                            name: "Less Than",
                            component: "LessThan"
                        },
                        {
                            name: "Less Than Equal To",
                            component: "LessThanEqualTo"
                        },
                    ]
                }
            ];
        }
    },
    methods: {
        addModifier() {
            this.$store.commit('addModifier', {
                index: this.index,
                modifierType: this.selectedModifierType
            });

            this.selectedModifierType = null;
        },
        removeFilter() {
            this.$emit('filter-removed', {
                index: this.index
            })
        }
    },
    props: {
        index: Number,
        filter: Object
    },
    data() {
        return {
            selectedModifierType: null
        }
    }
}
</script>