<template>
    <Nav/>
    <Header page-name="Checklist"/>

    <section class="main">
        <Disclaimer
            v-if="!user"
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
                <svg class="icon clickable" 
                    @click="customEntryToggle = !customEntryToggle"
                    :class="activeButton(customEntryToggle)"
                    width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M17.71 4.04006C18.1 3.65006 18.1 3.00006 17.71 2.63006L15.37 0.290059C15 -0.0999414 14.35 -0.0999414 13.96 0.290059L12.12 2.12006L15.87 5.87006M0 14.2501V18.0001H3.75L14.81 6.93006L11.06 3.18006L0 14.2501Z" fill="#FFD12C"/>
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
                    width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M22.4544 8.85976L16.5041 2.86726C14.7446 1.11138 12.3603 0.125244 9.87456 0.125244C7.38879 0.125244 5.00455 1.11138 3.24503 2.86726L3.23284 2.88038L1.94097 4.21351C1.73335 4.42784 1.61938 4.71586 1.62413 5.01422C1.62888 5.31258 1.75195 5.59683 1.96628 5.80445C2.18061 6.01206 2.46863 6.12603 2.76699 6.12128C3.06535 6.11654 3.3496 5.99346 3.55722 5.77913L4.84253 4.45257C5.26806 4.0272 5.74595 3.65768 6.26472 3.35288L10.1563 7.25007L1.42347 15.9838C1.24928 16.1579 1.1111 16.3647 1.01682 16.5922C0.922547 16.8197 0.874023 17.0636 0.874023 17.3099C0.874023 17.5562 0.922547 17.8001 1.01682 18.0276C1.1111 18.2552 1.24928 18.4619 1.42347 18.636L3.36315 20.5757C3.71477 20.9272 4.1916 21.1247 4.68878 21.1247C5.18596 21.1247 5.66279 20.9272 6.0144 20.5757L14.75 11.8438L14.8916 11.9854L17.1088 14.2035C17.2829 14.3777 17.4896 14.5159 17.7172 14.6102C17.9447 14.7044 18.1886 14.753 18.4349 14.753C18.6812 14.753 18.925 14.7044 19.1526 14.6102C19.3801 14.5159 19.5868 14.3777 19.761 14.2035L22.4507 11.5129C22.6252 11.339 22.7638 11.1324 22.8585 10.9049C22.9532 10.6774 23.0021 10.4335 23.0024 10.1871C23.0028 9.94069 22.9546 9.69664 22.8605 9.46888C22.7665 9.24113 22.6285 9.03414 22.4544 8.85976ZM4.68878 18.7194L3.28253 17.3132L9.12503 11.4688L10.5313 12.8751L4.68878 18.7194ZM12.125 11.2813L10.7188 9.87507L12.5478 8.04601C12.6527 7.94149 12.7359 7.8173 12.7927 7.68055C12.8495 7.54381 12.8787 7.3972 12.8787 7.24913C12.8787 7.10107 12.8495 6.95446 12.7927 6.81771C12.7359 6.68097 12.6527 6.55677 12.5478 6.45226L8.58503 2.49132C9.71959 2.28165 10.8881 2.35087 11.99 2.69301C13.0919 3.03515 14.0941 3.63997 14.9103 4.45538L17.8578 7.42445L15.6875 9.59382L15.546 9.45226C15.4414 9.34738 15.3173 9.26416 15.1805 9.20738C15.0438 9.1506 14.8972 9.12137 14.7491 9.12137C14.601 9.12137 14.4544 9.1506 14.3177 9.20738C14.1809 9.26416 14.0567 9.34738 13.9522 9.45226L12.125 11.2813ZM18.4363 12.3416L17.2813 11.1876L19.446 9.02288L20.5991 10.1844L18.4363 12.3416Z" fill="#FFD12C"/>
                    <title>Add Recipe</title>
                </svg>

                <div class="import-and-save">
                    <svg 
                        @click="getSavedList()"
                        class="import"
                        width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M12 8L8 4V7H0V9H8V12M18 14V2C18 1.46957 17.7893 0.960859 17.4142 0.585786C17.0391 0.210714 16.5304 0 16 0H4C3.46957 0 2.96086 0.210714 2.58579 0.585786C2.21071 0.960859 2 1.46957 2 2V5H4V2H16V14H4V11H2V14C2 14.5304 2.21071 15.0391 2.58579 15.4142C2.96086 15.7893 3.46957 16 4 16H16C16.5304 16 17.0391 15.7893 17.4142 15.4142C17.7893 15.0391 18 14.5304 18 14Z" fill="#FFD12C"/>
                        <title>Import Previously Saved Checklist</title>
                    </svg>

                    <svg 
                        @click="saveList(checklist)"
                        class="save" 
                        width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M18 4V16C18 16.55 17.8043 17.021 17.413 17.413C17.0217 17.805 16.5507 18.0007 16 18H2C1.45 18 0.979333 17.8043 0.588 17.413C0.196667 17.0217 0.000666667 16.5507 0 16V2C0 1.45 0.196 0.979333 0.588 0.588C0.98 0.196667 1.45067 0.000666667 2 0H14L18 4ZM16 4.85L13.15 2H2V16H16V4.85ZM9 15C9.83333 15 10.5417 14.7083 11.125 14.125C11.7083 13.5417 12 12.8333 12 12C12 11.1667 11.7083 10.4583 11.125 9.875C10.5417 9.29167 9.83333 9 9 9C8.16667 9 7.45833 9.29167 6.875 9.875C6.29167 10.4583 6 11.1667 6 12C6 12.8333 6.29167 13.5417 6.875 14.125C7.45833 14.7083 8.16667 15 9 15ZM3 7H12V3H3V7ZM2 4.85V16V2V4.85Z" fill="#FFD12C"/>
                        <title>Save Checklist</title>
                    </svg>
                </div>

                

                
            </div>
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
    
</template>

<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios';
import { user } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

import SearchRecipe from '@/js/vue/components/general/SearchRecipe.vue';
import SearchItem from '@/js/vue/components/general/SearchItem.vue';
import AddCustomEntry from '@/js/vue/components/general/AddCustomEntry.vue'
import List from '@/js/vue/components/general/List.vue';
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'

const requestedItem = ref(null),
    requestedQuantity = ref(null),
    entryInput = ref(null),
    entryNumber = ref(1),
    checklist = ref([]);

const searchItemToggle = ref(false),
    searchRecipeToggle = ref(false),
    customEntryToggle = ref(false);

const handleRecipeRequest = async (searchResults, quantity) => {
    requestedItem.value = searchResults; 
    requestedQuantity.value = quantity; 

    const response = await fetch(`../api/recipes/${searchResults.id}/${quantity}`);
    const responseData = await response.json(); 

    checklist.value.push(responseData[0]);
}

const handleCustomEntry = (quantity, entry) => {
    checklist.value.push({
        count: quantity, 
        name: entry,
    })
}

const handleItemSearch = async (searchResults) => {
    checklist.value.push(searchResults)
}

const popEntry = (entryIndex) => {
    console.log('pop this entry: ', entryIndex);
    checklist.value.splice(entryIndex, 1);
}


const saveList = async (checklist) => {
    console.log('saved checklist: ', checklist);
    try {
        const response = await axios.post('../api/user/saveChecklist', {
            checklist: checklist, 
        })

        if (response){
            console.log('Saved checklist', checklist);
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

</script>

<style scoped>
.import-and-save{
    display: flex;
    gap: var(--gap-general);
    padding-left: var(--gap-content);
}

</style>