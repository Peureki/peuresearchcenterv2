<template>
    <Nav/>
    <main>
        <Header
            page-name="Spirit Shards"
        />

        <div v-for="recipe in recipes">
            <SpiritShardsFineTable
                table-name="T2"
                :recipe="recipe"
            />
            
        </div>
        
    </main>
    
</template>

<script setup>

import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SpiritShardsFineTable from '@/js/vue/components/tables/SpiritShardsFineTable.vue'

import { fetchSpiritShards } from '@/js/vue/composables/TableFunctions.js'

const recipes = ref(null); 

fetchSpiritShards(recipes);

</script>
