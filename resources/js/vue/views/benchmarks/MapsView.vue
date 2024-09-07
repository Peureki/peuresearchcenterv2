<template>
    <Nav/>
    <Header page-name="Map Benchmarks"/>

    <section>
        <Benchmark
            v-if="benchmarkToggle"
            :benchmarks="mapBenchmarks"
            :drop-rates="dropRates"
        />
    </section>
</template>

<script setup>
import { ref } from 'vue'


import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Benchmark from '@/js/vue/components/general/Benchmark.vue'


const mapBenchmarks = ref([]),
    dropRates = ref([]),
    benchmarkToggle = ref(false);

const currencies = ref([]);

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

const url = `../api/benchmarks/maps/${localStorage.includes}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

console.log(url);

const getMapBenchmarks = async () => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    console.log('map benchmarks: ', responseData);
    if (responseData){
        mapBenchmarks.value = responseData.benchmarks;
        dropRates.value = responseData.dropRates; 
        
        sortBenchmarks(mapBenchmarks.value); 
    }

}

getMapBenchmarks();

</script>