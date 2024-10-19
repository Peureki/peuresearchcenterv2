<template>
    <Header page-name="Glyphs"/>
    <Nav>
        <template v-slot:filters>
            <p v-if="!user" class="error-message">Register/Login to be able to save these Filters</p>

            <div class="filter-container">
                <h3>Filters</h3>
                <!-- 
                    *
                    * RADIO FILTERS
                    * Only chose one of the filters to be displayed
                    *
                -->
                <p>Show Glyph</p>
                <div class="filter-collection">
                    <FilterRadio
                        :toggle-options="filterGlyphs"
                        :filter-property="filters.showGlyph"
                        filter-property-name="showGlyph"
                    />
                </div>
                <!-- 
                    *
                    * TOGGLE FILTERS
                    * Apply or remove as many filters as the user wishes
                    *
                -->
                <!-- 
                    *
                    * GLYPH LEVELS
                    *
                -->
                <div v-if="filters.showGlyph == 'All'" class="filter-collection-container">
                    <p>Levels</p>
                    <div class="filter-collection">
                        <FilterToggle
                            v-if="filterLevels"
                            v-for="level in filterLevels"
                            :toggle-option="level"
                            filter-property-name="toggleGlyphLevels"
                        />
                    </div>
                </div>
                <!-- 
                    *
                    * GLYPH TYPES
                    *
                -->
                <div v-if="filters.showGlyph == 'All'" class="filter-collection-container">
                    <p>Type</p>
                    <div class="filter-collection">
                        <FilterToggle
                            v-if="filterTypes"
                            v-for="type in filterTypes"
                            :toggle-option="type"
                            filter-property-name="toggleGlyphTypes"
                        />
                    </div>
                </div>
            </div>
        </template>

    </Nav>
    

    <section class="main">
        <div class="content-section gap-content">
            <!-- 
                *
                * 'ALL' BOUNTY GLYPHS
            -->
            <Info 
                v-if="filters.showGlyph == 'All'"
                message="Karma versions of these glyphs can be purchases at major cities and lounges under [Gathering Merchant]. Lion's Arch example: "
                link="[&BCwEAAA=]"
            />
            <GlyphBenchmarks
                v-if="glyphs && filters.showGlyph == 'All'"
                :benchmarks="glyphs"
                :drop-rates="glyphDropRates"
            />
            <!-- 
                *
                * ONLY BOUNTY GLYPH
            -->
            <Info 
                v-if="filters.showGlyph == 'Bounty'"
                message="(+Bounty value) Node Value. For ore and logs, bountyValue = (nodeValue * 1.1583) - nodeValue. For plants, bountyValue = (nodeValue * 1.4748) - nodeValue. To get Karma Bounty tools: "
                link="[&BCwEAAA=]"
            />
            <NodeBenchmarks
                v-if="nodes && filters.showGlyph == 'Bounty'"
                :benchmarks="nodes"
                :drop-rates="nodeDropRates"
            />

        </div>
    </section>

    <Loading v-if="!glyphs || currentlyRefreshing" :width="200" :height="200" :progress="currentProgress"/>
    <Footer/>
</template>

<script setup>
import { onMounted, ref, computed, watch, onUnmounted } from 'vue'
import { user, sellOrder, tax, includes, refreshSettings, filters, filtersToggle } from '@/js/vue/composables/Global';
import { getAuthUser } from '@/js/vue/composables/Authentication';


import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import GlyphBenchmarks from '@/js/vue/components/benchmarks/GlyphBenchmarks.vue';
import NodeBenchmarks from '@/js/vue/components/benchmarks/NodeBenchmarks.vue';
import Info from '@/js/vue/components/general/Info.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import FilterRadio from '@/js/vue/components/filters/FilterRadio.vue'
import FilterToggle from '@/js/vue/components/filters/FilterToggle.vue'

const glyphs = ref(null),
    nodes = ref(null),
    glyphDropRates = ref(null),
    nodeDropRates = ref(null);

const currentlyRefreshing = ref(false),
    currentProgress = ref(0);

// *
// * FILTERS
// * 
const filterGlyphs = ['All', 'Bounty'],
    filterLevels = ref(null),
    filterTypes = ref(null);

console.log('filters: ', filters.value.showGlyph);

// ALL GLYPHS
const allGlyphURL = computed(() => {
    return `../api/benchmarks/glyphs/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`
})
// FOR BOUNTY GLYPH COMPARISONS
const nodeURL = computed(() => {
    return `../api/benchmarks/nodes/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`
})

// BY DEFAULT
// If there is no user logged in, use default settings
onMounted( async () => {
    // Check if user is being auth
    await getAuthUser();
    // IF NO USER
    if (!user.value){
        console.log('no user')
        getGlyphs(allGlyphURL.value);
    } 
    // USER FOUND
    else {
        console.log('user found')
        getGlyphs(allGlyphURL.value);
        getGlyphBountyNodes(nodeURL.value);
    }
    //console.log('glyph url: ', allGlyphURL.value);
})
// Update the progress of loading the data 
window.Echo.channel('progress')
    .listen('LoadingProgress', (e) => {
        currentProgress.value = e.progress; 
        //console.log('Loading Progress: ', e.progress);
    })

const sortGlyphs = (benchmarks) => {
    if (benchmarks){
        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);


        // Sort the indexes based on the estimatedValue
        indexes.sort((a, b) => benchmarks[b].value - benchmarks[a].value);

        // Use the sorted indexes to sort benchmarks and glyphDropRates
        const sortedBenchmarks = indexes.map(index => benchmarks[index]);
        const sortedGlyphDropRates = indexes.map(index => glyphDropRates.value[index]);

        // Update the ref values with sorted data
        glyphs.value = sortedBenchmarks;
        glyphDropRates.value = sortedGlyphDropRates;

        //console.log('sorted: ', fishingHoles.value, glyphDropRates.value);
        //benchmarkToggle.value = true; 
    }
}

const sortNodes = (benchmarks) => {
    if (benchmarks){
        // Create an array of indexes
        const indexes = benchmarks.map((_, index) => index);


        // Sort the indexes based on the estimatedValue
        indexes.sort((a, b) => benchmarks[b].value - benchmarks[a].value);

        // Use the sorted indexes to sort benchmarks and glyphDropRates
        const sortedBenchmarks = indexes.map(index => benchmarks[index]);
        const sortedNodeDropRates = indexes.map(index => nodeDropRates.value[index]);

        // Update the ref values with sorted data
        nodes.value = sortedBenchmarks;
        nodeDropRates.value = sortedNodeDropRates;

        //console.log('sorted: ', fishingHoles.value, glyphDropRates.value);
        //benchmarkToggle.value = true; 
    }
}
// *
// * LIST PROPERTIES
// * Create a list of unique properties from a given array
// * Ex: glyph[0].level: All, glyph[1].level = '71-80'
// * List: ['All', '71-80']
const listProperties = (desiredProperty, targetArray) => {
    // Initalize a new Set
    const uniqueValues = new Set(); 
    // Check if the array has the desired property
    // If yes => add to Set if unique
    targetArray.forEach(item => {
        if (item.hasOwnProperty(desiredProperty)){
            uniqueValues.add(item[desiredProperty]);
        }
    })

    return Array.from(uniqueValues); 
}

const getGlyphs = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 
    
    if (responseData){
        glyphs.value = responseData.benchmarks;
        glyphDropRates.value = responseData.dropRates;  

        // SET FILTER PROPERTIES
        filterLevels.value = listProperties('level', glyphs.value); 
        filterTypes.value = listProperties('type', glyphs.value);
        // SORT GLYPHS BY VALUE
        sortGlyphs(glyphs.value);
        
        currentlyRefreshing.value = false;
    }
}

const getGlyphBountyNodes = async (url) => {
    const response = await fetch(url);
    const responseData = await response.json(); 

    if (responseData){

        nodes.value = responseData.benchmarks;
        nodeDropRates.value = responseData.dropRates; 

        // APPLY BOUNTY VALUES TO NODES
        nodes.value.forEach(node => {
            let bountyValue = 0; 
            if (node.type == 'Ore' || node.type == 'Log')
                bountyValue = (node.value * 1.1583) - node.value; 

            if (node.type == 'Plant'){
                bountyValue = (node.value * 1.4748) - node.value;
            }
            node.value += bountyValue;
            node.bountyValue = bountyValue;
        })

        //console.log('nodes after bounty: ', nodes.value);

        sortNodes(nodes.value);
    }
}
// Show Filters tab
onMounted(() => {
    filtersToggle.value = true; 
})
// Don't show Filters tab when leaving the page
onUnmounted(() => {
    filtersToggle.value = false;
})

watch(refreshSettings, async (newSettings) => {
    if (newSettings){
        currentlyRefreshing.value = true; 

        //await getMapBenchmarks(allGlyphURL.value);

        currentlyRefreshing.value = false;
        refreshSettings.value = false;
    }
})

</script>