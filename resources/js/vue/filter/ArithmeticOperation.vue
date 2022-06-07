<template>
    <select @change="updateModifierPayload" v-model="modifierType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
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
        index: Number
    },
    data() {
        return {
            modifierType: null,
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
    },
    mounted() {
        this.modifierType = this.modifier.type;
    },
    methods: {
        updateModifierPayload() {
            this.$emit('payloadUpdated', {
                type: this.modifierType,
                index: this.index,
                data: {}
            });
        }
    },
}
</script>