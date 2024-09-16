<template>
    <Nav/>
    <Header :page-name="pageName"/>

    <section class="main">
        <div class="content-section">
            <Loading v-if="!bags" :width="200" :height="200" />

            <CurrencyTables
                v-if="bags"
                :page-name="pageName"
                :bags="bags"
                :drop-rates="dropRates"
                :currency-icon="currencyIcon"
            />
        </div>
    </section>
    
</template>

<script setup>
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import CurrencyTables from '@/js/vue/components/general/CurrencyTables.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import { ref, onMounted, watch, computed } from 'vue';
import { encodeArray } from '@/js/vue/composables/BasicFunctions'
import { getBags } from '@/js/vue/composables/TableFunctions'
import { user, sellOrder, tax, includes } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';

const props = defineProps({
    pageName: String, 
    targetCurrency: String,
    currencyIcon: String,
})

const bags = ref(null),
    dropRates = ref(null);


const url = computed(() => {
    return `../api/exchangeables/${encodeURIComponent(props.targetCurrency)}/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`;
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();

    // IF NO USER
    if (!user.value){
        console.log('no user')
        getBags(url.value, bags, dropRates); 
    } 
    // USER FOUND
    else {
        console.log('user found')
        getBags(url.value, bags, dropRates); 
    }
})

// AUTH PROCESS
// After auth, fetch bags with new parameters
// watch(url, (newURL) => {
//     if (newURL){
//         console.log('watch happens');
//         getBags(url.value, bags, dropRates); 
//     }
// })

</script>