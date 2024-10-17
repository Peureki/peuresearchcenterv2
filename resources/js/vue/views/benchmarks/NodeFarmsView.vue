<template>
    <Nav/>
    <Header page-name="Node Farms"/>

    
    

    <section class="main">
        <div class="content-section">
            <NodeFarmBenchmarks
                v-if="estNodeToggle"
                :benchmarks="estNodeBenchmarks"
                :combinations="estNodeCombinations"
                @get-new-node-benchmark-url="getEstNodeBenchmarks"
            />
        </div>
    </section>

    <section>
        <div class="content-section">
            <Disclaimer message="These are estimated benchmarks. They include Unbound Magic, Volatility Magic for farms that include their respective glyphs. Default settings also include sell_price for Sell Orders and 15% TP tax. There's over 10k benchmarks and this makes it much easier to calculate in bulk rather than to everyone's individual settings."/>
        </div>  
    </section>

    <Loading v-if="!estNodeBenchmarks || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>
    <Footer/>
</template>

<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import { user, sellOrder, tax, includes, refreshSettings } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import NodeFarmBenchmarks from '@/js/vue/components/benchmarks/NodeFarmBenchmarks.vue';
import Loading from '@/js/vue/components/general/Loading.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

const mapBenchmarks = ref([]),
    estNodeBenchmarks = ref(null),
    combinations = ref([]),
    estNodeCombinations = ref([]),
    benchmarkToggle = ref(false),
    estNodeToggle = ref(false);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

// Distinquish what type of farm to return in this page
const filter = ['Node'];

// ESTIMATED farms
const estURL = computed(() => {
    return `../api/benchmarks/node-farms/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getEstNodeBenchmarks(estURL.value);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getEstNodeBenchmarks(estURL.value);
    }
    console.log('estimated url: ', estURL.value);
})
// Update the progress of loading the data 
window.Echo.channel('progress')
    .listen('LoadingProgress', (e) => {
        currentProgress.value = e.progress; 
        //console.log('Loading Progress: ', e.progress);
    })

const getEstNodeBenchmarks = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    if (responseData){
        estNodeBenchmarks.value = responseData.benchmarks;
        estNodeCombinations.value = responseData.combinations; 

        estNodeToggle.value = true; 
        
        console.log('est benchmarks: ', estNodeBenchmarks.value, 'combinations: ', estNodeCombinations.value);

        currentlyRefreshing.value = false;
        //sortBenchmarks(mapBenchmarks.value); 
    }
}

watch(refreshSettings, async (newSettings) => {
    if (newSettings){
        currentlyRefreshing.value = true; 

        await getEstNodeBenchmarks(estURL.value);

        currentlyRefreshing.value = false;
        refreshSettings.value = false;
    }
})

</script>