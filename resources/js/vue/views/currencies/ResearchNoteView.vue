<template>
    <Header page-name="Research Notes"/>
    <Nav>
        <template v-slot:filters>
            <article class="shortcut-container">
                <h3>Filters</h3>

                <!-- 
                    *
                    * PREFERENCES FILTERS
                    *
                -->
                <p>Preferences</p>
                <!-- <div class="filter-container">
                    <button
                        v-for="(toggle, index) in preferenceToggles" 
                        @click="
                            toggleFilter('filterResearchNotes', index, preferenceToggles, preferenceErrorRef)
                        "
                        :class="toggle.status.value == true ? 'active-button' : 'inactive-button'"
                    >
                        {{ toggle.name }}
                    </button>
                </div> -->

                <div class="filter-container">
                    <FilterToggle
                        v-for="filter in filterPreferences"
                        :toggle-option="filter"
                    />
                </div>
                


                <Transition name="fade"><p v-if="preferenceError" class="error-message">Needs 1+ active</p></Transition>

                <!-- 
                    *
                    * DISCIPLINE FILTERS
                    *
                -->
                <p>Disciplines</p>
                <div class="filter-container">
                    <FilterToggle
                        v-for="filter in filterDisciplines"
                        :toggle-option="filter"
                    />
                </div>
                <Transition name="fade"><p v-if="disciplineError" class="error-message">Needs 1+ active</p></Transition>

                <!-- 
                    *
                    * ITEM TYPES
                    *
                -->
                <p>Item Types</p>
                <div class="filter-container">
                    <FilterToggle
                        v-for="filter in filterItemTypes"
                        :toggle-option="filter"
                    />
                </div>
                <Transition name="fade"><p v-if="typeError" class="error-message">Needs 1+ active</p></Transition>

                <p>Set new filters</p>
                <div class="filter-container">
                    
                    <button 
                        @click="saveFilters(); pageRefresh();"
                    >
                        Save & Refresh
                    </button>

                </div>
            </article>
        </template>
    </Nav>

    <section class="main">
        <Loading v-if="!researchNotes" :width="200" :height="200"/>

        <ResearchNotesCard
            v-if="researchNotes"
            :currency-icon="ResearchNote"
            target-currency="Research Note"
            :research-notes="researchNotes"
            @new-url="getResearchNotes"
        />
        <!-- <ResearchNotesTable/> -->
    </section>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import ResearchNotesCard from '@/js/vue/components/tables/ResearchNotesCard.vue'

import ResearchNote from '@/imgs/icons/Research_Note.png'

import FilterToggle from '@/js/vue/components/general/FilterToggle.vue'

import { pageRefresh } from '@/js/vue/composables/BasicFunctions'
import axios from 'axios'
import { filterResearchNotes, user, buyOrder, sellOrder, tax } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication'

// FILTERS LIST
const filterPreferences = ['Crafting', 'TP'];
const filterDisciplines = ['Armorsmith', 'Artificer', 'Chef', 'Huntsman', 'Jeweler', 'Leatherworker', 'Scribe', 'Tailor', 'Weaponsmith'];
const filterItemTypes = ['Consumable', 'Weapon', 'Armor', 'Back', 'Trinket'];

const preferenceError = ref(false),
    disciplineError = ref(false),
    typeError = ref(false);

const researchNotes = ref(null);

const saveFilters = async () => {
    try {
        const response = await axios.post('../api/user/saveFilterResearchNotes', {
            filter_research_notes: filterResearchNotes.value, 
        })

        if (response){
            console.log('Saved Filter preferenes', filterResearchNotes.value)
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
    } catch (error){
        console.log('Error fetching data: ', error);
    }
}

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser(url.value);

    // IF NO USER
    if (!user.value){
        console.log('no user')
        getResearchNotes(url.value); 
    } 
    // USER FOUND
    else {
        console.log('user found')
        getResearchNotes(url.value); 
    }

})

</script>