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

import EmpyrealFragment from '@/imgs/icons/Empyreal_Fragment.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrency = 'Empyreal Fragment';
const currencyIcon = EmpyrealFragment;

</script>

<style scoped>
</style>