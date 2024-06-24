<template>
    <Nav/>
    <Header page-name="Unbound Magic"/>
    <CurrencyTables
        page-name="Unbound Magic"
        :bags="bags"
        :drop-rates="dropRates"
        :currency-icons="currencyIcons"
    />
    
</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'


// INPUT ANY CURRENCY ICONS
import UnboundMagic from '@/imgs/icons/Unbound_Magic.png'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'

import { getBags } from '@/js/vue/composables/TableFunctions'

import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'

// Initialize which bag to showcase + url to fetch data
const targetBag = ['Unbound Magic'];
const currencyIcons = [UnboundMagic];
const url = `../api/currencies/${encodeArray(targetBag)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

// Initialize data storage
const bags = ref(null),
    dropRates = ref(null); 

getBags(url, bags, dropRates); 

</script>

<style scoped>
</style>