<template>
    <Header page-name="Solo Benchmarks"/>
    <Nav>
        <template v-slot:filters>
            <h3>Filters</h3>
            <!-- 
                    *
                    * RADIO FILTERS
                    * Only chose one of the filters to be displayed
                    *
                -->
                <div v-if="mapBenchmarks" class="filter-collection-container">
                    <p>Sort by</p>
                    <div class="filter-collection">
                        <FilterRadio
                            :toggle-options="filterSort"
                            filter-property-name="sortSoloBenchmarks"
                        />
                    </div>
                </div>


        </template>
    </Nav>

    <section class="main">
        <div class="content-section">
            <Loading v-if="!benchmarkToggle || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>
            <Benchmark
                v-if="benchmarkToggle"
                :benchmarks="mapBenchmarks"
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

import Echo from 'laravel-echo';

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import Benchmark from '@/js/vue/components/benchmarks/Benchmark.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import FilterRadio from '@/js/vue/components/filters/FilterRadio.vue';

const mapBenchmarks = ref(null),
    dropRates = ref(null),
    benchmarkToggle = ref(false);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

const filter = ['Solo'],
    // List any currencies that should be sorted
    filterSort = ['Gold', 'Spirit Shard', 'Karma', 'Volatile Magic', 'Unbound Magic', 'Trade Contract'];

const sortBenchmarks = (benchmarks, sortFilter) => {
    console.log('benchmarks: ', benchmarks, 'dropRates: ', dropRates);

    if (benchmarks){
        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);
        let sortedBenchmarks = null, 
            sortedDropRates = null; 

        // SORT CURRENCIES BASED ON WHAT USER WANTS
        // Ex: Spirit Shards as targetCurrency
        const sortCurrencies = (targetCurrency) => {
            indexes.sort((a, b) => {
                const currencyA = benchmarks[a].currencies.find(currency => currency.name == targetCurrency);
                const currencyB = benchmarks[b].currencies.find(currency => currency.name == targetCurrency);

                const countA = currencyA ? currencyA.count : 0;
                const countB = currencyB ? currencyB.count : 0;

                return countB - countA; 
            });

            // Use the sorted indexes to sort benchmarks and dropRates
            sortedBenchmarks = indexes.map(index => benchmarks[index]);
            sortedDropRates = indexes.map(index => dropRates.value[index]);
        }
        // SORT by what the filter is currenctly toggled to
        switch (sortFilter){
            case 'Gold':
                // Sort the indexes based on the estimatedValue
                indexes.sort((a, b) => benchmarks[b].gph - benchmarks[a].gph);

                // Use the sorted indexes to sort benchmarks and dropRates
                sortedBenchmarks = indexes.map(index => benchmarks[index]);
                sortedDropRates = indexes.map(index => dropRates.value[index]);

                break;

            case 'Spirit Shard': sortCurrencies('Spirit Shard'); break;
            case 'Karma': sortCurrencies('Karma'); break;
            case 'Unbound Magic': sortCurrencies('Unbound Magic');  break;
            case 'Volatile Magic': sortCurrencies('Volatile Magic'); break;
            case 'Trade Contract': sortCurrencies('Trade Contract'); break;
        }

        // Update the ref values with sorted data
        mapBenchmarks.value = sortedBenchmarks;
        dropRates.value = sortedDropRates;

        console.log('merp', mapBenchmarks.value, dropRates.value);
        benchmarkToggle.value = true; 
    }
}

const url = computed(() => {
    return `../api/benchmarks/maps/${JSON.stringify(includes.value)}/${JSON.stringify(filter)}/${sellOrder.value}/${tax.value}`;
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
    filtersToggle.value = true; 
    console.log('url: ', url.value);
})
onUnmounted(() => {
    filtersToggle.value = false;
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
        
        sortBenchmarks(mapBenchmarks.value, filters.value.sortSoloBenchmarks); 
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

watch(filters, (newFilters) => {
    if (newFilters){
        console.log('new filters: ', newFilters.sortSoloBenchmarks, filters.value);
        sortBenchmarks(mapBenchmarks.value, newFilters.sortSoloBenchmarks);
    }
})

</script>