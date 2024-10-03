<template>
    <Nav/>
    <Header page-name="Map Benchmarks"/>

    <section class="main">
        <Loading v-if="!benchmarkToggle || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>
        <Benchmark
            v-if="benchmarkToggle"
            :benchmarks="mapBenchmarks"
            :drop-rates="dropRates"
        />
    </section>

    <Footer/>
</template>

<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import { user, sellOrder, tax, includes, refreshSettings } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';

import Echo from 'laravel-echo';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import Benchmark from '@/js/vue/components/general/Benchmark.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

const mapBenchmarks = ref([]),
    dropRates = ref([]),
    benchmarkToggle = ref(false);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

const sortBenchmarks = (benchmarks) => {
    if (benchmarks){
        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);


        // Sort the indexes based on the estimatedValue
        indexes.sort((a, b) => benchmarks[b].gph - benchmarks[a].gph);

        // Use the sorted indexes to sort benchmarks and dropRates
        const sortedBenchmarks = indexes.map(index => benchmarks[index]);
        const sortedDropRates = indexes.map(index => dropRates.value[index]);

        // Update the ref values with sorted data
        mapBenchmarks.value = sortedBenchmarks;
        dropRates.value = sortedDropRates;

        //console.log('sorted: ', fishingHoles.value, dropRates.value);
        benchmarkToggle.value = true; 
    }
}

const url = computed(() => {
    return `../api/benchmarks/maps/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`;
})
// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getMapBenchmarks(url.value);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getMapBenchmarks(url.value);

        
    }
    console.log('url: ', url.value);
})
// Update the progress of loading the data 
window.Echo.channel('progress')
    .listen('LoadingProgress', (e) => {
        currentProgress.value = e.progress; 
        //console.log('Loading Progress: ', e.progress);
    })

const getMapBenchmarks = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    if (responseData){
        mapBenchmarks.value = responseData.benchmarks;
        dropRates.value = responseData.dropRates; 
        
        sortBenchmarks(mapBenchmarks.value); 
    }
}

watch(refreshSettings, async (newSettings) => {
    if (newSettings){
        currentlyRefreshing.value = true; 

        await getMapBenchmarks(url.value);

        currentlyRefreshing.value = false;
        refreshSettings.value = false;
    }
})

</script>