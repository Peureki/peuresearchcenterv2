<template>
    <Nav/>
    <Header page-name="Salvageables"/>

    <GeneralTable
        title="Mixed Salvage"
        :table-headers="tableHeaders"
        :data="mixedSalvageables"
    />

    <SalvageableTables
        :salvageables="salvageables"
    />

    

    


</template>

<script setup>
import { ref } from 'vue'

import Nav from '@/js/vue/components/general/Nav.vue';
import Header from '@/js/vue/components/general/Header.vue'
import GeneralTable from '@/js/vue/components/general/GeneralTable.vue';
import SalvageableTables from '@/js/vue/components/tables/SalvageableTables.vue'
import { user, tax, sellOrder, buyOrder } from '@/js/vue/composables/Global'

const salvageableURL = `../api/tools/salvageables/${sellOrder.value}/${tax.value}`;

const mixedSalvageableURL = `../api/tools/mixed-salvageables/${sellOrder.value}/${tax.value}`;

const salvageables = ref(null),
    mixedSalvageables = ref(null),
    salvageableDropRates = ref(null),
    mixedSalvageableDropRates = ref(null);

// For <GeneralTable/>
const tableHeaders = ["Name", "Profit"];

const getSalvageables = async () => {
    const response = await fetch(salvageableURL); 
    const data = await response.json(); 

    console.log(data); 

    salvageables.value = data.salvageables; 
    salvageableDropRates.value = data.salvageableDropRates; 
}

const getMixedSalvageables = async () => {
    const response = await fetch(mixedSalvageableURL);
    const data = await response.json(); 

    console.log('mixed: ', data);
    mixedSalvageables.value = data.salvageables; 
    mixedSalvageableDropRates.value = data.dropRates; 
}

getSalvageables();
getMixedSalvageables();

</script>