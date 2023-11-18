<template>
    <table 
        class="currency-details-table"
    >
        <thead>
            <tr>
                <th colspan="100%"><h4>{{ bag.name }} Details </h4></th>
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
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
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
                        <h5>Drop Rate</h5>
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
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
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
            <tr v-for="mat in bagContent">
                <td><img :src="mat.icon" :alt="mat.name" :title="mat.name"> {{ mat.name }}</td>
                <td class="text-right">{{ formatPercentage(mat.dropRate) }}</td>
                <td class="gold">
                    <span class="gold-label" v-for="gold in formatValue(mat.value)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </td>
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
                        {{ bag.sampleSize }}
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
                        <span v-for="gold in formatValue(bag.total)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <!--
                *
                * COST PER BAG
                *
            -->
            <tr class="row-offset">
                <td class="cost" colspan="100%">
                    <span>Cost per bag:</span>
                    <span class="float-right">
                        -<span v-for="gold in formatValue(bag.costPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <!--
                *
                * PROFIT PER BAG
                *
            -->
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>Profit per bag:</span>
                    <span class="float-right">
                        <span v-for="gold in formatValue(bag.profitPerBag)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
            <!--
                *
                * CURRENCY PER BAG
                *
            -->
            <tr class="row-offset">
                <td class="cost" colspan="100%">
                    <span>{{ currencyName }} per bag:</span>
                    <span class="float-right">
                        -{{ bag.currencyPerBag }}<img :src="currencyIcon" :alt="alt" :title="alt">
                    </span> 
                </td>
            </tr>
            <!--
                *
                * CURRENCY VALUE
                *
            -->
            <tr class="row-offset">
                <td class="total" colspan="100%">
                    <span>
                        Profit per {{ currencyName }}
                        <img :src="currencyIcon" :alt="alt" :title="alt">:
                    </span>
                    <span class="float-right">
                        <span v-for="gold in formatValue(bag.currencyValue)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'

import { formatValue, formatPercentage } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, setHoverBorder, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'

const props = defineProps({
    tableToggle: Boolean,
    tableName: Object,
    currencyName: String,
    currencyIcon: String,
    alt: String,
    bag: Object,
    bagContent: Object,
})

const currencyDetails = ref(null);

const sortActive = ref([]), 
    sortOrder = ref([]);

onMounted(() => {
    if (props.tableToggle){
        toggleActive(2, sortActive.value);
        sortOrder.value[2] = 'descending'; 
        sortTable('currency-details-table', 2, 'gold', sortOrder.value);
    }  
})

</script>