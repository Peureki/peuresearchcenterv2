<template>
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
                <div class="filter-container">
                    <button
                        v-for="(toggle, index) in preferenceToggles" 
                        @click="
                            toggleFilter('filterResearchNotes', index, preferenceToggles, preferenceErrorRef)
                        "
                        :class="toggle.status.value == true ? 'active-button' : 'inactive-button'"
                    >
                        {{ toggle.name }}
                    </button>
                </div>
                <Transition name="fade"><p v-if="preferenceError" class="error-message">Needs 1+ active</p></Transition>

                <!-- 
                    *
                    * DISCIPLINE FILTERS
                    *
                -->
                <p>Disciplines</p>
                <div class="filter-container">
                    <button
                        v-for="(toggle, index) in disciplineToggles" 
                        @click="
                            toggleFilter('filterResearchNotes', index, disciplineToggles, disciplineErrorRef)
                        "
                        :class="toggle.status.value == true ? 'active-button' : 'inactive-button'"
                    >
                        {{ toggle.name }}
                    </button>
                </div>
                <Transition name="fade"><p v-if="disciplineError" class="error-message">Needs 1+ active</p></Transition>

                <!-- 
                    *
                    * ITEM TYPES
                    *
                -->
                <p>Item Types</p>
                <div class="filter-container">
                    <button
                        v-for="(toggle, index) in typeToggles" 
                        @click="
                            toggleFilter('filterResearchNotes', index, typeToggles, typeErrorRef)
                        "
                        :class="toggle.status.value == true ? 'active-button' : 'inactive-button'"
                    >
                        {{ toggle.name }}
                    </button>
                </div>
                <Transition name="fade"><p v-if="typeError" class="error-message">Needs 1+ active</p></Transition>

                <p>Set new filters</p>
                <div class="filter-container">
                    
                    <button 
                        @click="handlePageRefresh"
                    >
                        Refresh
                    </button>

                </div>
            </article>
        </template>
    </Nav>

    <main>
        <Header page-name="Research Notes"/>

        

        <ResearchNotesTable/>
    </main>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import ResearchNotesTable from '@/js/vue/components/tables/ResearchNotesTable.vue'

import { checkLocalStorageArray } from '@/js/vue/composables/FormatFunctions.js'
import { pageRefresh } from '@/js/vue/composables/BasicFunctions'

// *
// * PREFERENCE TOGGLES
// *
const preferenceToggles = [
    {
        name: "Crafting",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Crafting')),
    },
    {
        name: "TP",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'TP')),
    }
]
// *
// * DISCIPLINE TOGGLES
// *
const disciplineToggles = [
    {
        name: "Armorsmith",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Armorsmith')),
    },
    {
        name: "Artificer",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Artificer')),
    },
    {
        name: "Chef",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Chef')),
    },
    {
        name: "Huntsman",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Huntsman')),
    },
    {
        name: "Jeweler",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Jeweler')),
    },
    {
        name: "Leatherworker",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Leatherworker')),
    },
    {
        name: "Scribe",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Scribe')),
    },
    {
        name: "Tailor",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Tailor')),
    },
    {
        name: "Weaponsmith",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Weaponsmith')),
    }
]
// *
// * TYPE TOGGLES
// *
const typeToggles = [
    {
        name: "Consumable",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Consumable')),
    },
    {
        name: "Weapon",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Weapon')),
    },
    {
        name: "Armor",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Armor')),
    },
    {
        name: "Back",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Back')),
    },
    {
        name: "Trinket",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'Trinket')),
    },
    {
        name: "UpgradeComponent",
        status: ref(checkLocalStorageArray('filterResearchNotes', 'UpgradeComponent')),
    },
]

const preferenceError = ref(false),
    disciplineError = ref(false),
    typeError = ref(false);

const preferenceErrorRef = computed(() => preferenceError),
    disciplineErrorRef = computed(() => disciplineError),
    typeErrorRef = computed(() => typeError);

// Initialize toggles and computed refs 
// Computed refs will be used to dynamically toggle the filter if users opt in or out
const 

    //  *
    //  * TYPES
    //  *
    consumableToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Consumable')),
    weaponToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Weapon'));

//  *
//  * COMPUTED TOGGLES
//  *
//  * Keep the ref of the toggles and use them for toggleFilter() when toggling a filter
const 
    //  *
    //  * TYPE
    //  *
    consumableToggleRef = computed(() => consumableToggle),
    weaponToggleRef = computed(() => weaponToggle);

// *
// * Go through array of toggles and check on their statuses
// * 
// * Determine if they are all false or not
// * If all false => show error message temporarily and keep selected filter on so that there's always at least 1
const checkToggleStatus = (array, index, refError) => {
    let allFalse = true;
    array.forEach((toggle) => {
        if (toggle.status.value){
            allFalse = false; 
        } 
    })
    if (allFalse){
        array[index].status.value = true; 
        refError.value = true; 
    }
}


const router = useRouter(),
    route = useRoute();

const handlePageRefresh = () => {
    pageRefresh(router, route); 
}
// * 
// * TOGGLE FILTERS
// * 
// * Check localStorage if property includes filter 
// * 1. Check if all other filters are not active
// * 2. Include or delete filter in localStorage
const toggleFilter = (localStorageProperty, arrayIndex, array, refError) => {
    let filteredArray = [],
        lastActive = false,
        allFalse = true; 

    // Check all other filters in said category except for the current one that was clicked on
    // If any other filters in that category is still active, allFalse is false
    array.forEach((toggle, index) => {
        if (index != arrayIndex){
            if (toggle.status.value){
                allFalse = false;
            }
        }
        
    });
    // If all other filters in category are false => keep current filter active and display error message to user
    if (allFalse){
        array[arrayIndex].status.value = true;
        refError.value = true; 
        // Remove error message after 1s
        setTimeout(() => {
            refError.value = false;
        }, 1000)
    // Otherwise change status of filter 
    } else {
        array[arrayIndex].status.value = !array[arrayIndex].status.value;
        refError.value = false; 
    }
    // Based on what localStorageProperty is being called on => add or remove filters
    switch (localStorageProperty){
        case 'filterResearchNotes': 
            // If there's a filter in category that is still active besides the current one, do this
            if (!allFalse){
                filteredArray = JSON.parse(localStorage.getItem('filterResearchNotes'));
                // Check if property array contains the target string/filter
                // If yes => remove
                // If no => add
                const i = filteredArray.indexOf(array[arrayIndex].name); 
                if (i !== -1){
                    filteredArray.splice(i, 1); 
                } else {
                    filteredArray.push(array[arrayIndex].name); 
                }
                localStorage.setItem('filterResearchNotes', JSON.stringify(filteredArray));
            }
            
            break;
    }
}   



</script>