<template>
    <form @submit.prevent="$emit('handleItemSearch', searchQuery, searchQuantity)">
        <input
            v-show="showQuantity"
            class="small-number-field"
            type="number"
            min="0"
            v-model="searchQuantity"
        >
        <input
            type="text"
            :placeholder="placeholder"
            v-model="searchBar"
        >
        <!-- <button class="submit" type="submit">{{ submitText }}</button> -->

        <ul class="search-query-container" v-if="searchBar && searchBar.length > 3">
            <button 
                type="submit"
                v-for="(item, index) in searchResults"
                @click="searchQuery = searchResults[index];
                    searchBar = item.name"
            >
                <li>
                    <img :src="item.icon" :alt="item.name" :title="item.name">
                    <span class="flex-row-space-btw">
                        <p :style="{color: showRarityColor(item.rarity)}">{{ item.name }}</p> 
                    </span>
                </li> 
            </button>
        </ul>
    </form>
</template>

<script setup>
import { ref, watch } from 'vue';
import { showRarityColor } from '@/js/vue/composables/FormatFunctions.js'
import { debounce } from 'lodash';

const props = defineProps({
    showQuantity: {
        type: Boolean,
        default: true,
    },
    placeholder: {
        type: String, 
        default: 'Glob of Ectoplasm'
    },
    submitText: {
        type: String,
        default: 'Add Item'
    }
})

const searchBar = ref(null), 
    searchQuery = ref(null),
    searchResults = ref(null),
    searchQuantity = ref(1);

// Watch ths search bar 
// If character lenghth > 3 => apply search results
// Use debounce so the func does not get called every character change
// Without debounce, breaks website due to too many requests at once
watch(searchBar, debounce(async (query) => {
    if (query.length > 3){
        try {
            const url = `../api/tools/search-items/${searchQuantity.value}?request=${query}`;

            console.log('item query url: ', url);

            const response = await fetch(`../api/tools/search-items/${searchQuantity.value}?request=${query}`);
            const responseData = await response.json(); 
            searchResults.value = responseData; 

        } catch (error) {
            console.log("Trouble with search query: ", error); 
        }
    }
}, 500));

</script>

<style scoped>
input[type="text"]{
    width: 100%;
    max-width: 300px;
}
</style>