<template>
    <Nav/>
    <Header page-name="Glyphs"/>

    <section class="main">
        <div class="content-section gap-content">
            <Info 
                message="Karma versions of these glyphs can be purchases at major cities and lounges under [Gathering Merchant]. Lion's Arch example: "
                link="[&BCwEAAA=]"
            />
            <GlyphBenchmarks
                v-if="glyphs"
                :benchmarks="glyphs"
                :drop-rates="dropRates"
            />
        </div>
    </section>

    <Loading v-if="!glyphs || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>
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
import GlyphBenchmarks from '@/js/vue/components/benchmarks/GlyphBenchmarks.vue';
import Info from '@/js/vue/components/general/Info.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

const glyphs = ref(null),
    dropRates = ref([]);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

// ESTIMATED farms
const url = computed(() => {
    return `../api/benchmarks/glyphs/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getGlyphs(url.value);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getGlyphs(url.value);
    }
    //console.log('glyph url: ', url.value);
})
// Update the progress of loading the data 
window.Echo.channel('progress')
    .listen('LoadingProgress', (e) => {
        currentProgress.value = e.progress; 
        //console.log('Loading Progress: ', e.progress);
    })

const sortBenchmarks = (benchmarks) => {
    if (benchmarks){
        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);


        // Sort the indexes based on the estimatedValue
        indexes.sort((a, b) => benchmarks[b].value - benchmarks[a].value);

        // Use the sorted indexes to sort benchmarks and dropRates
        const sortedBenchmarks = indexes.map(index => benchmarks[index]);
        const sortedDropRates = indexes.map(index => dropRates.value[index]);

        // Update the ref values with sorted data
        glyphs.value = sortedBenchmarks;
        dropRates.value = sortedDropRates;

        //console.log('sorted: ', fishingHoles.value, dropRates.value);
        //benchmarkToggle.value = true; 
    }
}

const getGlyphs = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    if (responseData){
        console.log('response data: ', responseData)
        glyphs.value = responseData.benchmarks;
        dropRates.value = responseData.dropRates;  
        
        sortBenchmarks(glyphs.value);
        
        currentlyRefreshing.value = false;
    }
}

watch(refreshSettings, async (newSettings) => {
    if (newSettings){
        currentlyRefreshing.value = true; 

        //await getMapBenchmarks(url.value);

        currentlyRefreshing.value = false;
        refreshSettings.value = false;
    }
})

</script>