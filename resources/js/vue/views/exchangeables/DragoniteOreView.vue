<template>
    <Nav/>
    <Header page-name="Dragonite Ore"/>

    <CurrencyTables
        page-name="Dragonite Ore"
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
import DragoniteOre from '@/imgs/icons/Dragonite_Ore.png'
import EmpyrealFragment from '@/imgs/icons/Empyreal_Fragment.png'

import { encodeArray } from '@/js/vue/composables/BasicFunctions'

import { getBags } from '@/js/vue/composables/TableFunctions'

import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'

const request = ['Dragonite Ore'];
const currencyIcons = [DragoniteOre, EmpyrealFragment];
const url = `../api/exchangeables/${encodeArray(request)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

console.log('url: ', url);

const bags = ref(null),
    dropRates = ref(null);

getBags(url, bags, dropRates);

</script>