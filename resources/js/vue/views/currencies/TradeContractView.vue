<template>
    <Nav/>
    <main>
        <Header page-name="Trade Contracts"/>
    
        <TwoColSection>
            <template
                v-slot:loading1
                v-if="!bags || bags == null"
            >
                <Loading :width="200" :height="200"/>
            </template>

            <template
                v-slot:table1
                v-if="bags"
            >
                <CurrencyMainTable
                    :bags="bags"
                    :currency-icon="CurrencyIcon"
                    @details-toggle="detailsToggle = true"
                    @get-details="getBagDetails"
                />
            </template>

            <template
                v-slot:table2
                v-if="detailsToggle"
            >
                <CurrencyDetailsTable
                    :table-toggle="detailsToggle"
                    :bag="bagDetails"
                    :bags="bags[bagIndex]"
                    :currency-icon="CurrencyIcon"
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
import Loading from '@/js/vue/components/general/Loading.vue'
// Get currency icons
import CurrencyIcon from '@/imgs/icons/Trade_Contract.png'
import OtherCurrencyIcon from '@/imgs/icons/Karma.png'

import CurrencyMainTable from '@/js/vue/components/tables/CurrencyMainTable.vue'
import CurrencyDetailsTable from '@/js/vue/components/tables/CurrencyDetailsTable.vue'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'


// Initialize which bag to showcase + url to fetch data
const targetBag = ['Trade Contract,Karma'];
const url = `../api/currencies/${encodeArray(targetBag)}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

console.log('encoded: ', encodeArray(targetBag));

// Initialize data storage
const bags = ref(null),
    dropRates = ref(null); 

// Initialize details table variables
const detailsToggle = ref(false),
    bagDetails = ref(null),
    bagIndex = ref(null); 

// Get bags from Currency Controller via currencies() 
const getBags = async () => {
    const response = await fetch(url); 
    const data = await response.json(); 

    bags.value = data.bag; 
    dropRates.value = data.dropRates; 

    console.log(bags.value, dropRates.value);
}
// Emitted from clicking on one of the bags
// Returned index of the bag from the index of response.json() 
// Use that same index of bags.value for dropRates.value to get respective drops 
const getBagDetails = (index) => {
    bagDetails.value = dropRates.value[index]; 
    bagIndex.value = index; 
}

getBags(); 

</script>

<style scoped>
</style>