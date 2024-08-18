<template>
    <Nav/>
    <Header :page-name="pageName"/>

    <CurrencyTables
        :page-name="pageName"
        :bags="bags"
        :drop-rates="dropRates"
        :currency-icons="currencyIcons"
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
    targetCurrencies: Object,
    currencyIcons: Object,
})

const bags = ref(null),
    dropRates = ref(null);

onMounted(() => {
    const url = `../api/exchangeables/${encodeArray(props.targetCurrencies)}/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

    console.log(url);
    getBags(url, bags, dropRates); 
})

</script>