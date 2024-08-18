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

import BanditCrest from '@/imgs/icons/Bandit_Crest.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrencies = ['Bandit Crest'];
const currencyIcons = [BanditCrest];

</script>

<style scoped>
</style>