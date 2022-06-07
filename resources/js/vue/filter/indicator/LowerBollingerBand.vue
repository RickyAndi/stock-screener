<template>
    <div class="flex gap-x-2">
        <div>
            <input v-model="number" v-if="timeWindow === '-wnd'" @change="emitPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
        </div>
        <div>
            <select @change="emitPayload" v-model="timeWindow" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <template v-for="(timeWindow, parentIndex) in availableTimeWindows" :key="parentIndex">
                    <option v-for="(option, index) in timeWindow.options" :value="option.value" :key="index">
                        {{ option.name }}
                    </option>
                </template>
            </select>
        </div>
        <div>Lower bollinger band</div>
        <div>
            <input @change="emitPayload" v-model="movingAveragePeriod" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Periode of MA">
        </div>
        <div>
            <input @change="emitPayload" v-model="standardDeviation" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Standard deviation">
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
            {
                number: 20,
                timeFrame: 'Daily',
                timeWindow: 'latest',
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
            }
        );
    },
    methods: Object.assign({}, bollingerBand.methods),
    mounted() {
        this.emitPayload();
    }
}
</script>