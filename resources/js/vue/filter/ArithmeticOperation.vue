<template>
    <div class="p-2 border border-gray-400 rounded">
        <div v-if="!inEditMode">
            <a href="#" @click="activateEditMode">{{ selectedOperatorSymbol }}</a>
        </div>
        <div v-if="inEditMode">
            <select ref="select" @mouseleave="updateModifierPayload" @change="updateModifierPayload" v-model="modifierType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option v-for="(type, index) in availableTypes"  :value="type.component" :key="index">
                    {{ type.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ArithmeticOperation',
    props: {
        modifier: Object,
        index: Number
    },
    computed:  {
        selectedOperatorSymbol() {
            const selectedOperatorSymbol = this
                .availableTypes
                .find((type) => type.component === this.modifierType);
            
            if (selectedOperatorSymbol === undefined) {
                return '';
            }

            return selectedOperatorSymbol.name;
        }
    },
    data() {
        return {
            modifierType: null,
            inEditMode: false,
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
        activateEditMode() {
            this.inEditMode = true;
            this.$nextTick(() => {
                this.$refs.select.click();
            });
        },
        inActivateEditMode() {
            this.inEditMode = false;
        },
        updateModifierPayload() {

            this.inActivateEditMode();

            this.$emit('payloadUpdated', {
                type: this.modifierType,
                index: this.index,
                data: {}
            });
        }
    },
}
</script>