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

import Currency from '@/imgs/icons/Curious_Mursaat_Currency.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrency = 'Curious Mursaat Currency';
const currencyIcon = Currency;

</script>

<style scoped>
</style>