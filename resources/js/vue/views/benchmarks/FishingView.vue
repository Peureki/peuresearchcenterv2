<template>
    <Nav/>
    <Header page-name="Fishing Benchmarks"/>

    <section>
        <FishBenchmark
            v-if="fishingHoleToggle"
            :fishing-holes="fishingHoles"
            :drop-rates="dropRates"
        />
    </section>
</template>

<script setup>
import { ref } from 'vue'


import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import FishBenchmark from '@/js/vue/components/general/FishBenchmark.vue'


const fishingHoles = ref([]),
    dropRates = ref([]),
    fishingHoleToggle = ref(false);

const sortBenchmarks = (benchmarks) => {
    if (benchmarks){
        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);

        // Sort the indexes based on the estimatedValue
        indexes.sort((a, b) => benchmarks[b].estimateValue - benchmarks[a].estimateValue);

        // Use the sorted indexes to sort benchmarks and dropRates
        const sortedBenchmarks = indexes.map(index => benchmarks[index]);
        const sortedDropRates = indexes.map(index => dropRates.value[index]);

        // Update the ref values with sorted data
        fishingHoles.value = sortedBenchmarks;
        dropRates.value = sortedDropRates;

        //console.log('sorted: ', fishingHoles.value, dropRates.value);
        fishingHoleToggle.value = true; 
    }
}



const getFishes = async () => {
    const url = `../api/benchmarks/fishing/${localStorage.includes}/${localStorage.buyOrderSetting}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

    console.log('url: ', url);

    const response = await fetch(url);
    const responseData = await response.json(); 
    
    fishingHoles.value = responseData.fishingHoles; 
    dropRates.value = responseData.dropRates;
    sortBenchmarks(fishingHoles.value);
}

getFishes();

</script>