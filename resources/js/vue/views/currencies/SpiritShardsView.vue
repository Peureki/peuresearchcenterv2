<template>
    <Nav>
        <template v-slot:bookmarks>
            <article>
                <h3>Bookmarks</h3>
                <div class="bookmark-container">
                    <a 
                        v-for="table in tables"
                        class="bookmark"
                        :href="`#${table.name}`"
                    >
                        <span class="bookmark-label">
                            <img :src="table.checkboxSrc" :alt="table.checkboxAlt" :title="table.checkboxTitle">
                            <div class="checkbox">
                                <input
                                    type="checkbox"
                                    :name="table.name"
                                    :checked="table.checkboxToggle.value"
                                    @click="showTableToggle(table.name, table.checkboxToggle)"
                                >
                                <label>{{ table.title }}</label>
                            </div>
                        </span>
                    </a>
                </div>
            </article>
        </template>

    </Nav>
    <main>
        <Header
            page-name="Spirit Shards"
        />
        <section v-for="table in tables">
            <article v-if="table.recipes && table.recipes.value != null && table.checkboxToggle.value">
                <SpiritShardsTable
                    :table-name="table.name"
                    :table-title="table.title"
                    :recipes="table.recipes"
                />
            </article>
            
        </section>
    </main>
    
</template>

<script setup>

import { ref, onMounted } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SpiritShardsTable from '@/js/vue/components/tables/SpiritShardsTable.vue'

import { sortTable, fetchSpiritShards } from '@/js/vue/composables/TableFunctions.js'

// PICTURES
// FINE T2->T6
import VialofThinBlood from '@/imgs/icons/Vial_of_Thin_Blood.png'
import VialofBlood from '@/imgs/icons/Vial_of_Blood.png'
import VialofThickBlood from '@/imgs/icons/Vial_of_Thick_Blood.png'
import VialofPotentBlood from '@/imgs/icons/Vial_of_Potent_Blood.png'
import VialofPowerfulBlood from '@/imgs/icons/Vial_of_Powerful_Blood.png'
// RARE T2->T5
import ChargedSliver from '@/imgs/icons/Charged_Sliver.png'
import ChargedShard from '@/imgs/icons/Charged_Shard.png'
import ChargedCore from '@/imgs/icons/Charged_Core.png'
import ChargedLodestone from '@/imgs/icons/Charged_Lodestone.png'

const showTableToggle = (tableName, checkboxToggle) => {
    checkboxToggle.value = !checkboxToggle.value;
    switch (tableName){
        case "FineT2": 
            localStorage.setItem('spiritShardsFineT2Table', checkboxToggle.value);
            break;
        case "FineT3": 
            localStorage.setItem('spiritShardsFineT3Table', checkboxToggle.value);
            break;
        case "FineT4": 
            localStorage.setItem('spiritShardsFineT4Table', checkboxToggle.value);
            break;
        case "FineT5": 
            localStorage.setItem('spiritShardsFineT5Table', checkboxToggle.value);
            break;
        case "FineT6": 
            localStorage.setItem('spiritShardsFineT6Table', checkboxToggle.value);
            break;
        case "RareT2": 
            localStorage.setItem('spiritShardsRareT2Table', checkboxToggle.value);
            break;
        case "RareT3": 
            localStorage.setItem('spiritShardsRareT3Table', checkboxToggle.value);
            break;
        case "RareT4": 
            localStorage.setItem('spiritShardsRareT4Table', checkboxToggle.value);
            break;
        case "RareT5": 
            localStorage.setItem('spiritShardsRareT5Table', checkboxToggle.value);
            break;
    }
}
const tables = [
    {
        name: "FineT2",
        title: "Fine T2",
        recipes: ref(null),
        checkboxSrc: VialofThinBlood,
        checkboxAlt: "Vial of Thin Blood",
        checkboxTitle: "Jump to Fine T2 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsFineT2Table)), 
    },
    {
        name: "FineT3",
        title: "Fine T3",
        recipes: ref(null),
        checkboxSrc: VialofBlood,
        checkboxAlt: "Vial of Blood",
        checkboxTitle: "Jump to Fine T3 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsFineT3Table)), 
    },
    {
        name: "FineT4",
        title: "Fine T4",
        recipes: ref(null),
        checkboxSrc: VialofThickBlood,
        checkboxAlt: "Vial of Thick Blood",
        checkboxTitle: "Jump to Fine T4 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsFineT4Table)), 
    },
    {
        name: "FineT5",
        title: "Fine T5",
        recipes: ref(null),
        checkboxSrc: VialofPotentBlood,
        checkboxAlt: "Vial of Potent Blood",
        checkboxTitle: "Jump to Fine T5 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsFineT5Table)), 
    },
    {
        name: "FineT6",
        title: "Fine T6",
        recipes: ref(null),
        checkboxSrc: VialofPowerfulBlood,
        checkboxAlt: "Vial of Powerful Blood",
        checkboxTitle: "Jump to Fine T6 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsFineT6Table)), 
    },
    {
        name: "RareT2",
        title: "Rare T2",
        recipes: ref(null),
        checkboxSrc: ChargedSliver,
        checkboxAlt: "Charged Sliver",
        checkboxTitle: "Jump to Rare T2 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsRareT2Table)), 
    },
    {
        name: "RareT3",
        title: "Rare T3",
        recipes: ref(null),
        checkboxSrc: ChargedShard,
        checkboxAlt: "Charged Shared",
        checkboxTitle: "Jump to Rare T3 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsRareT3Table)), 
    },
    {
        name: "RareT4",
        title: "Rare T4",
        recipes: ref(null),
        checkboxSrc: ChargedCore,
        checkboxAlt: "Charged Core",
        checkboxTitle: "Jump to Rare T4 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsRareT4Table)), 
    },
    {
        name: "RareT5",
        title: "Rare T5",
        recipes: ref(null),
        checkboxSrc: ChargedLodestone,
        checkboxAlt: "Charged Lodestone",
        checkboxTitle: "Jump to Rare T5 table",
        checkboxToggle: ref(JSON.parse(localStorage.spiritShardsRareT5Table)), 
    },
]
fetchSpiritShards(tables);

</script>
