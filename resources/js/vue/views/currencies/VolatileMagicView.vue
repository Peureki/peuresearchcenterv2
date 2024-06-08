<template>
    <Nav/>
    <CurrencyTables
        page-name="Volatile Magic"
        :bags="bags"
        :drop-rates="dropRates"
        :currency-icons="currencyIcons"
    />
    
</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'

// INPUT ANY CURRENCY ICONS
import VolatileMagic from '@/imgs/icons/Volatile_Magic.png'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'

import { getBags } from '@/js/vue/composables/TableFunctions'

import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'


// Initialize which bag to showcase + url to fetch data
const targetBag = ['Volatile Magic'];
const currencyIcons = [VolatileMagic];
const url = `../api/currencies/${encodeArray(targetBag)}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

// Initialize data storage
const bags = ref(null),
    dropRates = ref(null); 

getBags(url, bags, dropRates); 

</script>

<style scoped>
</style>