<template>
    <Nav/>
    <Header page-name="To-Do List"/>

    <section>
        <SearchRecipe 
            @handle-recipe-request="handleRecipeRequest"
        />
    </section>

    <section>
        <List
            v-if="data"
            :data="data[0]"
            :requested-item="requestedItem"
            :quantity="requestedQuantity"
        />
    </section>
    
</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SearchRecipe from '@/js/vue/components/general/SearchRecipe.vue';
import List from '@/js/vue/components/general/List.vue';

const requestedItem = ref(null),
    requestedQuantity = ref(null),
    data = ref(null);

const handleRecipeRequest = async (searchResults, quantity) => {
    requestedItem.value = searchResults; 
    requestedQuantity.value = quantity; 

    const response = await fetch(`../api/recipes/${searchResults.id}/${quantity}`);
    const responseData = await response.json(); 

    data.value = responseData;

    console.log('recipe response: ', data.value);

}

</script>