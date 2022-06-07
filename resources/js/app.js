import { createApp } from 'vue';
import { createStore } from 'vuex';
import App from './vue/index/App.vue';
import Filter from './vue/filter/Filter.vue';
import StockAttribute from './vue/filter/StockAttribute.vue';
import ArithmeticOperation from './vue/filter/ArithmeticOperation.vue';
import ComparisonOperation from './vue/filter/ComparisonOperation.vue';
import NumberComponent from './vue/filter/Number.vue';
import LowerBollingerBand from './vue/filter/indicator/LowerBollingerBand.vue';
import UpperBollingerBand from './vue/filter/indicator/UpperBollingerBand.vue';

const store = createStore({
    state() {
        return {
            filters: [
                []
            ]
        }
    },
    mutations: {
        addFilter(state) {
            state.filters.push([]);
        },
        updateFilter(state, payload) {
            state.filters[payload.index] = payload.modifiers;
        },
        updateModifierPayload(state, payload) {
            const existingPayload = state.filters[payload.filterIndex].modifiers[payload.modifierIndex];
            const updatedPayload = Object.assign(existingPayload, payload.payload);

            state.filters[payload.filterIndex].modifiers[payload.modifierIndex] = updatedPayload;
        },
        addModifier(state, payload) {
            state.filters[payload.index].push({
                type: payload.modifierType
            });
        }
    }
});

const app = createApp(App);

app.use(store);

app.component("Equals", ComparisonOperation);
app.component("NotEquals", ComparisonOperation);
app.component("GreaterThan", ComparisonOperation);
app.component("GreaterThanEqualTo", ComparisonOperation);
app.component("LessThan", ComparisonOperation);
app.component("LessThanEqualTo", ComparisonOperation);
app.component('CrossedAbove', ComparisonOperation);
app.component('CrossedBelow', ComparisonOperation);

app.component('Plus', ArithmeticOperation);
app.component('Minus', ArithmeticOperation);
app.component('Time', ArithmeticOperation);
app.component('Divide', ArithmeticOperation);

app.component('Filter', Filter);

app.component('Low', StockAttribute);
app.component('High', StockAttribute);
app.component('Open', StockAttribute);
app.component('Close', StockAttribute);

app.component('Number', NumberComponent);

app.component('UpperBollingerBand', UpperBollingerBand);
app.component('LowerBollingerBand', LowerBollingerBand);

app.mount('#app');