<template>
    <form 
        class="recipe-form"
        @submit.prevent="$emit('handleRecipeRequest', searchQuery, quantityRequest)"
    >
        <!-- SEARCH BAR -->
        <input 
            type="text" 
            placeholder="Item Name"
            v-model="searchBar"
        >
        <Transition name="fade">
            <!-- LIST IF SEARCH BAR HAS CONTENT -->
            <ul class="search-query-container" v-if="searchBar && searchBar.length > 3">
                <button 
                    v-for="(recipe, index) in searchResults"
                    @click="searchQuery = searchResults[index];
                        searchBar = recipe.name"
                >
                    <li>
                        <img :src="recipe.icon" :alt="recipe.name" :title="recipe.name">
                        <span class="flex-row-space-btw">
                            <p :style="{color: showRarityColor(recipe.rarity)}">{{ recipe.name }}</p> 
                        </span>
                    </li> 
                </button>
            </ul>
        </Transition>
        <!-- 
            * INPUT - QUANTITY
            * SUBMIT RECIPE
        -->
        <div class="flex-row-space-btw">
            <input
                type="number"
                min="1"
                v-model="quantityRequest"
            >
            <button class="submit" type="submit">Fetch Recipe</button>
        </div>
    </form>

    <!-- <Loading 
        v-if="loadingToggle"
        :width="200" :height="200"    
    /> -->
</template>

<script setup>
import { ref, watch } from 'vue'
import { debounce } from 'lodash';

import { showRarityColor } from '@/js/vue/composables/FormatFunctions.js'

const searchBar = ref(null),
    searchQuery = ref(null),
    searchResults = ref(null), 
    quantityRequest = ref(1);

// Watch ths search bar 
// If character lenghth > 3 => apply search results
// Use debounce so the func does not get called every character change
// Without debounce, breaks website due to too many requests at once
watch(searchBar, debounce(async (query) => {
    if (query.length > 3){
        try {
            const response = await fetch(`../api/recipes/search-recipes?request=${query}`);
            const responseData = await response.json(); 
            searchResults.value = responseData; 

        } catch (error) {
            console.log("Trouble with search query: ", error); 
        }
    }
}, 500));

</script>

<style scoped>

</style>