<template>
    <CurrencyPage
        :page-name="targetCurrency"
        :target-currency="targetCurrency"
        :currency-icon="currencyIcon"
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
    * const targetCurrency = ['Volatile Magic']
    * const currnecyIcons = [VolatileMagic]
    * 
    * Make as array in case there are multiple currencies for a conversion
    * 
*/

import Writ from "@/imgs/icons/Writ_of_Dragon's_End.png"
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrency = "Writ of Dragon's End";
const currencyIcon = Writ;

</script>

<style scoped>
</style>