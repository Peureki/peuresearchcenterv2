<template>
    <Nav/>
    <main>
        <Header :page-name="currencyName"/>
    
        <TwoColSection>
            <template v-slot:table1>
                <CurrencyMainTable
                    :bags="bags"
                    :currency-icon="CurrencyIcon" alt="Volatile Magic"
                    @details-toggle="detailsToggle = true"
                    @get-populate-bag-details="getPopulateBagDetails"
                />
            </template>

            <template v-slot:table2>
                <CurrencyDetailsTable
                    :table-toggle="detailsToggle"
                    :currency-name="currencyName"
                    :currency-icon="CurrencyIcon" alt="Volatile Magic"
                    :bag="bag"
                    :bag-content="bagContent"
                />
            </template>
        </TwoColSection>

        
        <p>Volatile Magic is a currency from and obtained mainly from LS4 maps. Shipments can be purchased at every LS4 map that has the VM symbol above their head. Istan, Sandswept, Kourna, and Dragonfall has their vendors when you spawn using their Teleport Scroll or from their main waypoint.</p>
    </main>
    
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'
// Get currency icons
import CurrencyIcon from '@/imgs/icons/Volatile_Magic.png'

import CurrencyMainTable from '@/js/vue/components/tables/CurrencyMainTable.vue'
import CurrencyDetailsTable from '@/js/vue/components/tables/CurrencyDetailsTable.vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable } from '@/js/vue/composables/SortFunctions.js'

import { populateMainTable, populateCurrencyDetails } from '@/js/vue/composables/TableFunctions'

// Name of the currency
const currencyName = ref('Volatile Magic');
// Toggle for the details table
// This gets triggered within the main table
const detailsToggle = ref(false);

// Initalize for main table 
const url = `../api/currencies/volatile-magic/${localStorage.priceSetting}/${localStorage.taxSetting}`,
    bags = ref(null),
    sortFunction = () => sortTable('currency-table', 2, 'gold');

// Initalize for bag details table
const bag = ref(null),
    bagContent = ref(null),
    sortDetails = () => sortTable('currency-details-table', 2, 'gold');
// Emitted from the main table
// Set the individual bag values to a ref and populate details table
const getPopulateBagDetails = (individualBag) => {
    bag.value = individualBag;
    populateCurrencyDetails(individualBag, bagContent, sortDetails); 
}

onMounted(() => {
    populateMainTable(url, bags, sortFunction);
})

</script>

<style scoped>
</style>