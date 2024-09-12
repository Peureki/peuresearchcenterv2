<template>
    <Loading :width="200" :height="200" v-if="!researchNotesToggle" />
    <TableWithPages>

        <template v-slot:page-list-top>
            <PageButtons
                v-if="researchNotesToggle"
                :data-array="researchNotesRef"
                @get-last-page="getPage"
            />
        </template>

        <template v-slot:table>
            <table 
                class="currency-table"
                v-if="researchNotesToggle"
            >
                <thead>
                    <tr>
                        <th colspan="100%"><h4>Research Notes</h4></th>
                    </tr>
                    <tr>
                        <th><h5>Name</h5></th>
                        <th><h5>Best</h5></th>
                        <th><h5>Discipline</h5></th>
                        <th><h5>Total Cost</h5></th>
                        <th><img :src="ResearchNoteIcon" alt="Research Note" title="Research Note"></th>
                        <th 
                            @click="
                                toggleActive(5, sortActive);
                                toggleSortOrder(5, sortOrder);
                                sortTable('currency-table', 5, 'gold', sortOrder);"
                        >
                            <span class="sortable-column">
                                <h5>Cost/Note</h5>
                                <svg
                                    class="sort-arrow active" 
                                    :ref="el => sortActive[5] = el" 
                                    :style="{transform: sortOrder[5] == 'descending' ? 'rotate(90deg)' : 'rotate(-90deg)'}"
                                    width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                                </svg>
                            </span> 
                        </th>
                        <th><h5>Recipe</h5></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="notes in researchNotes.data">
                        <!-- NAME -->
                        <td>
                            <span class="flex-row-flex-start">
                                <img :src="notes.icon" :alt="notes.name" :title="notes.name">
                                <p :style="{color: showRarityColor(notes.rarity)}">{{ notes.name }}</p>
                            </span>
                        </td>

                        <!-- BEST OPTION-->
                        <td>{{ compareBuyOrderAndCraftingValues(notes).preference }}</td>

                        <!-- DISCIPLINES -->
                        <td>
                            <span v-for="discipline in notes.disciplines">
                                <img :src="matchDiscipline(discipline)" :alt="discipline" :title="discipline">
                            </span>
                        </td>
                        
                        <!-- TOTAL COSTS -->
                        <td class="gold">
                            <span class="gold-label-container">
                                <span class="gold-label" v-for="gold in formatValue(compareBuyOrderAndCraftingValues(notes).value)">
                                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                                </span>
                            </span>
                        </td>

                        <!-- AVG OUTPUT -->
                        <td>{{ notes.avg_output }}</td>

                        <!-- COST/NOTE -->
                        <td class="gold">
                            <span class="gold-label-container">
                                <span class="gold-label" v-for="gold in formatValue(compareBuyOrderAndCraftingValues(notes).value/notes.avg_output)">
                                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                                </span>
                            </span>
                        </td>

                        <!-- RECIPE TREE LINK -->
                        <td class="cta" @click="getRecipeValue(notes.name, notes.id, 1)">
                            <span>
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                                </svg>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
    </TableWithPages>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'

import TableWithPages from '@/js/vue/components/general/TableWithPages.vue'
import PageButtons from '@/js/vue/components/general/PageButtons.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import ResearchNoteIcon from '@/imgs/icons/Research_Note.png'
import Armorsmith from '@/imgs/icons/Armorsmith.png'
import Artificer from '@/imgs/icons/Artificer.png'
import Chef from '@/imgs/icons/Chef.png'
import Huntsman from '@/imgs/icons/Huntsman.png'
import Jeweler from '@/imgs/icons/Jeweler.png'
import Leatherworker from '@/imgs/icons/Leatherworker.png'
import Scribe from '@/imgs/icons/Scribe.png'
import Tailor from '@/imgs/icons/Tailor.png'
import Weaponsmith from '@/imgs/icons/Weaponsmith.png'

import { formatValue, showRarityColor } from '@/js/vue/composables/FormatFunctions.js'
import { compareBuyOrderAndCraftingValues } from '@/js/vue/composables/BasicFunctions.js'
import { sortTable, toggleSortOrder, toggleActive, getPage } from '@/js/vue/composables/TableFunctions.js'

// Initialize with {data: []} due to pagination
const researchNotes = ref({data: []}),
    researchNotesToggle = ref(null); 

const researchNotesRef = computed(()  => researchNotes);

const getResearchNotes = async () => {
    const filters = JSON.parse(localStorage.filterResearchNotes);

    try {
        console.log(`../api/currencies/research-note/${localStorage.buyOrderSetting}/${filters}`)
        const response = await fetch(`../api/currencies/research-note/${localStorage.buyOrderSetting}/${filters}`);
        const responseData = await response.json();
        researchNotes.value = responseData;
        console.log(researchNotes.value);

        researchNotesToggle.value = true;
    } catch (error){
        console.log('Error fetching data: ', error);
    }
}

const matchDiscipline = (discipline) => {
    switch (discipline){
        case "Armorsmith": return Armorsmith; 
        case "Artificer": return Artificer;
        case "Chef": return Chef;
        case "Huntsman": return Huntsman;
        case "Jeweler": return Jeweler;
        case "Leatherworker": return Leatherworker;
        case "Scribe": return Scribe;
        case "Tailor": return Tailor;
        case "Weaponsmith": return Weaponsmith; 
    }
}

const ctaDetails = ref([]);

const sortActive = ref([]), 
    sortOrder = ref([]);

const router = useRouter();

const getRecipeValue = (recipeName, recipeId, recipeQty) => {
    const url = `../tools/recipe-value?requestedRecipe=${recipeName}&id=${recipeId}&qty=${recipeQty}`;
    window.open(url, '_blank');
}

onMounted(() => {
    getResearchNotes();
})



</script>