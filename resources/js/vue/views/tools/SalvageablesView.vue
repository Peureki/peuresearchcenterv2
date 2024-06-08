<template>
    <Nav/>
    <Header page-name="Salvageables"/>

    <SalvageableTables
        :salvageables="salvageables"
    />


</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue';
import Header from '@/js/vue/components/general/Header.vue'
import SalvageableTables from '@/js/vue/components/general/SalvageableTables.vue'

const url = `../api/tools/salvageables/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

const salvageables = ref(null),
    dropRates = ref(null);

const getSalvageables = async () => {
    const response = await fetch(url); 
    const data = await response.json(); 

    console.log(data); 

    salvageables.value = data.salvageables; 
    dropRates.value = data.dropRates; 
}

getSalvageables();

</script>