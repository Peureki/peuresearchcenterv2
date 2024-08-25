<template>
    <Nav/>
    <Header page-name="Homesteads"/>

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
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import WritOfNewKainengCity from '@/imgs/icons/Writ_of_New_Kaineng_City.png'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

const targetCurrency = 'Writ of New Kaineng City';
const currencyIcon = WritOfNewKainengCity;

</script>

<style scoped>
</style>