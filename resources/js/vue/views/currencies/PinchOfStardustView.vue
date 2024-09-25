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

import PinchOfStardust from '@/imgs/icons/Pinch_of_Stardust.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrency = 'Pinch of Stardust';
const currencyIcon = PinchOfStardust;

</script>

<style scoped>
</style>