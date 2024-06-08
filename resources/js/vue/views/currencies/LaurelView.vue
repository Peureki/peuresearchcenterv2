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
import Laurel from '@/imgs/icons/Laurel.png'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'

import { getBags } from '@/js/vue/composables/TableFunctions'

import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'

// Initialize which bag to showcase + url to fetch data
const targetBag = ['Laurel'];
const currencyIcons = [Laurel];
const url = `../api/currencies/${encodeArray(targetBag)}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

// Initialize data storage
const bags = ref(null),
    dropRates = ref(null); 

getBags(url, bags, dropRates); 

</script>

<style scoped>
</style>