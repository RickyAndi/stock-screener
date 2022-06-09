<template>
    <div class="p-2 border border-gray-400 rounded">
        <div v-if="!inEditMode">
            <a @click="activateEditMode" href="#">{{ number }}</a>
        </div>
        <div v-if="inEditMode">
            <input ref="numberInput" @blur="inEditMode = false" v-model="number" @change="updateModifierPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
        </div>
    </div>
</template>

<script>
export default {
    name: 'Number',
    props: {
        modifier: Object,
        filterIndex: Number,
        index: Number
    },
    data() {
        return {
            inEditMode: false,
            number: 10
        }
    },
    mounted() {
        this.updateModifierPayload();
    },
    methods: {
        activateEditMode() {
            this.inEditMode = true;
            this.$nextTick(() => {
                this.$refs.numberInput.focus();
            });
        },
        updateModifierPayload() {

            this.inEditMode = false;

            this.$emit('payloadUpdated', {
                index: this.index,
                type: 'Number',
                data: {
                    number: this.number,
                }
            });
        }
    }
}
</script>