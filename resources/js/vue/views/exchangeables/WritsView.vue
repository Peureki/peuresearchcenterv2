<template>
    <Nav/>
    <Header page-name="Writs"/>

    <CurrencyTables
        :target-currency="seitungTarget"
        :bags="seitungBags"
        :drop-rates="seitungDropRates"
        :currency-icon="seitungIcon"
    />

    <CurrencyTables
        :target-currency="newKainengTarget"
        :bags="newKainengBags"
        :drop-rates="newKainengDropRates"
        :currency-icon="newKainengIcon"
    />

    <CurrencyTables
        :target-currency="echovaldTarget"
        :bags="echovaldBags"
        :drop-rates="echovaldDropRates"
        :currency-icon="echovaldIcon"
    />

    <CurrencyTables
        :target-currency="dragonsEndTarget"
        :bags="dragonsEndBags"
        :drop-rates="dragonsEndDropRates"
        :currency-icon="dragonsEndIcon"
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
import WritofSeitungProvince from '@/imgs/icons/Writ_of_Seitung_Province.png'
import WritOfNewKainengCity from '@/imgs/icons/Writ_of_New_Kaineng_City.png'
import WritofEchovaldWilds from '@/imgs/icons/Writ_of_Echovald_Wilds.png'
import WritsofDragonsEnd from "@/imgs/icons/Writ_of_Dragon's_End.png"

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'
import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'

import { ref, onMounted } from 'vue'
import { getBags } from '@/js/vue/composables/TableFunctions'

const seitungTarget = "Writ of Seitung Province",
    seitungIcon = WritofSeitungProvince,
    seitungBags = ref(null),
    seitungDropRates = ref(null),
    seitungURL = `../api/exchangeables/${encodeURIComponent(seitungTarget)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

const newKainengTarget = "Writ of New Kaineng City",
    newKainengIcon = WritOfNewKainengCity,
    newKainengBags = ref(null),
    newKainengDropRates = ref(null),
    newKainengURL = `../api/exchangeables/${encodeURIComponent(newKainengTarget)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

const echovaldTarget = "Writ of Echovald Wilds",
    echovaldIcon = WritofEchovaldWilds,
    echovaldBags = ref(null),
    echovaldDropRates = ref(null),
    echovaldURL = `../api/exchangeables/${encodeURIComponent(echovaldTarget)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

const dragonsEndTarget = "Writ of Dragon's End",
    dragonsEndIcon = WritsofDragonsEnd,
    dragonsEndBags = ref(null),
    dragonsEndDropRates = ref(null),
    dragonsEndURL = `../api/exchangeables/${encodeURIComponent(dragonsEndTarget)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

onMounted(() => {
    getBags(seitungURL, seitungBags, seitungDropRates);
    getBags(newKainengURL, newKainengBags, newKainengDropRates);
    getBags(echovaldURL, echovaldBags, echovaldDropRates);
    getBags(dragonsEndURL, dragonsEndBags, dragonsEndDropRates);
})

</script>

<style scoped>
</style>