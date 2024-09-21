<template>
    <Header page-name="Research Notes"/>
    <Nav>
        <template v-slot:filters>
            <p v-if="!user" class="error-message">Register/Login to be able to save these Filters</p>

            <div class="filter-container">
                <h3>Filters</h3>

                <!-- 
                    *
                    * PREFERENCES FILTERS
                    *
                -->
                <p>Preferences</p>
                <div class="filter-collection">
                    <FilterToggle
                        v-for="filter in filterPreferences"
                        :toggle-option="filter"
                    />
                </div>
                <Disclaimer v-if="preferenceError" message="At least 1 Preference needs to be active"/>
            
            </div>
            
            <div class="filter-container">
                <!-- 
                    *
                    * DISCIPLINE FILTERS
                    *
                -->
                <p>Disciplines</p>
                <div class="filter-collection">
                    <FilterToggle
                        v-for="filter in filterDisciplines"
                        :toggle-option="filter"
                    />
                </div>
                <Disclaimer v-if="disciplineError" message="At least 1 Discipline needs to be active"/>
            </div>
            
            <div class="filter-container">
                <!-- 
                    *
                    * ITEM TYPES
                    *
                -->
                <p>Item Types</p>
                <div class="filter-collection">
                    <FilterToggle
                        v-for="filter in filterItemTypes"
                        :toggle-option="filter"
                    />
                </div>
                <Disclaimer v-if="typeError" message="At least 1 Item Type needs to be active"/>
            </div>
            
            <div class="filter-container">
                <p>Set new filters</p>
                <div class="filter-collection">
                    
                    <button 
                        @click="saveFilters();"
                    >
                        Save & Refresh
                    </button>
                </div>
            </div>
            
        </template>
    </Nav>

    <section class="main">
        <div class="content-section">
            <Loading v-if="!researchNotes || currentlyRefreshing" :width="200" :height="200"/>

            

            <ResearchNotesCard
                v-if="researchNotes"
                :currency-icon="ResearchNote"
                target-currency="Research Note"
                :research-notes="researchNotes"
                @new-url="getResearchNotes"
            />

            <Disclaimer v-if="researchNotes && researchNotes.data == 0"
                message="Check your Filters if empty"
            />
        </div>
        
        <!-- <ResearchNotesTable/> -->
    </section>

    <Footer/>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'
import PopUpMessage from '@/js/vue/components/general/PopUpMessage.vue'

import ResearchNotesCard from '@/js/vue/components/tables/ResearchNotesCard.vue'

import ResearchNote from '@/imgs/icons/Research_Note.png'

import FilterToggle from '@/js/vue/components/general/FilterToggle.vue'

import { pageRefresh } from '@/js/vue/composables/BasicFunctions'
import axios from 'axios'
import { filterResearchNotes, user, buyOrder, sellOrder, tax, refreshSettings } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication'

// *
// * FILTERED LIST TO DISPLAY
// * Add more if there's another thing to filter out for research notes
const filterPreferences = ['Crafting', 'TP'];
const filterDisciplines = ['Armorsmith', 'Artificer', 'Chef', 'Huntsman', 'Jeweler', 'Leatherworker', 'Scribe', 'Tailor', 'Weaponsmith'];
const filterItemTypes = ['Consumable', 'Weapon', 'Armor', 'Back', 'Trinket'];

const preferenceError = ref(false),
    disciplineError = ref(false),
    typeError = ref(false);

const researchNotes = ref(null);
// To trigger watch to refresh output without refreshing the page
const refreshFilters = ref(false),
    currentlyRefreshing = ref(false); 

const saveFilters = async () => {
    try {
        const response = await axios.post('../api/user/saveFilterResearchNotes', {
            filter_research_notes: filterResearchNotes.value, 
        })

        if (response){
            console.log('Saved Filter preferenes', filterResearchNotes.value, response)
            // Trigger watch
            refreshFilters.value = true;
        }
    } catch (error) {
        console.log('Filter for research notes did not save: ', error);
    }
}

const url = computed(() => {
    return `../api/currencies/research-note/${buyOrder.value}/${JSON.stringify(filterResearchNotes.value)}`;
})

const getResearchNotes = async (url) => {
    try {
        const response = await fetch(url);
        const responseData = await response.json();

        researchNotes.value = responseData;
        console.log('research notes: ', researchNotes.value.data);
    } catch (error){
        console.log('Error fetching data: ', error);
    }
}

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser(url.value);
    console.log('url: ', url.value);
    getResearchNotes(url.value); 
    checkFilterDisclaimers(filterResearchNotes.value);
})

// Check if the filters need their Disclaimers to be active or not
// Checks to see if each of the preferenc categories has at least one active at a time
const checkFilterDisclaimers = (currentFilters) => {
    console.log('current filters: ', currentFilters);
    // If null
    if (!currentFilters){
        preferenceError.value = true; 
        disciplineError.value = true;
        typeError.value = true; 
    // If !null
    } else {
        if (currentFilters.includes('TP') || currentFilters.includes('Crafting')){
            preferenceError.value = false; 
        } else {
            preferenceError.value = true;
        }

        if (currentFilters.includes('Armorsmith')
            || currentFilters.includes('Artificer')
            || currentFilters.includes('Chef')
            || currentFilters.includes('Huntsman')
            || currentFilters.includes('Jeweler')
            || currentFilters.includes('Leatherworker')
            || currentFilters.includes('Tailor')
            || currentFilters.includes('Weaponsmith')
        ){
            disciplineError.value = false;
        } else {
            disciplineError.value = true;
        }

        if (
            currentFilters.includes('Consumable')
            || currentFilters.includes('Weapon')
            || currentFilters.includes('Armor')
            || currentFilters.includes('Back')
            || currentFilters.includes('Trinket')
        ){
            typeError.value = false;
        } else {
            typeError.value = true; 
        }
    }
}



// *
// * REFRESH FILTERS
// * Changes when users Save their filters
// * Allows users to change what data to display without refreshing the page
watch(refreshFilters, async (newFilters) => {
    if (newFilters){
        currentlyRefreshing.value = true; 

        await getResearchNotes(url.value);

        currentlyRefreshing.value = false;
        refreshFilters.value = false;
    }
})
// *
// * REFRESH SETTINGS
// * Changes when users Save their settings
// * Allows users to change what data to display without refreshing the page
watch(refreshSettings, async (newSettings) => {
    if (newSettings){
        currentlyRefreshing.value = true; 

        await getResearchNotes(url.value);

        currentlyRefreshing.value = false;
        refreshSettings.value = false; 
    }
})
// Whenever users toggle the filters on/off, check if the Disclaimers need to be active or not
watch(filterResearchNotes, (newFilters) => {
    if (newFilters){
        checkFilterDisclaimers(newFilters);
    }
})



</script>