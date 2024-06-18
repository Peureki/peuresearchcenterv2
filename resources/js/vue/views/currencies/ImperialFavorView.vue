<template>
    <Nav/>
    <CurrencyTables
        page-name="Laurels"
        :bags="bags"
        :drop-rates="dropRates"
        :currency-icons="currencyIcons"
    />
</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'

// INPUT ANY CURRENCY ICONS
import ImperialFavor from '@/imgs/icons/Imperial_Favor.png'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'

import { getBags } from '@/js/vue/composables/TableFunctions'

import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'

// Initialize which bag to showcase + url to fetch data
const targetBag = ['Imperial Favor'];
const currencyIcons = [ImperialFavor];
const url = `../api/currencies/${encodeArray(targetBag)}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

console.log(url);

// Initialize data storage
const bags = ref(null),
    dropRates = ref(null); 

getBags(url, bags, dropRates); 

</script>

<style scoped>
</style>