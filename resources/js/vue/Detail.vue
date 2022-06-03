<template>
    <div>

        <div>
            <apexchart type="candlestick" height="350" :options="chartOptions" :series="series"></apexchart>
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
                                        Date
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
                                        Open
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
                                        High
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
                                        Low
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
                                        Close
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Odd row -->
                                <tr class="bg-white" v-for="(stockDatum, index) in series[0].data" :key="index">
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
                                        {{ stockDatum.x.toDateString() }}
                                    </td>
                                    <td
                                        class="
                                            px-6
                                            py-4
                                            whitespace-nowrap
                                            text-sm text-gray-500
                                        "
                                    >
                                        {{ stockDatum.y[0] }}
                                    </td>
                                    <td
                                        class="
                                            px-6
                                            py-4
                                            whitespace-nowrap
                                            text-sm text-gray-500
                                        "
                                    >
                                        {{ stockDatum.y[1] }}
                                    </td>
                                    <td
                                        class="
                                            px-6
                                            py-4
                                            whitespace-nowrap
                                            text-sm text-gray-500
                                        "
                                    >
                                        {{ stockDatum.y[2] }}
                                    </td>
                                      <td
                                        class="
                                            px-6
                                            py-4
                                            whitespace-nowrap
                                            text-sm text-gray-500
                                        "
                                    >
                                        {{ stockDatum.y[3] }}
                                    </td>
                                </tr>

                                <!-- Even row -->
                               
                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {
            series: [
                {
                    data: []
                }
            ],
            chartOptions: {
                chart: {
                    type: 'candlestick',
                    height: 350
                },
                title: {
                    text: 'CandleStick Chart',
                    align: 'left'
                },
                xaxis: {
                    type: 'datetime',
                    datetimeFormatter: {
                        year: 'yyyy',
                        month: 'MMM \'yy',
                        day: 'dd MMM',
                    }
                },
                yaxis: {
                    tooltip: {
                        enabled: true
                    }
                }
            },
        }
    },
    mounted() {
        const self = this;
        console.log(window.jancok);
        window.jancok.forEach((datum) => {
            self.series[0].data.push(
                Object.assign(datum, {x : (new Date(datum.x.year, datum.x.month - 1, datum.x.date))})
            );
        });
    }
};
</script>