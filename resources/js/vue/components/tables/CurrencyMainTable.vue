<template>
    <table class="currency-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>Best Value</h4></th>
            </tr>
            <tr>
                <!-- 
                    * TABLE HEADERS 
                    * 
                    * @click 
                    * -> toggle active columns that are being sorted
                    * -> toggle the order of sort (descending by default)
                    * -> sort this table
                    *
                    * @mouseover, @mouseout 
                    * -> set the headerIndex to be true when hovering -> highlights header column's borders to show if its sortable
                -->
                <!-- 
                    *
                    * NAME HEADER
                    *
                -->
                <th 
                    @click="
                        toggleActive(0, sortActive);
                        toggleSortOrder(0, sortOrder);
                        sortTable('currency-table', 0, 'string', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>Name</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[0] = el" 
                            :style="{transform: sortOrder[0] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * PROFIT/BAG HEADER
                    *
                -->
                <th 
                    @click="
                        toggleActive(1, sortActive);
                        toggleSortOrder(1, sortOrder);
                        sortTable('currency-table', 1, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>Profit/Bag</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[1] = el" 
                            :style="{transform: sortOrder[1] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * CURRENCY HEADER
                    *
                -->
                <th 
                    v-for="(currency, index) in bags[0].currency"
                    @click="
                        toggleActive(index + 2, sortActive);
                        toggleSortOrder(index + 2, sortOrder);
                        sortTable('currency-table', index + 2, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <img :src="currencyIcon" :alt="currency" :title="currency">
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[index + 2] = el" 
                            :style="{transform: sortOrder[index + 2] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
                <!-- 
                    *
                    * OTHER CURRENCY HEADER
                    * Apply only if it exists
                -->
                <th 
                    v-if="otherCurrencyIcon"
                    @click="
                        toggleActive(3, sortActive);
                        toggleSortOrder(3, sortOrder);
                        sortTable('currency-table', 3, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <img :src="otherCurrencyIcon" :alt="otherAlt" :title="otherAlt">
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[3] = el" 
                            :style="{transform: sortOrder[3] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        </svg>
                    </span> 
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(bag, index) in bags">
                <!-- Bag Name -->
                <td
                    class="bag-name"
                    :ref="el => detailsActive[index] = el"
                    @click="
                        toggleActive(index, detailsActive);
                        $emit('detailsToggle');
                        $emit('getDetails', index)
                    "
                >
                    <img :src="bag.icon" :alt="bag.name" :title="bag.name"> {{ bag.name }}
                </td>
                <!-- Profits/Bag -->
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bag.profitPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    
                </td>
                <!-- Currency Value -->
                <td 
                    v-for="(currencyPerBag, index) in bag.currencyPerBag"
                    class="gold"
                >
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(currencyPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <!-- Other Currency Value -->
                <td 
                    v-if="otherCurrencyIcon"
                    class="gold"
                >
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bag.otherCurrencyValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { ref, onMounted, nextTick, watch } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'


const props = defineProps({
    bags: Object, 
    currencyIcon: String,
    alt: String,
    otherCurrencyIcon: String,
    otherAlt: String,
})

const detailsActive = ref([]),
    sortActive = ref([]), 
    sortOrder = ref([]);

console.log('main table: ', props.bags[0].currency);

watch(() => props.bags, async (newVal, oldVal) => {
    if (newVal) {
        await nextTick(); 
        toggleActive(2, sortActive.value);
        sortOrder.value[2] = 'descending';
        sortTable('currency-table', 2, 'gold', sortOrder.value);
    }
});





</script>

<style scoped>

.bag-name{
    cursor: pointer;
    position: relative;
}
.bag-name.active::before{
    content: "";
    position: absolute;
    bottom: 0;
    right: 0;
    width: 0;
    height: 0;
    border-width: 0 0 10px 10px;
    border-style: solid;
    border-color: transparent transparent transparent var(--color-link);
    transform: rotate(180deg);
    z-index: 1000;
}

</style>