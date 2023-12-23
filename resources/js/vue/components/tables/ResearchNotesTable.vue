<template>
    <table class="currency-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>Research Notes</h4></th>
            </tr>
            <tr>
                <th><h5>Name</h5></th>
                <th><h5>Total Cost</h5></th>
                <th><h5>Avg Output</h5></th>
                <th 
                    @click="
                        toggleActive(3, sortActive);
                        toggleSortOrder(3, sortOrder);
                        sortTable('currency-table', 3, 'gold', sortOrder);"
                >
                    <span class="sortable-column">
                        <h5>Cost/Note</h5>
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
                <th><h5>Recipe Tree</h5></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="notes in researchNotes">
                <td>{{ notes.name }}</td>
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(notes.crafting_value)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
                <td>{{ notes.avg_output }}</td>
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(notes.crafting_value/notes.avg_output)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { onMounted, ref } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'

const researchNotes = ref(null); 

const getResearchNotes = async () => {
    try {
        const response = await fetch(`../api/currencies/research-note`);
        const responseData = await response.json();
        researchNotes.value = responseData;

        // if (researchNotes.value){
        //     toggleActive(3, sortActive.value);
        //     sortOrder.value[3] = 'descending';
        //     sortTable('currency-table', 3, 'gold', sortOrder.value);
        // }
    } catch (error){
        console.log('Error fetching data: ', error);
    }
}

const ctaDetails = ref([]);

const sortActive = ref([]), 
    sortOrder = ref([]);

onMounted(() => {
    getResearchNotes();
})



</script>