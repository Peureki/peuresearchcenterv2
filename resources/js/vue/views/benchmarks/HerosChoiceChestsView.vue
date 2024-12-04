<template>
    <Header page-name="Hero's Choice Chests"/>
    <Nav>

    </Nav>

    <section class="main">
        <div class="content-section">
            <Loading v-if="!herosChoiceChests || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>

            <HerosChoiceChests
                v-if="herosChoiceChests"
                :chests="herosChoiceChests"
                :drop-rates="dropRates"
            />
        </div>
    </section>

    <Footer/>
</template>

<script setup>
import { onMounted, ref, computed, watch, onUnmounted } from 'vue'
import { user, sellOrder, tax, includes, refreshSettings, filters, filtersToggle } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import HerosChoiceChests from '@/js/vue/components/benchmarks/HerosChoiceChests.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import FilterRadio from '@/js/vue/components/filters/FilterRadio.vue';

const herosChoiceChests = ref(null),
    dropRates = ref(null),
    benchmarkToggle = ref(false);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

const url = computed(() => {
    return `../api/benchmarks/heros-choice-chests/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`;
})
// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getHerosChoiceChests(url.value);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getHerosChoiceChests(url.value);

    }
    filtersToggle.value = true; 
    console.log('url: ', url.value);
})
onUnmounted(() => {
    filtersToggle.value = false;
})

const getHerosChoiceChests = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    if (responseData){
        herosChoiceChests.value = responseData.chests;
        dropRates.value = responseData.dropRates;
        console.log('heros choice chests: ', responseData);
    }
}

// watch(refreshSettings, async (newSettings) => {
//     if (newSettings){
//         currentlyRefreshing.value = true; 

//         await getHerosChoiceChests(url.value);

//         currentlyRefreshing.value = false;
//         refreshSettings.value = false;
//     }
// })

// watch(filters, (newFilters) => {
//     if (newFilters){
//         console.log('new filters: ', newFilters.sortSoloBenchmarks, filters.value);
//         sortBenchmarks(herosChoiceChests.value, newFilters.sortSoloBenchmarks);
//     }
// })

</script>