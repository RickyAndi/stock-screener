<template>
    <div class="flex gap-x-2">
        <input v-model="number" v-if="timeFrame === '-nd'" @change="updateModifierPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
        <select @change="updateModifierPayload" v-model="timeWindow" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <template v-for="(timeWindow, parentIndex) in availableTimeWindows" :key="parentIndex">
                <option v-for="(option, index) in timeWindow.options" :value="option.value" :key="index">
                    {{ option.name }}
                </option>
            </template>
        </select>
        <select v-model="modifierType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option  v-for="(type, index) in availableTypes" option :value="type" :key="index">
                {{ type }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'StockAttribute',
    props: {
        modifier: Object,
        index: Number
    },
    mounted() {
        this.modifierType = this.modifier.type;

        this.updateModifierPayload();
    },
    methods: {
        updateModifierPayload() {
            this.$emit('payloadUpdated', {
                index: this.index,
                type: this.modifierType,
                data: {
                    number: this.number,
                    timeFrame: this.timeFrame,
                    timeWindow: this.timeWindow
                }
            });
        }
    },
    data() {
        return {
            timeFrame: 'Daily',
            timeWindow: 'latest',
            number: 10,
            modifierType: '', 
            availableTimeWindows: [
                {
                    timeframe: 'Daily',
                    options: [
                        {
                            name: 'Latest',
                            value: 'latest'
                        },
                        {
                            name: '1 Day ago',
                            value: '-1d'
                        }
                    ]
                }
            ],
            availableTypes: [
                'Open',
                'Close',
                'High',
                'Low'
            ]
        }
    }
}
</script>