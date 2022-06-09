<template>
    <div class="flex gap-x-2 border border-gray-400 rounded p-2">
        <div>
            <div v-if="!inEditingTimeWindow">
                <a @click="activateEditingTimeWindow" href="#" class="italic text-gray-600">{{ selectedTimeWindow }}</a>
            </div>
            <div v-if="inEditingTimeWindow">
                <select ref="timeWindowSelect" @mouseleave="inactivateEditingTimeWindow" @change="emitPayload" v-model="timeWindow" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <template v-for="(timeWindow, parentIndex) in availableTimeWindows" :key="parentIndex">
                        <option v-for="(option, index) in timeWindow.options" :value="option.value" :key="index">
                            {{ option.name }}
                        </option>
                    </template>
                </select>
            </div>
        </div>
        <div v-if="'-wnd' === timeWindow || '-nd' === timeWindow">
            <div v-if="!inEditingNumber">
                <a @click="activateEditingNumber" href="#" class="italic text-gray-600">{{ number }}</a>
            </div>
            <div v-if="inEditingNumber">
                <input ref="numberInput" @blur="inactivateEditingNumber" v-model="number" @change="emitPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
            </div>
        </div>
        <div>
            Lower bollinger band
        </div>
        <div>
            (
        </div>
        <div>
            <div v-if="inEditingMA">
                <input ref="maInput" @blur="inactivateEditingMAPeriode" @change="emitPayload" v-model="movingAveragePeriod" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Periode of MA">
            </div>
            <div v-if="!inEditingMA">
                <a @click="activateEditingMAPeriode" href="#" class="italic text-gray-600">{{ movingAveragePeriod }}</a>
            </div>
        </div>
        <div>
            ,
        </div>
        <div>
            <div v-if="inEditingSTD">
                <input ref="stdInput" @blur="inactivateEditingSTD" @change="emitPayload" v-model="standardDeviation" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Standard deviation">
            </div>
            <div v-if="!inEditingSTD">
                <a @click="activateEditingSTD" href="#" class="italic text-gray-600">{{ standardDeviation }}</a>
            </div>
        </div>
        <div>
            )
        </div>
    </div>
</template>

<script>
import bollingerBand from './bollinger-band';

export default {
    name: 'LowerBollingerBand',
    props: Object.assign({}, bollingerBand.props),
    data() {
        return Object.assign(
            {
                type: 'LowerBollingerBand'
            },
            bollingerBand.data,
        );
    },
    computed: bollingerBand.computed,
    methods: Object.assign({}, bollingerBand.methods),
    mounted() {
        this.emitPayload();
    }
}
</script>