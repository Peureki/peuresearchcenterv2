<template>
    <Nav/>
    <Header page-name="Fishing Benchmarks"/>

    <section>
        <FishBenchmark
            v-if="fishingHoles"
            :fishing-holes="fishingHoles"
        />
    </section>
</template>

<script setup>
import { ref } from 'vue'


import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import FishBenchmark from '@/js/vue/components/general/FishBenchmark.vue'


const fishingHoles = ref([]),
    dropRates = ref([]);

const sortBenchmarks = (benchmarks) => {
    if (benchmarks){
        benchmarks.sort((a, b) => b.estimateValue - a.estimateValue);
        console.log('sorted: ', benchmarks);
    }
}



const getFishes = async () => {
    const response = await fetch(`../api/benchmarks/fishing/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`);
    const responseData = await response.json(); 
    
    fishingHoles.value = responseData.fishingHoles; 
    dropRates.value = responseData.dropRates;
    console.log(dropRates.value);
    sortBenchmarks(fishingHoles.value);
}

getFishes();

</script>