<template>
    <div class="flex gap-x-2 align-baseline">
        <div v-for="(modifier, modifierIndex) in modifiers" :key="modifierIndex">
            <component :is="modifier.type" :modifier="modifier" :index="modifierIndex" v-on:payloadUpdated="updateModifierPayload" />
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
import { stockAttributes, measures, bollingerBands, arithmeticOperations, comparisonOperations, crossOperations } from './modifiers';

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
                "LessThanEqualTo",
                "CrossedAbove",
                "CrossedBelow"
            ];

            return this.modifiers.some((modifier) => {
                return comparisonTypes.includes(modifier.type);
            });
        },
        lastModifierIsArithmetic() {
            if (!this.modifiers.length) {
                return false;
            }

            return ["Plus", "Minus", "Time", 'Divide'].includes(this.modifiers[this.modifiers.length - 1].type);
        },
        availableModifiers() {

            if (!this.modifiers.length) {
                return [
                    measures,
                    stockAttributes,
                    bollingerBands
                ];
            }

            if (this.modifiers.length % 2 != 0) {
                if (this.hasComparisonOperator) {
                    return [
                        arithmeticOperations
                    ];
                }

                return [].concat(!this.lastModifierIsArithmetic ? [
                    arithmeticOperations
                ] : [])
                .concat([
                    comparisonOperations,
                    crossOperations
                ]);
            }

            if (this.hasComparisonOperator) {
                return [].concat(!this.lastModifierIsArithmetic ? [
                    arithmeticOperations
                ] : [])
                .concat([
                    measures,
                    stockAttributes,
                    bollingerBands
                ]);
            }

            return [].concat(!this.lastModifierIsArithmetic ? [
                arithmeticOperations
            ] : [])
            .concat([
                measures,
                stockAttributes,
                bollingerBands
            ]);
        }
    },
    methods: {
        addModifier() {
            this.modifiers.push({
                type: this.selectedModifierType,
                data: {}
            });

            this.selectedModifierType = null;

            this.$emit('payloadUpdated', {
                index: this.index,
                modifiers: this.modifiers
            });
        },
        removeFilter() {
            this.$emit('filter-removed', {
                index: this.index
            })
        },
        updateModifierPayload(payload) {
            console.log(payload);
            this.modifiers[payload.index]['data'] = payload.data;
            this.modifiers[payload.index]['type'] = payload.type;

            this.$emit('payloadUpdated', {
                index: this.index,
                modifiers: this.modifiers
            });
        }
    },
    props: {
        index: Number,
        modifier: Array
    },
    data() {
        return {
            selectedModifierType: null,
            modifiers: []
        }
    },
    mounted() {
        this.$emit('payloadUpdated', {
            modifiers: this.modifiers,
            index: this.index
        });
    }
}
</script>