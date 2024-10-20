<template>
    <div class="details-container">
        <table class="currency-details-table">
            <thead>
                <tr>
                    <th colspan="100%"><h4 class="table-header">Details</h4></th>
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
                            <h5 class="table-header">Name</h5>
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
                            <h5 class="table-header">Drop Rate</h5>
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
                            <h5 class="table-header">Value</h5>
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
                <tr v-for="mat in bag">
                    <td>
                        <img v-if="mat.icon" :src="mat.icon" :alt="mat.name" :title="mat.name"> 
                        <img v-else="mat.currency_icon" :src="mat.currency_icon" :alt="mat.currency_name" :title="mat.currency_name"> 
                        {{ mat.name }}
                    </td>
                    <td class="text-right">{{ formatPercentage(mat.drop_rate) }}</td>
                    <td class="gold">
                        <span class="gold-label-container">
                            <span class="gold-label" v-for="gold in formatValue(mat.value)">
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                            </span>
                        </span>   
                    </td>
                </tr>
            </tbody>
        </table>

        <!--
            *
            * PROOF OF CALCULATIONS
            * 
        -->
        <div class="proof-container">
            <!--
                *
                * BAG VALUE
                * 
            -->
            <div class="calculations">
                <span class="label-and-subtitle">
                    <span class="currency">
                        <img :src="bags.icon" :alt="bags.name" :title="bags.name">
                        <p>{{ bags.outputQty }}</p>
                    </span>
                    <p class="small-subtitle">Output</p>
                </span>

                <p> ⇐ </p>

                <span class="label-and-subtitle">
                    <span class="currency">
                        <img :src="currencyIcon" :alt="bags.currency" :title="bags.currency">
                        <p>{{ bags.costOfCurrencyPerBag }}</p>
                    </span>
                    <p class="small-subtitle">Exchangeable</p>
                </span>
            </div>
            <!--
                *
                * BAG VALUE
                * 
            -->
            <div class="calculations">
                <span class="label-and-subtitle">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bags.profitPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    <p class="small-subtitle">Bag Value</p>
                </span>

                <p> = </p>

                <p> ( </p>

                <span class="label-and-subtitle">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bags.total)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    <p class="small-subtitle">Sum of Drops</p>
                </span>
                

                <p> - </p>

                <span class="label-and-subtitle">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bags.fee)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    <p class="small-subtitle">Fee</p>
                </span>

                <p> ) *</p>

                <span class="label-and-subtitle">
                    <p>{{ bags.outputQty }}</p>
                    <p class="small-subtitle">Output Quantity</p>
                </span>
            </div>

            <!--
                *
                * CURRENCY VALUE
                * 
            -->
            <div class="calculations">
                <span class="label-and-subtitle">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bags.currencyPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    <p class="small-subtitle">Currency Value</p>
                </span>

                <p> = </p>

                <span class="label-and-subtitle">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(bags.profitPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                    <p class="small-subtitle">Bag Value</p>
                </span>
                

                <p> / </p>

                <span class="label-and-subtitle">
                    <span class="currency">
                        <p>{{ bags.costOfCurrencyPerBag }}</p>
                        <img :src="currencyIcon" :alt="bags.currency" :title="bags.currency">
                    </span>
                    
                    <p class="small-subtitle">Conversion Rate</p>
                </span>
            </div>
        </div>
    </div>
    
    
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'

import { formatValue, formatPercentage } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'

const props = defineProps({
    tableToggle: Boolean,
    currencyIcon: String,
    bag: Object,
    bags: Object,
})

console.log('bag: ', props.bags);

const sortActive = ref([]), 
    sortOrder = ref([]);

const triggleSort = async () => {
    await nextTick(); 
    toggleActive(2, sortActive.value);
    sortOrder.value[2] = 'descending'; 
    sortTable('currency-details-table', 2, 'gold', sortOrder.value);
}

onMounted(() => {
    if (props.tableToggle){
        triggleSort(); 
    }  
})

watch(() => props.bag, async (newVal, oldVal) => {
    if (newVal){
        triggleSort(); 
    }
})



</script>