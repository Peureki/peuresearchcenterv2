<template>
    <Nav/>
    <Header :page-name="pageName"/>

    <CurrencyTables
        v-if="bags"
        :page-name="pageName"
        :bags="bags"
        :drop-rates="dropRates"
        :currency-icon="currencyIcon"
    />
</template>

<script setup>
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'

import { ref, onMounted } from 'vue';
import { encodeArray } from '@/js/vue/composables/BasicFunctions'
import { getBags } from '@/js/vue/composables/TableFunctions'

const props = defineProps({
    pageName: String, 
    targetCurrency: String,
    currencyIcon: String,
})

const bags = ref(null),
    dropRates = ref(null);

const url = `../api/exchangeables/${encodeURIComponent(props.targetCurrency)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

console.log(url);
getBags(url, bags, dropRates); 

onMounted(() => {
    
})

</script>