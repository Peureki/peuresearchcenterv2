<template>
    <!-- 
        *
        * DESKTOP VIEW
        *
    -->
    <!-- <CurrencyMainTable
        v-if="bags && bags != null && !isMobile"
        :target-currency="targetCurrency"
        :bags="bags"
        :currency-icon="currencyIcon"
        @details-toggle="detailsToggle = true"
        @get-details="getBagDetails"
    /> -->

    <!-- <CurrenencyDetailsTable
        v-if="detailsToggle"
        :table-toggle="detailsToggle"
        :bag="bagDetails"
        :bags="bags[bagIndex]"
        :currency-icon="currencyIcon"
    /> -->

    <MobileCurrencyTable
        v-if="bags"
        :target-currency="targetCurrency"
        :bags="bags"
        :drop-rates="dropRates"
        :currency-icon="currencyIcon"
    />

</template>

<script setup>
import { ref } from 'vue'

import MobileCurrencyTable from '@/js/vue/components/tables/MobileCurrencyTable.vue'

import { isMobile } from '@/js/vue/composables/Global'

const props = defineProps({
    pageName: String, 
    targetCurrency: String,
    bags: Object, 
    dropRates: Object,
    currencyIcon: String, 
})

const detailsToggle = ref(false),
    bagDetails = ref(null),
    bagIndex = ref(null); 

const getBagDetails = (index) => {
    bagDetails.value = props.dropRates[index]; 
    bagIndex.value = index; 
}

</script>

<style scoped>

.two-col-section{
    display: flex;
    align-items: flex-start;
    justify-items: flex-start;
    flex-wrap: wrap;
    gap: var(--gap-content);
}

</style>