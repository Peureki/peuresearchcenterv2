<template>
    <Nav/>
    <Header page-name="Fishing Benchmarks"/>

    <section class="main">
        <FishBenchmark
            v-if="fishingHoleToggle"
            :fishing-holes="fishingHoles"
            :drop-rates="dropRates"
        />
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { user, buyOrder, sellOrder, tax, includes } from '@/js/vue/composables/Global'
import { getAuthUser } from '@/js/vue/composables/Authentication'


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

const url = computed(() => {
    return `../api/benchmarks/fishing/${JSON.stringify(includes.value)}/${buyOrder.value}/${sellOrder.value}/${tax.value}`;
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    console.log('url value: ', url.value);
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getFishes(url);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getFishes(url);
    }
})



const getFishes = async () => {

    console.log('getfishes url: ', url.value);

    const response = await fetch(url.value);
    const responseData = await response.json(); 
    
    fishingHoles.value = responseData.fishingHoles; 
    dropRates.value = responseData.dropRates;
    sortBenchmarks(fishingHoles.value);
}



</script>