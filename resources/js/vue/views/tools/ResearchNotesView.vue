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
                <Transition name="fade"><p v-if="preferenceError" class="error-message">Needs 1+ active</p></Transition>
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

                <!-- 
                    *
                    * DISCIPLINE FILTERS
                    *
                -->
                <p>Disciplines</p>
                <div class="filter-container">
                    
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Armorsmith', armorsmithToggleRef);"
                        :class="armorsmithToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Armorsmith
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Artificer', artificerToggleRef);"
                        :class="artificerToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Artificer
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Chef', chefToggleRef);"
                        :class="chefToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Chef
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Huntsman', huntsmanToggleRef);"
                        :class="huntsmanToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Huntsman
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Jeweler', jewelerToggleRef);"
                        :class="jewelerToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Jeweler
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Leatherworker', leatherworkerToggleRef);"
                        :class="leatherworkerToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Leatherworker
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Scribe', scribeToggleRef);"
                        :class="scribeToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Scribe
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Tailor', tailorToggleRef);"
                        :class="tailorToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Tailor
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Weaponsmith', weaponsmithToggleRef);"
                        :class="weaponsmithToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Weaponsmith
                    </button>
                </div>

                <!-- 
                    *
                    * ITEM TYPES
                    *
                -->
                <p>Item Types</p>
                <div class="filter-container">
                    
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Consumable', consumableToggleRef);"
                        :class="consumableToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Consumables
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Weapon', weaponToggleRef);"
                        :class="weaponToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Weapons
                    </button>

                </div>

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

const preferenceError = ref(false);

const preferenceErrorRef = computed(() => preferenceError);

console.log('pref toggles: ', preferenceToggles);

// Initialize toggles and computed refs 
// Computed refs will be used to dynamically toggle the filter if users opt in or out
const craftingToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Crafting')),
    tpToggle = ref(checkLocalStorageArray('filterResearchNotes', 'TP')),
    //  *
    //  * DISCIPLINES
    //  *
    armorsmithToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Armorsmith')),
    artificerToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Artificer')),
    chefToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Chef')),
    huntsmanToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Huntsman')),
    jewelerToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Jeweler')),
    leatherworkerToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Leatherworker')),
    scribeToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Scribe')),
    tailorToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Tailor')),
    weaponsmithToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Weaponsmith')),
    //  *
    //  * TYPES
    //  *
    consumableToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Consumable')),
    weaponToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Weapon'));

//  *
//  * COMPUTED TOGGLES
//  *
//  * Keep the ref of the toggles and use them for toggleFilter() when toggling a filter
const craftingToggleRef = computed(() => craftingToggle),
    tpToggleRef = computed(() => tpToggle),
    //  *
    //  * DISCIPLINES
    //  *
    armorsmithToggleRef = computed(() => armorsmithToggle),
    artificerToggleRef = computed(() => artificerToggle),
    chefToggleRef = computed(() => chefToggle),
    huntsmanToggleRef = computed(() => huntsmanToggle),
    jewelerToggleRef = computed(() => jewelerToggle),
    leatherworkerToggleRef = computed(() => leatherworkerToggle),
    scribeToggleRef = computed(() => scribeToggle),
    tailorToggleRef = computed(() => tailorToggle),
    weaponsmithToggleRef = computed(() => weaponsmithToggle),
    //  *
    //  * TYPE
    //  *
    consumableToggleRef = computed(() => consumableToggle),
    weaponToggleRef = computed(() => weaponToggle);



const checkArrayIfAllFalse = (array) => {
    return array.every(element => false);
}
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

const toggleFilter = (localStorageProperty, index, array, refError) => {
    let filteredArray = [],
        allFalse = true; 

    array.forEach((toggle) => {
        if (toggle.status.value){
            allFalse = false;
        }
    });

    if (allFalse){
        array[index].status.value = true;
        refError.value = true; 
    } else {
        array[index].status.value = !array[index].status.value;
        refError.value = false; 
    }

    switch (localStorageProperty){
        case 'filterResearchNotes': 
            if (!allFalse){
                filteredArray = JSON.parse(localStorage.getItem('filterResearchNotes'));

                const i = filteredArray.indexOf(array[index].name); 
                if (i !== -1){
                    filteredArray.splice(i, 1); 
                } else {
                    filteredArray.push(array[index].name); 
                }
                localStorage.setItem('filterResearchNotes', JSON.stringify(filteredArray));
            }
            
            break;
    }
}   



</script>