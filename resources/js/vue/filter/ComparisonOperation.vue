<template>
    <div class="p-2 border border-gray-400 rounded">
        <div v-if="!inEditingMode">
            <a @click="activateEditing" href="#">{{ selectedMathOperation }}</a>
        </div>
        <div v-if="inEditingMode">
            <select @mouseleave="inactivateEditing" @change="updateModifierPayload" v-model="modifierType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option v-for="(type, index) in availableTypes" :value="type.component" :key="index">
                    {{ type.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ComparisonOperation',
    props: {
        modifier: Object,
        filterIndex: Number,
        index: Number
    },
    data() {
        return {
            inEditingMode: false,
            modifierType: 'Equals',
            availableTypes: [
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
                {
                    name: "Crossed Above",
                    component: "CrossedAbove"
                },
                {
                    name: "Crossed Below",
                    component: "CrossedBelow"
                }
            ]
        }
    },
    mounted() {
        this.modifierType = this.modifier.type;
    },
    computed: {
        selectedMathOperation() {
            const selectedOperation = this.availableTypes
                .find(type => type.component === this.modifierType);
            return selectedOperation.name;
        }
    },
    methods: {
        activateEditing() {
            this.inEditingMode = true;
        },
        inactivateEditing() {
            this.inEditingMode = false;
        },
        updateModifierPayload() {
            this.$emit('payloadUpdated', {
                index: this.index,
                type: this.modifierType,
                data: {}
            });
        }
    },
}
</script>