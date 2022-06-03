<template>
    <select v-model="modifier.type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        <option v-for="(type, index) in availableTypes"  :value="type.component" :key="index">
            {{ type.name }}
        </option>
    </select>
</template>

<script>
export default {
    name: 'ArithmeticOperation',
    props: {
        modifier: Object,
        filterIndex: Number,
        index: Number
    },
    data() {
        return {
            availableTypes: [
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
    }
}
</script>