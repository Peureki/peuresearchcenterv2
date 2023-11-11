<template>
    <Nav/>
    <main>
        <Header
            page-name="Spirit Shards"
        />
        <SpiritShardsTable
            v-if="recipes"
            table-name="FineT2"
            table-title="Fine T1 → Fine T2"
            :recipes="recipes.fineT2"
        />
        <SpiritShardsTable
            v-if="recipes"
            table-name="T3"
            table-title="Fine T2 → Fine T3"
            :recipes="recipes.fineT3"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="T4"
            table-title="Fine T3 → Fine T4"
            :recipes="recipes.fineT4"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="T5"
            table-title="Fine T4 → Fine T5"
            :recipes="recipes.fineT5"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="T6"
            table-title="Fine T5 → Fine T6"
            :recipes="recipes.fineT6"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="RareT2"
            table-title="Rare T1 → Rare T2"
            :recipes="recipes.rareT2"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="RareT3"
            table-title="Rare T2 → Rare T3"
            :recipes="recipes.rareT3"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="RareT4"
            table-title="Rare T3 → Rare T4"
            :recipes="recipes.rareT4"
        />

        <SpiritShardsTable
            v-if="recipes"
            table-name="RareT5"
            table-title="Rare T4 → Rare T5"
            :recipes="recipes.rareT5"
        />
        
        
    </main>
    
</template>

<script setup>

import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SpiritShardsTable from '@/js/vue/components/tables/SpiritShardsTable.vue'

import { fetchSpiritShards } from '@/js/vue/composables/TableFunctions.js'
import { sortTable } from '@/js/vue/composables/SortFunctions'

const recipes = ref(null);

fetchSpiritShards(recipes);

console.log(recipes);

</script>
