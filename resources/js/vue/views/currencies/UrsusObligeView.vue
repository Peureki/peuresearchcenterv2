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
    * const currnecyIcon = [VolatileMagic]
    * 
    * Make as array in case there are multiple currencies for a conversion
    * 
*/

import Currency from '@/imgs/icons/Ursus_Oblige.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrency = 'Ursus Oblige';
const currencyIcon = Currency;

</script>

<style scoped>
</style>