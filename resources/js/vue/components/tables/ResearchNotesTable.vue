<template>
    <table class="currency-table">
        <thead>
            <tr>
                <th colspan="100%"><h4>Research Notes</h4></th>
            </tr>
            <tr>
                <th><h5>Name</h5></th>
                <th><h5>Total Cost</h5></th>
                <th><h5>Output</h5></th>
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
                <!-- NAME -->
                <td><img :src="notes.icon" :alt="notes.name" :title="notes.name"> {{ notes.name }}</td>
                
                <!-- TOTAL COSTS -->
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(compareBuyOrderAndCraftingValues(notes))">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>

                <!-- AVG OUTPUT -->
                <td>{{ notes.avg_output }}</td>

                <!-- COST/NOTE -->
                <td class="gold">
                    <span class="gold-label-container">
                        <span class="gold-label" v-for="gold in formatValue(compareBuyOrderAndCraftingValues(notes)/notes.avg_output)">
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                        </span>
                    </span>
                </td>

                <!-- RECIPE TREE LINK -->
                <td @click="getRecipeValue(notes.name)">
                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                    </svg>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { compareBuyOrderAndCraftingValues } from '@/js/vue/composables/BasicFunctions.js'
import { sortTable, toggleSortOrder, toggleActive } from '@/js/vue/composables/TableFunctions.js'

const researchNotes = ref(null); 

const getResearchNotes = async () => {
    try {
        const response = await fetch(`../api/currencies/research-note/${localStorage.buyOrderSetting}`);
        const responseData = await response.json();
        researchNotes.value = responseData;

        console.log('notes: ', researchNotes.value);

        if (researchNotes.value){
            toggleActive(3, sortActive.value);
            sortOrder.value[3] = 'descending';
            sortTable('currency-table', 3, 'gold', sortOrder.value);
        }
    } catch (error){
        console.log('Error fetching data: ', error);
    }
}

const ctaDetails = ref([]);

const sortActive = ref([]), 
    sortOrder = ref([]);

const router = useRouter();

const getRecipeValue = (recipeName) => {
    // router.push({
    //     path: '/tools/recipe-value',
    //     query: {
    //         requestedRecipe: recipeName
    //     }
    // });

    const url = `../tools/recipe-value?requestedRecipe=${recipeName}`;
    window.open(url, '_blank');

}

onMounted(() => {
    getResearchNotes();
})



</script>