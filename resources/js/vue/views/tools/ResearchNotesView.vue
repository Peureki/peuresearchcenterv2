<template>
    <Nav>
        <template v-slot:filters>
            <article class="shortcut-container">
                <h3>Filters</h3>
                <p>Preferences</p>
                <div class="filter-container">
                    
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'TP', tpToggleRef);
                            handlePageRefresh();
                        "
                        :class="tpToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        TP
                    </button>
                    <button 
                        @click="
                            toggleFilter('filterResearchNotes', 'Crafting', craftingToggleRef);
                            handlePageRefresh();"
                        :class="craftingToggle == true ? 'active-button' : 'inactive-button'"
                    >
                        Crafting
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



const craftingToggle = ref(checkLocalStorageArray('filterResearchNotes', 'Crafting')),
    tpToggle = ref(checkLocalStorageArray('filterResearchNotes', 'TP'));

const craftingToggleRef = computed(() => craftingToggle),
    tpToggleRef = computed(() => tpToggle);

const router = useRouter(),
    route = useRoute();

const handlePageRefresh = () => {
    pageRefresh(router, route); 
}

const toggleFilter = (localStorageProperty, filter, toggle) => {
    let filteredArray = []; 

    toggle.value = !toggle.value;

    switch (localStorageProperty){
        case 'filterResearchNotes': 
            filteredArray = JSON.parse(localStorage.getItem('filterResearchNotes'));

            const index = filteredArray.indexOf(filter); 
            if (index !== -1){
                filteredArray.splice(index, 1); 
            } else {
                filteredArray.push(filter); 
            }
            localStorage.setItem('filterResearchNotes', JSON.stringify(filteredArray));
            break;
    }
}   



</script>