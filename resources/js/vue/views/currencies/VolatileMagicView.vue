<template>
    <Nav/>
    <main>
        <Header page-name="Volatile Magic"/>
    
        <TwoColSection>
            <template
                v-slot:loading1
                v-if="!bags || bags == null"
            >
                <Loading :width="200" :height="200"/>
            </template>

            <template
                v-slot:table1
                v-if="bags || bags == null"
            >
                <CurrencyMainTable
                    :bags="bags"
                    :currency-icon="CurrencyIcon"
                    @details-toggle="detailsToggle = !detailsToggle"
                    @get-details="merp"
                />
            </template>

            <template
                v-slot:table2
            >
                <!-- <CurrencyDetailsTable
                    :table-toggle="detailsToggle"
                /> -->
            </template>


        </TwoColSection>

        <!-- <TwoColSection>
            <template
                v-slot:loading1
                v-if="!bags || bags == null"
            >
                <Loading :width="200" :height="200"/>
            </template>

            <template 
                v-if="bags && bags != null"
                v-slot:table1
            >
                <CurrencyMainTable
                    :bags="bags"
                    :currency-icon="CurrencyIcon" :alt="currencyName"
                    @details-toggle="detailsToggle = true"
                    @get-populate-bag-details="getPopulateBagDetails"
                />
            </template>

            <template
                v-slot:loading2
                v-if="detailsToggle && !bagContent"
            >
                <Loading :width="200" :height="200"/>
            </template>

            <template 
                v-if="detailsToggle && bagContent && bagContent != null"
                v-slot:table2
            >
                <CurrencyDetailsTable
                    :table-toggle="detailsToggle"
                    :currency-name="currencyName"
                    :currency-icon="CurrencyIcon" :alt="currencyName"
                    :bag="bag"
                    :bag-content="bagContent"
                />
            </template>
            
            
        </TwoColSection> -->

        <p>{{ detailsToggle }}</p>

        <p>Volatile Magic is a currency from and obtained mainly from LS4 maps. Shipments can be purchased at every LS4 map that has the VM symbol above their head. Istan, Sandswept, Kourna, and Dragonfall has their vendors when you spawn using their Teleport Scroll or from their main waypoint.</p>

    </main>
    
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import TwoColSection from '@/js/vue/components/general/TwoColSection.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
// Get currency icons
import CurrencyIcon from '@/imgs/icons/Volatile_Magic.png'

import CurrencyMainTable from '@/js/vue/components/tables/CurrencyMainTable.vue'
import CurrencyDetailsTable from '@/js/vue/components/tables/CurrencyDetailsTable.vue'

import { sortTable, populateMainTable, populateCurrencyDetails } from '@/js/vue/composables/TableFunctions'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'

// // Name of the currency
// const currencyName = ref('Volatile Magic');
// // Toggle for the details table
// // This gets triggered within the main table
// const detailsToggle = ref(false);
// // Initalize for main table 
// const url = `../api/currencies/volatile-magic/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`,
//     bags = ref(null);

// // Initalize for bag details table
// const bag = ref(null),
//     bagContent = ref(null),
//     sortDetails = () => sortTable('currency-details-table', 2, 'gold', 'descending');
// // Emitted from the main table
// // Set the individual bag values to a ref and populate details table
// const getPopulateBagDetails = (individualBag) => {
//     bag.value = individualBag;
//     populateCurrencyDetails(individualBag, bagContent, sortDetails); 
// }

// populateMainTable(url, bags);

// Initialize which bag to showcase + url to fetch data
const targetBag = ['Volatile Magic'];
const url = `../api/currencies/${encodeArray(targetBag)}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

// Initialize data storage
const bags = ref(null),
    dropRates = ref(null); 

// Initialize details table variables
const detailsToggle = ref(false); 

// Get bags from Currency Controller via currencies() 
const getBags = async () => {
    const response = await fetch(url); 
    const data = await response.json(); 

    bags.value = data.bag; 
    dropRates.value = data.dropRates; 

    console.log('bags: ', bags.value, 'dropRates: ', dropRates.value);
}

getBags(); 

const merp = (n) => {
    console.log('merp', n);
}

</script>

<style scoped>
</style>