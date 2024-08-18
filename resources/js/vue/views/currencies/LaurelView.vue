<template>
    <CurrencyPage
        :page-name="targetCurrencies[0]"
        :target-currencies="targetCurrencies"
        :currency-icons="currencyIcons"
    />
</template>

<script setup>
/* 
    * 
    * INSTRUCTIONS
    * Import desired currency icon
    * Ex: import VolatileMagic from []
    * 
    * Make variables of targetted currencies and icons
    * Ex: 
    * const targetCurrencies = ['Volatile Magic']
    * const currnecyIcons = [VolatileMagic]
    * 
    * Make as array in case there are multiple currencies for a conversion
    * 
*/

import Laurel from '@/imgs/icons/Laurel.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrencies = ['Laurel'];
const currencyIcons = [Laurel];

</script>

<style scoped>
</style>