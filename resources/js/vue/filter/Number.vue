<template>
    <div class="mt-1">
        <input v-model="number" @change="updateModifierPayload" type="number" name="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Put number here">
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
            number: 10
        }
    },
    methods: {
        updateModifierPayload() {
            this.$store.commit('updateModifierPayload',{
                modifierIndex: this.index,
                filterIndex: this.filterIndex,
                payload: {
                    number: this.number
                }
            });
        }
    }
}
</script>