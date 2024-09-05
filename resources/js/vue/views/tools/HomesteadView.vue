<template>
    <Nav/>
    <Header page-name="Homesteads"/>

    <section>
        <RefinementTable
            target-refinement="Refined Homestead Wood"
            target-id="103049"
        />
    </section>

    <section>
        <RefinementTable
            target-refinement="Refined Homestead Metal"
            target-id="102205"
        />
    </section>

    <section>
        <RefinementTable
            target-refinement="Refined Homestead Fiber"
            target-id="102306"
        />
    </section>

        
    

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

import RefinementTable from '@/js/vue/components/tables/RefinementTable.vue';

</script>

<style scoped>
</style>