<template>
    <div class="flex gap-x-2">
        <input v-model="number" v-if="timeFrame === '-nd'" @change="updateModifierPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
        <select @change="updateModifierPayload" v-model="timeFrame" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option v-for="(timeFrame, index) in availableTimeFrames"  :value="timeFrame.key" :key="index">
                {{ timeFrame.name }}
            </option>
        </select>
        <select v-model="modifier.type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
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
        filterIndex: Number,
        index: Number
    },
    mounted() {
        this.updateModifierPayload();
    },
    methods: {
        updateModifierPayload() {
            this.$store.commit('updateModifierPayload',{
                modifierIndex: this.index,
                filterIndex: this.filterIndex,
                payload: {
                    number: this.number,
                    timeFrame: this.timeFrame
                }
            });
        }
    },
    data() {
        return {
            timeFrame: 'latest',
            number: 10,
            availableTimeFrames: [
                {
                    name: "latest",
                    key: "latest"
                },
                {
                    name: "1 day ago",
                    key: "-1d"
                },
                {
                    name: "n days ago",
                    key: "-nd"
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