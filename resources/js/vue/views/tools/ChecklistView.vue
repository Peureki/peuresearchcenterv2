<template>
    <Nav/>
    <Header page-name="Checklist"/>

    <section class="main" v-if="!user">
        <Disclaimer
            message="You must be registered and logged on to save a list"
        />
    </section>

    <!--
        *
        * RECIPE FINDER && ICONS
        *
    -->
    <section class="main">
        <div class="content-section">
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
                    class="icon clickable" 
                    @click="customEntryToggle = !customEntryToggle"
                    :class="activeButton(customEntryToggle)"
                    width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M13.8436 1.42344C13.5373 0.865625 12.8061 0.5 11.9998 0.5C11.1936 0.5 10.4623 0.865625 10.1561 1.42344L2.65608 14.9234L0.156078 19.4234C-0.268922 20.1875 0.212329 21.0641 1.23108 21.3828C2.24983 21.7016 3.41858 21.3406 3.84358 20.5766L5.83108 17H18.1623L20.1498 20.5766C20.5748 21.3406 21.7436 21.7016 22.7623 21.3828C23.7811 21.0641 24.2623 20.1875 23.8373 19.4234L21.3373 14.9234L13.8373 1.42344H13.8436ZM16.4998 14H7.49983L11.9998 5.9L16.4998 14Z" fill="#FFD12C"/>
                    <title>Add Custom Entry</title>
                </svg>


                <svg 
                    @click="searchItemToggle = !searchItemToggle"
                    class="icon clickable" 
                    :class="activeButton(searchItemToggle)"
                    width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M18.2497 3.64508e-09H12.2497C12.1348 -1.13191e-05 12.0215 0.0263566 11.9185 0.0770702C11.8154 0.127784 11.7254 0.201488 11.6553 0.2925L5.65532 8.09344L4.7497 7.18969C4.61039 7.05022 4.44495 6.93958 4.26286 6.8641C4.08076 6.78861 3.88557 6.74976 3.68845 6.74976C3.49132 6.74976 3.29613 6.78861 3.11404 6.8641C2.93194 6.93958 2.76651 7.05022 2.6272 7.18969L1.43751 8.38031C1.29818 8.5196 1.18766 8.68498 1.11226 8.86699C1.03686 9.049 0.998047 9.24408 0.998047 9.44109C0.998047 9.63811 1.03686 9.83319 1.11226 10.0152C1.18766 10.1972 1.29818 10.3626 1.43751 10.5019L3.31251 12.3769L0.687508 15.0019C0.548184 15.1412 0.437664 15.3065 0.36226 15.4886C0.286857 15.6706 0.248047 15.8656 0.248047 16.0627C0.248047 16.2597 0.286857 16.4548 0.36226 16.6368C0.437664 16.8188 0.548184 16.9841 0.687508 17.1234L1.8772 18.3122C2.15847 18.5933 2.53985 18.7512 2.93751 18.7512C3.33516 18.7512 3.71654 18.5933 3.99782 18.3122L6.62282 15.6872L8.49782 17.5622C8.63713 17.7017 8.80256 17.8123 8.98466 17.8878C9.16676 17.9633 9.36195 18.0021 9.55907 18.0021C9.75619 18.0021 9.95138 17.9633 10.1335 17.8878C10.3156 17.8123 10.481 17.7017 10.6203 17.5622L11.81 16.3716C11.9493 16.2323 12.0599 16.0669 12.1353 15.8849C12.2107 15.7029 12.2495 15.5078 12.2495 15.3108C12.2495 15.1138 12.2107 14.9187 12.1353 14.7367C12.0599 14.5547 11.9493 14.3893 11.81 14.25L10.9063 13.3463L18.7072 7.34625C18.7985 7.276 18.8723 7.18567 18.923 7.08227C18.9738 6.97887 19 6.86517 18.9997 6.75V0.75C18.9997 0.551088 18.9207 0.360322 18.78 0.21967C18.6394 0.0790178 18.4486 3.64508e-09 18.2497 3.64508e-09ZM2.93938 17.25L1.7497 16.0613L4.3747 13.4363L5.56345 14.625L2.93938 17.25ZM9.55907 16.5L2.4997 9.44156L3.69032 8.25L10.7497 15.3103L9.55907 16.5ZM17.4997 6.38062L9.83657 12.2756L8.81095 11.25L13.5303 6.53063C13.6709 6.38989 13.7499 6.19907 13.7498 6.00014C13.7497 5.8012 13.6706 5.61045 13.5299 5.46984C13.3891 5.32924 13.1983 5.2503 12.9994 5.25038C12.8004 5.25047 12.6097 5.32958 12.4691 5.47031L7.7497 10.1887L6.72501 9.16313L12.6191 1.5H17.4997V6.38062Z" fill="#FFD12C"/>
                    <title>Add Item</title>
                </svg>

                <svg
                    @click="searchRecipeToggle = !searchRecipeToggle"
                    class="icon clickable"
                    :class="activeButton(searchRecipeToggle)" 
                    width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M13 5.9V4.2C13.55 3.96667 14.1127 3.79167 14.688 3.675C15.2633 3.55833 15.8673 3.5 16.5 3.5C16.9333 3.5 17.3583 3.53333 17.775 3.6C18.1917 3.66667 18.6 3.75 19 3.85V5.45C18.6 5.3 18.1957 5.18767 17.787 5.113C17.3783 5.03833 16.9493 5.00067 16.5 5C15.8667 5 15.2583 5.07933 14.675 5.238C14.0917 5.39667 13.5333 5.61733 13 5.9ZM13 11.4V9.7C13.55 9.46667 14.1127 9.29167 14.688 9.175C15.2633 9.05833 15.8673 9 16.5 9C16.9333 9 17.3583 9.03333 17.775 9.1C18.1917 9.16667 18.6 9.25 19 9.35V10.95C18.6 10.8 18.1957 10.6873 17.787 10.612C17.3783 10.5367 16.9493 10.4993 16.5 10.5C15.8667 10.5 15.2583 10.575 14.675 10.725C14.0917 10.875 13.5333 11.1 13 11.4ZM13 8.65V6.95C13.55 6.71667 14.1127 6.54167 14.688 6.425C15.2633 6.30833 15.8673 6.25 16.5 6.25C16.9333 6.25 17.3583 6.28333 17.775 6.35C18.1917 6.41667 18.6 6.5 19 6.6V8.2C18.6 8.05 18.1957 7.93733 17.787 7.862C17.3783 7.78667 16.9493 7.74933 16.5 7.75C15.8667 7.75 15.2583 7.82933 14.675 7.988C14.0917 8.14667 13.5333 8.36733 13 8.65ZM5.5 12C6.28333 12 7.046 12.0877 7.788 12.263C8.53 12.4383 9.26733 12.7007 10 13.05V3.2C9.31667 2.8 8.59167 2.5 7.825 2.3C7.05833 2.1 6.28333 2 5.5 2C4.9 2 4.304 2.05833 3.712 2.175C3.12 2.29167 2.54933 2.46667 2 2.7V12.6C2.58333 12.4 3.16267 12.25 3.738 12.15C4.31333 12.05 4.90067 12 5.5 12ZM12 13.05C12.7333 12.7 13.471 12.4377 14.213 12.263C14.955 12.0883 15.7173 12.0007 16.5 12C17.1 12 17.6877 12.05 18.263 12.15C18.8383 12.25 19.4173 12.4 20 12.6V2.7C19.45 2.46667 18.879 2.29167 18.287 2.175C17.695 2.05833 17.0993 2 16.5 2C15.7167 2 14.9417 2.1 14.175 2.3C13.4083 2.5 12.6833 2.8 12 3.2V13.05ZM11 16C10.2 15.3667 9.33333 14.875 8.4 14.525C7.46667 14.175 6.5 14 5.5 14C4.8 14 4.11267 14.0917 3.438 14.275C2.76333 14.4583 2.11733 14.7167 1.5 15.05C1.15 15.2333 0.812667 15.225 0.488 15.025C0.163333 14.825 0.000666667 14.5333 0 14.15V2.1C0 1.91667 0.046 1.74167 0.138 1.575C0.23 1.40833 0.367333 1.28333 0.55 1.2C1.31667 0.8 2.11667 0.5 2.95 0.3C3.78333 0.1 4.63333 0 5.5 0C6.46667 0 7.41267 0.125 8.338 0.375C9.26333 0.625 10.1507 1 11 1.5C11.85 1 12.7377 0.625 13.663 0.375C14.5883 0.125 15.534 0 16.5 0C17.3667 0 18.2167 0.1 19.05 0.3C19.8833 0.5 20.6833 0.8 21.45 1.2C21.6333 1.28333 21.771 1.40833 21.863 1.575C21.955 1.74167 22.0007 1.91667 22 2.1V14.15C22 14.5333 21.8377 14.825 21.513 15.025C21.1883 15.225 20.8507 15.2333 20.5 15.05C19.8833 14.7167 19.2377 14.4583 18.563 14.275C17.8883 14.0917 17.2007 14 16.5 14C15.5 14 14.5333 14.175 13.6 14.525C12.6667 14.875 11.8 15.3667 11 16Z" fill="#FFD12C"/>
                    <title>Add Recipe</title>
                </svg>


                <div class="import-and-save">
                    <!-- <svg 
                        @click="getSavedList(); showDBMessage('import');"
                        class="import"
                        width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M12 8L8 4V7H0V9H8V12M18 14V2C18 1.46957 17.7893 0.960859 17.4142 0.585786C17.0391 0.210714 16.5304 0 16 0H4C3.46957 0 2.96086 0.210714 2.58579 0.585786C2.21071 0.960859 2 1.46957 2 2V5H4V2H16V14H4V11H2V14C2 14.5304 2.21071 15.0391 2.58579 15.4142C2.96086 15.7893 3.46957 16 4 16H16C16.5304 16 17.0391 15.7893 17.4142 15.4142C17.7893 15.0391 18 14.5304 18 14Z" fill="#FFD12C"/>
                        <title>Import Previously Saved Checklist</title>
                    </svg> -->

                    <svg 
                        @click="saveList(checklist); showDBMessage('save');"
                        class="save" 
                        width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M18 4V16C18 16.55 17.8043 17.021 17.413 17.413C17.0217 17.805 16.5507 18.0007 16 18H2C1.45 18 0.979333 17.8043 0.588 17.413C0.196667 17.0217 0.000666667 16.5507 0 16V2C0 1.45 0.196 0.979333 0.588 0.588C0.98 0.196667 1.45067 0.000666667 2 0H14L18 4ZM16 4.85L13.15 2H2V16H16V4.85ZM9 15C9.83333 15 10.5417 14.7083 11.125 14.125C11.7083 13.5417 12 12.8333 12 12C12 11.1667 11.7083 10.4583 11.125 9.875C10.5417 9.29167 9.83333 9 9 9C8.16667 9 7.45833 9.29167 6.875 9.875C6.29167 10.4583 6 11.1667 6 12C6 12.8333 6.29167 13.5417 6.875 14.125C7.45833 14.7083 8.16667 15 9 15ZM3 7H12V3H3V7ZM2 4.85V16V2V4.85Z" fill="#FFD12C"/>
                        <title>Save Checklist</title>
                    </svg>

                    <PopUpMessage v-if="unsavedChanges" message="Unsaved changes" />
                    <PopUpMessage v-if="dbToggle" :message="dbMessage"/>
                    
                </div>
            </div>
            

            
            
            <!-- <button @click="getChecklist">Get checklist</button> -->
             
        </div> <!-- End of content section -->
    </section>

    <section class="main" v-if="searchItemToggle || customEntryToggle || searchRecipeToggle">
        <div class="content-section">
            <AddCustomEntry
                v-if="customEntryToggle"
                @add-custom-entry="handleCustomEntry"
            />

            <SearchRecipe
                v-if="searchRecipeToggle"
                @handle-recipe-request="handleRecipeRequest"
            />

            <SearchItem
                v-if="searchItemToggle"
                @handle-item-search="handleItemSearch"
            />
        </div>
    </section>

    <section class="main">
        <div class="overflow-x">
            <div class="content-section">
                <Loading v-if="!checklist" :width="200" :height="200"/>
                <List
                    v-if="checklist"
                    v-for="(entry, index) in checklist"
                    @pop-entry="popEntry"
                    :entry="entry"
                    :entry-index="index"
                    :quantity="requestedQuantity"
                />
            </div>
        </div>
    </section>
    
    <Blurb>
        <span>
            <p class="small-subtitle">Most Mystic Forge recipes supplied by GW2Efficiency</p>
            <a href="https://github.com/gw2efficiency/custom-recipes" target="_blank" class="small-subtitle">GW2Efficiency's Github</a>
            <a href="https://github.com/Peureki/peuresearchcenterv2/blob/main/resources/js/vue/components/json/changes.txt" target="_blank" class="small-subtitle">Personal changes to the original list</a>
        </span>
    </Blurb>
    <Footer/>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import axios from 'axios';
import { user } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import PopUpMessage from '@/js/vue/components/general/PopUpMessage.vue';
import Blurb from '@/js/vue/components/general/Blurb.vue'

import SearchRecipe from '@/js/vue/components/general/SearchRecipe.vue';
import SearchItem from '@/js/vue/components/general/SearchItem.vue';
import AddCustomEntry from '@/js/vue/components/general/AddCustomEntry.vue'
import List from '@/js/vue/components/general/List.vue';

const requestedItem = ref(null),
    requestedQuantity = ref(null),
    entryInput = ref(null),
    entryNumber = ref(1),
    checklist = ref([]);

// Populate this checklist when checklist is loaded
// Compare this checklist to the new one to signal if it's changed from the oringinal
const loadedChecklist = ref([]),
    unsavedChanges = ref(false);

const searchItemToggle = ref(false),
    searchRecipeToggle = ref(false),
    customEntryToggle = ref(false);

// Message to show when user interacts with import, saving from, to db
const dbToggle = ref(false),
    dbMessage = ref(null);

// Show message that the user has either imported or saved their checklist after clicking those respective buttons
const showDBMessage = (action) => {
    switch (action){
        case 'import':
            dbMessage.value = 'Imported checklist from your last save'
        break;

        case 'save':
            dbMessage.value = 'Saved checklist!'
        break;
    }

    dbToggle.value = true; 

    setTimeout(() => {
        dbToggle.value = false;
    }, 3000);
}

const handleRecipeRequest = async (searchResults, quantity) => {
    if (!Array.isArray(checklist.value)){
        checklist.value = []; 
    }
    
    requestedItem.value = searchResults; 
    requestedQuantity.value = quantity; 

    const response = await fetch(`../api/recipes/${searchResults.id}/${quantity}`);
    const responseData = await response.json(); 

    console.log('requested recipe: ', responseData[0]);

    checklist.value = [
        ...checklist.value, 
        {
        count: responseData[0].output_item_count,
        name: responseData[0].name,
        icon: responseData[0].icon,
        ingredients: responseData[0].ingredients,
    }];
}

const handleCustomEntry = (quantity, entry) => {
    if (!Array.isArray(checklist.value)){
        checklist.value = []; 
    }

    checklist.value = [
        ...checklist.value, 
        {
            count: quantity, 
            name: entry,
        }
    ];
}

const handleItemSearch = async (searchResults) => {
    if (!Array.isArray(checklist.value)){
        checklist.value = []; 
    }

    console.log('item search results: ', searchResults);

    checklist.value = [
        ...checklist.value,
        {
            count: searchResults.count, 
            name: searchResults.name,
            icon: searchResults.icon
        }
    ]
}

const popEntry = (entryIndex) => {
    console.log('pop this entry: ', entryIndex);
    checklist.value.splice(entryIndex, 1);
    checklist.value = [...checklist.value];
}


const saveList = async (checklist) => {
    console.log('saved checklist: ', checklist);

    try {
        const response = await axios.post('../api/user/saveChecklist', {
            checklist: checklist, 
        })

        if (response){
            console.log('Saved checklist', checklist);
            loadedChecklist.value = checklist.value;
            unsavedChanges.value = false;
        }
    } catch (error){
        console.log('Checklist did not save: ', error);
    }
}
// *
// * GET SAVED CHECKLSIT from database
// * Only trigger if user is auth
const getSavedList = async () => {
    try {
        const response = await axios.get('../api/user/getChecklist');

        if (response){
            console.log('get saved checklist: ', response.data);
            checklist.value = response.data; 
            loadedChecklist.value = checklist.value; 
        }
    } catch (error){
        console.log('Did not receive any checklists: ', error);
    }
}

// Turns button red when active
const activeButton = (toggle) => {
    if (toggle){
        return 'active-checklist'
    } else {
        return ''
    }
}

onMounted( async () => {
    await getAuthUser();

    // IF USER FOUND
    if (user.value){
        getSavedList(); 
    } else {

    }
})

watch(checklist, (newChecklist) => {
    if (newChecklist){
        if (newChecklist !== loadedChecklist.value){
            unsavedChanges.value = true; 
        } 
    }
})

</script>

<style scoped>
.import-and-save{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
    padding-left: var(--gap-content);
}

</style>