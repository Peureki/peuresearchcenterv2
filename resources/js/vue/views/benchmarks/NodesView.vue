<template>
    <Header page-name="Nodes"/>
    <Nav>
        <template v-slot:filters>
            <div class="filter-container">
                <h3>Filters</h3>
                <!-- 
                    *
                    * NODE TYPES
                    *
                -->
                <div class="filter-collection-container" v-if="filterTypes">
                    <p>Type</p>
                    <div class="filter-collection">
                        <FilterToggle
                            v-for="type in filterTypes"
                            :toggle-option="type"
                            filter-property-name="toggleNodeTypes"
                        />
                    </div>
                </div>
            </div>
        </template>

    </Nav>

    <section class="main">
        <div class="content-section">
            <NodeBenchmarks
                v-if="nodes"
                :benchmarks="nodes"
                :drop-rates="dropRates"
            />
        </div>
    </section>

    <Loading v-if="!nodes || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>
    <Footer/>
</template>

<script setup>
import { onMounted, ref, computed, watch, onUnmounted } from 'vue'
import { user, sellOrder, tax, includes, refreshSettings, filtersToggle } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';
import { listProperties } from '@/js/vue/composables/FormatFunctions';

import Echo from 'laravel-echo';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import NodeBenchmarks from '@/js/vue/components/benchmarks/NodeBenchmarks.vue';
import Loading from '@/js/vue/components/general/Loading.vue'
import FilterToggle from '@/js/vue/components/filters/FilterToggle.vue';

const nodes = ref(null),
    dropRates = ref([]);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

// Initilize filters
const filterTypes = ref(null); 

// ESTIMATED farms
const url = computed(() => {
    return `../api/benchmarks/nodes/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        //console.log('no user')
        getNodes(url.value);
    } 
    // USER FOUND
    else {
        //console.log('user found')
        getNodes(url.value);
    }
    // Show Filters tab
    filtersToggle.value = true; 
    //console.log('node url: ', url.value);
})

// Don't show Filters tab when leaving the page
onUnmounted(() => {
    filtersToggle.value = false;
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
        nodes.value = sortedBenchmarks;
        dropRates.value = sortedDropRates;

        //console.log('sorted: ', fishingHoles.value, dropRates.value);
        //benchmarkToggle.value = true; 
    }
}

const getNodes = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    if (responseData){
        //console.log('response data: ', responseData)
        nodes.value = responseData.benchmarks;
        dropRates.value = responseData.dropRates;  

        // SET FILTER PROPERTIES
        filterTypes.value = listProperties('type', nodes.value); 
        
        sortBenchmarks(nodes.value);
        
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