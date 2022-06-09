<template>
    <div class="flex gap-x-2 p-2 border border-gray-400 rounded">
        <div>
            <div v-if="!inEditingTimeWindow">
                <a @click="activateEditingTimeWindow" href="#" class="italic text-gray-600">
                    {{ selectedTimeWindow }}
                </a>
            </div>
            <div v-if="inEditingTimeWindow">
                <select ref="timeWindowSelect" @mouseleave="inactivateEditingTimeWindow" @change="updateModifierPayload" v-model="timeWindow" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <template v-for="(timeWindow, parentIndex) in availableTimeWindows" :key="parentIndex">
                        <option v-for="(option, index) in timeWindow.options" :value="option.value" :key="index">
                            {{ option.name }}
                        </option>
                    </template>
                </select>
            </div>
        </div>
        <div v-if="timeWindow === '-wnd'">
            <div v-if="!inEditingNumber">
                <a @click="activateEditingNumber" href="#" class="italic text-gray-600">{{ number }}</a>
            </div>
            <div v-if="inEditingNumber">
                <input ref="numberInput" v-model="number"  @blur="inactivateEditingNumber" @change="updateModifierPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
            </div>
        </div>
        <div>
            <div v-if="!inEditingType">
                <a @click="activateEditingType" href="#">{{ modifierType }}</a>
            </div>
            <div v-if="inEditingType">
                <select v-model="modifierType" @mouseleave="inactivateEditingType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option  v-for="(type, index) in availableTypes" option :value="type" :key="index">
                        {{ type }}
                    </option>
                </select>
            </div>
        </div>
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
    computed: {
        selectedTimeWindow() {
            const availableTimeWindows = this.availableTimeWindows
                .map(timeWindow => timeWindow.options)
                .reduce((allTimeWindows, timeWindows) => {
                    return allTimeWindows.concat(timeWindows)
                }, []);
            const selectedTimeWindow = availableTimeWindows.find(timeWindow => timeWindow.value == this.timeWindow);
            return selectedTimeWindow.name;
        }
    },
    methods: {
        activateEditingNumber() {
            this.inEditingNumber = true;
            this.$nextTick(() => {
                this.$refs.numberInput.focus();
            });
        },
        inactivateEditingNumber() {
            this.inEditingNumber = false;
        },
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
        },
        activateEditingType() {
            this.inEditingType = true;
        },
        inactivateEditingType() {
            this.inEditingType = false;
        },
        activateEditingTimeWindow() {
            this.inEditingTimeWindow = true;
        },
        inactivateEditingTimeWindow() {
            this.inEditingTimeWindow = false;
        }
    },
    data() {
        return {
            inEditingNumber: false,
            inEditingTimeWindow: false,
            inEditingType: false,

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
                        },
                        {
                            name: 'Within n days ago',
                            value: '-wnd'
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