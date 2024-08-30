<template>
    <Nav/>
    <Header page-name="To-Do List"/>

    <section>
        <SearchRecipe 
            @handle-recipe-request="handleRecipeRequest"
        />

        <button @click="saveList(checklist)">Save List</button>
        <button @click="getSavedList()">Get List</button>
    </section>

    <section>
        <List
            v-if="checklist"
            v-for="entry in checklist"
            :checklist="entry"
            :quantity="requestedQuantity"
        />
    </section>
    
</template>

<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SearchRecipe from '@/js/vue/components/general/SearchRecipe.vue';
import List from '@/js/vue/components/general/List.vue';

const requestedItem = ref(null),
    requestedQuantity = ref(null),
    checklist = ref([]);

const handleRecipeRequest = async (searchResults, quantity) => {
    requestedItem.value = searchResults; 
    requestedQuantity.value = quantity; 

    const response = await fetch(`../api/recipes/${searchResults.id}/${quantity}`);
    const responseData = await response.json(); 

    console.log('current data: ', checklist.value, responseData);

    checklist.value.push(responseData[0]);

    console.log('recipe response: ', checklist.value);
}

const saveList = async (checklist) => {
    console.log('saved checklist: ', checklist);
    try {
        const response = await axios.post('../api/user/saveChecklist', {
            checklist: checklist, 
        })

        if (response){
            console.log('Saved checklist');
        }
    } catch (error){
        console.log('Checklist did not save: ', error);
    }
}

const getSavedList = async () => {
    try {
        const response = await axios.get('../api/user/getChecklist');

        if (response){
            console.log('get saved checklist: ', response.data);
            checklist.value = response.data; 
        }
    } catch (error){
        console.log('Did not receive any checklists: ', error);
    }
}

// onMounted( async () => {
//     getSavedList(); 
// })

</script>