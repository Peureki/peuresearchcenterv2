<template>
    <Nav/>
    <main>
        <Header
            page-name="Spirit Shards"
        />
        <SpiritShardsFineTable
            v-if="recipes"
            table-name="T2"
            :recipes="recipes.fineT2"
        />
        <SpiritShardsFineTable
            v-if="recipes"
            table-name="T3"
            :recipes="recipes.fineT3"
        />

        <SpiritShardsFineTable
            v-if="recipes"
            table-name="T4"
            :recipes="recipes.fineT4"
        />

        <SpiritShardsFineTable
            v-if="recipes"
            table-name="T5"
            :recipes="recipes.fineT5"
        />

        <SpiritShardsFineTable
            v-if="recipes"
            table-name="T6"
            :recipes="recipes.fineT6"
        />
        
        
    </main>
    
</template>

<script setup>

import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SpiritShardsFineTable from '@/js/vue/components/tables/SpiritShardsFineTable.vue'

import { fetchSpiritShards } from '@/js/vue/composables/TableFunctions.js'
import { sortTable } from '@/js/vue/composables/SortFunctions'

const recipes = ref(null);

fetchSpiritShards(recipes);

console.log(recipes);

</script>
