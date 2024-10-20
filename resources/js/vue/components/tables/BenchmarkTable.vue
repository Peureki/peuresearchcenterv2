<template>
    <table class="currency-details-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>Details</h4></th>
            </tr>
            <!--
                *
                * SAMPLE SIZE
                *
            -->
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>Sample size: </span>
                    <span class="float-right">
                        {{ benchmark.sampleSize }}
                    </span>
                </td>
            </tr>
            <!--
                *
                * TOTAL
                *
            -->
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>Total: </span>
                    <span class="float-right">
                        <span v-for="gold in formatValue(benchmark.total)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <tr>
                <th 
                    @click="
                        toggleActive(0, sortActive);
                        toggleSortOrder(0, sortOrder);
                        sortTable('currency-details-table', 0, 'string', sortOrder);
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
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
                <th 
                    @click="
                        toggleActive(1, sortActive);
                        toggleSortOrder(1, sortOrder);
                        sortTable('currency-details-table', 1, 'number', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>Qty</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[1] = el" 
                            :style="{transform: sortOrder[1] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
                <th 
                    @click="
                        toggleActive(2, sortActive);
                        toggleSortOrder(2, sortOrder);
                        sortTable('currency-details-table', 2, 'gold', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>Value</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[2] = el" 
                            :style="{transform: sortOrder[2] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
            </tr>
        </thead>
        <tbody>
            <!--
                *
                * BAG CONTENT
                *
            -->
            <tr v-for="item in filteredDropRates">
                <td>
                    <div 
                        v-if="item.item_icon"
                        class="text-left"
                    >
                        <img 
                            class="icon" :src="item.item_icon" :alt="item.item_name" :title="item.item_name"
                        >
                        <p :style="{color: showRarityColor(item.rarity)}">{{ item.item_name }}</p>
                    </div>
                    <div 
                        v-else
                        class="text-left"
                    >
                        <img 
                            :src="item.currency_icon" :alt="item.currency_name" :title="item.currency_name"
                        >
                        <p :style="{color: showRarityColor(item.rarity)}">{{ item.currency_name }}</p>
                    </div>
                </td>
                <td class="text-right">{{ formatToDecimal(item.drop_rate) }}</td>
                <td class="gold">
                    <span class="gold-label-container">
                        <!-- 
                            For this specific table, it's good to list all the items, regarldess if their value is 0. If != 0, use item.value, otherwise dispaly 0
                        -->
                        <span v-if="item.value" class="gold-label" v-for="gold in formatValue(item.value)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                        <span v-else class="gold-label" v-for="gold in formatValue(0)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>   
                </td>
            </tr>
            
        </tbody>
    </table>
</template>

<script setup>
import { ref, computed, onMounted, watch, nextTick } from 'vue'

import { formatValue, formatPercentage, showRarityColor, formatToDecimal } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'

const props = defineProps({
    benchmark: Object,
    dropRates: Object,
})
// Remove unnecessary drops that are either not in the sample (due to sample size) or don't exist in the drop table
const filteredDropRates = computed(() => {
    return props.dropRates.filter(item => Number(item.drop_rate) != 0);
})

console.log('filter' , filteredDropRates);

const sortActive = ref([]), 
    sortOrder = ref([]);

const triggleSort = async () => {
    await nextTick(); 
    toggleActive(2, sortActive.value);
    sortOrder.value[2] = 'descending'; 
    sortTable('currency-details-table', 2, 'gold', sortOrder.value);
}

onMounted(() => {
    if (props.dropRates){
        triggleSort();
    }
})

</script>