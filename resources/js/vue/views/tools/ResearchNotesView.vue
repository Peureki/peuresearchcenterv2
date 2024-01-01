<template>
    <Nav>
        <template v-slot:filters>
            <article>
                <h3>Filters</h3>
                <div class="filter-container">
                    <button 
                        @click="toggleFilter('filterResearchNotes', 'TP', toggles[0].status)"
                        :class="toggles[0].status.value == true ? 'active-button' : 'inactive-button'"
                    >
                        TP
                    </button>
                    <button 
                        @click="toggleFilter('filterResearchNotes', 'Crafting', toggles[1].status)"
                        :class="toggles[1].status.value == true ? 'active-button' : 'inactive-button'"
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
import { ref } from 'vue'
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import ResearchNotesTable from '@/js/vue/components/tables/ResearchNotesTable.vue'

const toggles = [
    {
        name: "TP",
        status: ref(true),
    },
    {
        name: "Crafting",
        status: ref(true),
    },
]
console.log(toggles);

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