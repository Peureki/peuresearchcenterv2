<template>
    <Nav/>
    <Header page-name="Map Benchmarks"/>

    <section class="main">
        <Benchmark
            v-if="benchmarkToggle"
            :benchmarks="mapBenchmarks"
            :drop-rates="dropRates"
        />
    </section>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import { user, sellOrder, tax, includes } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Benchmark from '@/js/vue/components/general/Benchmark.vue'


const mapBenchmarks = ref([]),
    dropRates = ref([]),
    benchmarkToggle = ref(false);

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

onMounted(() => {
    if (!user.value){
        console.log('no user')
        getMapBenchmarks(url.value);
    } 
    else {
        console.log('user found')
        getMapBenchmarks(url.value);
    }
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

</script>