<template>
    <Nav/>
    <Header page-name="Checklist"/>

    <!--
        *
        * RECIPE FINDER && ICONS
        *
    -->
    <section>
        <div class="two-col-container">
            <SearchRecipe 
                @handle-recipe-request="handleRecipeRequest"
            />

            <SearchItem
                @handle-item-search="handleItemSearch"
            />

            <!-- <form @submit.prevent="addCustomEntry(entryNumber, entryInput)">
                <input
                    class="small-number-field"
                    type="number"
                    min="0"
                    v-model="entryNumber"
                >
                <input
                    type="text"
                    placeholder="New Entry"
                    v-model="entryInput"
                >
                <button class="submit" type="submit">Add Custom Entry</button>
            </form> -->

            <div class="icons">
                <svg 
                    @click="saveList(checklist)"
                    class="save" 
                    width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M18 4V16C18 16.55 17.8043 17.021 17.413 17.413C17.0217 17.805 16.5507 18.0007 16 18H2C1.45 18 0.979333 17.8043 0.588 17.413C0.196667 17.0217 0.000666667 16.5507 0 16V2C0 1.45 0.196 0.979333 0.588 0.588C0.98 0.196667 1.45067 0.000666667 2 0H14L18 4ZM16 4.85L13.15 2H2V16H16V4.85ZM9 15C9.83333 15 10.5417 14.7083 11.125 14.125C11.7083 13.5417 12 12.8333 12 12C12 11.1667 11.7083 10.4583 11.125 9.875C10.5417 9.29167 9.83333 9 9 9C8.16667 9 7.45833 9.29167 6.875 9.875C6.29167 10.4583 6 11.1667 6 12C6 12.8333 6.29167 13.5417 6.875 14.125C7.45833 14.7083 8.16667 15 9 15ZM3 7H12V3H3V7ZM2 4.85V16V2V4.85Z" fill="#FFD12C"/>
                    <title>Save Checklist</title>
                </svg>

                <svg 
                    @click="getSavedList()"
                    class="import"
                    width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M12 8L8 4V7H0V9H8V12M18 14V2C18 1.46957 17.7893 0.960859 17.4142 0.585786C17.0391 0.210714 16.5304 0 16 0H4C3.46957 0 2.96086 0.210714 2.58579 0.585786C2.21071 0.960859 2 1.46957 2 2V5H4V2H16V14H4V11H2V14C2 14.5304 2.21071 15.0391 2.58579 15.4142C2.96086 15.7893 3.46957 16 4 16H16C16.5304 16 17.0391 15.7893 17.4142 15.4142C17.7893 15.0391 18 14.5304 18 14Z" fill="#FFD12C"/>
                    <title>Import Previously Saved Checklist</title>
                </svg>
            </div>
        </div>
    </section>

    <!--
        *
        * ADD NEW ENTRY 
        *
    -->
    <section>
        
    </section>

    <section>
        <List
            v-if="checklist"
            v-for="(entry, index) in checklist"
            @pop-entry="popEntry"
            :entry="entry"
            :entry-index="index"
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
import SearchItem from '@/js/vue/components/general/SearchItem.vue';
import List from '@/js/vue/components/general/List.vue';
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'

const requestedItem = ref(null),
    requestedQuantity = ref(null),
    entryInput = ref(null),
    entryNumber = ref(1),
    checklist = ref([]);

const handleRecipeRequest = async (searchResults, quantity) => {
    requestedItem.value = searchResults; 
    requestedQuantity.value = quantity; 

    const response = await fetch(`../api/recipes/${searchResults.id}/${quantity}`);
    const responseData = await response.json(); 

    checklist.value.push(responseData[0]);
}

const handleItemSearch = async (searchResults) => {
    checklist.value.push(searchResults)
}

const popEntry = (entryIndex) => {
    console.log('pop this entry: ', entryIndex);
    checklist.value.splice(entryIndex, 1);
}


const addCustomEntry = (count, newEntry) => {
    const newEntryInput = {
        count: count,
        name: newEntry,
    }
    checklist.value.push(newEntryInput); 
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

onMounted( async () => {
    getSavedList(); 
})

</script>