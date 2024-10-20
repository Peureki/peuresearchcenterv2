<template>
    <table class="general-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>{{ title }}</h4></th>
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
                * DYNAMIC HEADERS
                * In the View that's using this component, initalize const tableHeader as an array of header names
                *
            -->
                <th 
                    v-for="(header, index) in tableHeaders" :key="index"
                    @click="
                        toggleActive(index, sortActive);
                        toggleSortOrder(index, sortOrder);
                        sortTable('general-table', index, 'string', sortOrder);
                    "
                >
                    <span class="sortable-column">
                        <h5>{{ header }}</h5>
                        <svg
                            class="sort-arrow active" 
                            :ref="el => sortActive[index] = el" 
                            :style="{transform: sortOrder[index] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        </svg>
                    </span> 
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(content, index) in data" :key="index">
                <td>
                    <img :src="content.icon" :alt="content.name" :title="content.name"> {{ content.name }}
                </td>

                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(content.profit)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>

        </tbody>
    </table>
    
</template>

<script setup>
import { ref, onMounted } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'


const props = defineProps({
    title: String,
    tableHeaders: Object, 
    data: Object,
    sortColumn: Number, 
})

const detailsActive = ref([]),
    sortActive = ref([]), 
    sortOrder = ref([]);


</script>