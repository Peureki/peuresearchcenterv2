<template>
    <section>
        <div class="two-col-section">
            <Loading 
                v-if="!bags"
                :width="200" :height="200"
            />

            <CurrencyMainTable
                v-if="bags && bags != null"
                :bags="bags"
                :currency-icons="currencyIcons"
                @details-toggle="detailsToggle = true"
                @get-details="getBagDetails"
            />

            <CurrenencyDetailsTable
                v-if="detailsToggle"
                :table-toggle="detailsToggle"
                :bag="bagDetails"
                :bags="bags[bagIndex]"
                :currency-icons="currencyIcons"
            />
        </div>
        
    </section>

</template>

<script setup>
import { ref } from 'vue'

import Header from '@/js/vue/components/general/Header.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import CurrencyMainTable from '@/js/vue/components/tables/CurrencyMainTable.vue'
import CurrenencyDetailsTable from '@/js/vue/components/tables/CurrencyDetailsTable.vue'

const props = defineProps({
    pageName: String, 
    bags: Object, 
    dropRates: Object,
    currencyIcons: Object, 
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
    gap: 10px;
}

</style>