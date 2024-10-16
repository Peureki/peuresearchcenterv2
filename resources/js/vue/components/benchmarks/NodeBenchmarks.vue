<template>
    <PageButtons
        v-if="combinations"
        :data-array="combinations"
        @new-url="handleNewUrl"
    />

    <div class="card-grid">
        <div
            class="card-container"
            v-for="(benchmark, index) in benchmarks" :key="index"
        >
            <!-- <p class="rank">{{ index + 1 }}</p> -->
            <div class="card">
                
                <img class="card-main-icon" :src="benchmark.mostValuedItemIcon" :alt="benchmark.mostValuedItemName" :title="benchmark.mostValuedItemName">
                <div class="card-details">
                    <!--
                        *
                        * TITLE AND ESTIMATES
                        *
                    -->
                    <span class="card-title-and-value">
                        <!-- MAP TITLE -->
                        <span class="title-container">
                            <p class="title node">{{ benchmark.map }}
                            </p>  
                        </span>
                        <!-- MAP VALUE -->
                        <span class="gold-label-container benchmark-value">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(benchmark.gph)"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                            </span>
                        </span>
                    </span>
                    <!--
                        *
                        * MAP AND currencies
                        *
                    -->
                    <span class="card-map-and-info">
                        <span class="img-and-label">
                            <span v-for="(glyph, index) in benchmark.glyphs" class="img-and-label">
                                <img :src="setGatheringToolIcons(index)" :alt="glyph.name" :title="glyph.name">
                                <p>{{ glyph.name }}</p>
                            </span>
                        </span>
                        
                        <!--
                            *
                            * currencies
                            *
                        -->
                        <span class="card-info-container">
                            <span class="card-currencies" v-for="currency in setCurrencies(combinations[index])">
                                <img class="card-currency" :src="currency.icon">
                                <p>{{ currency.value }}</p>
                            </span>

                            <svg 
                                class="arrow"
                                @click="expand[index] = !expand[index]"
                                :class="activeArrow(expand[index])"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFFFFF"/>
                            </svg>
                        </span>
                    </span>
                </div>
            </div>

            <div 
                v-if="expand[index]"
                class="details-container"
            >
                <MobileDetailsTable
                    :drop-rates="benchmark.nodes"
                />

                <PieChart
                    v-if="!isMobile"
                    :drop-rates="benchmark.nodes"
                />

                <!--
                    *
                    * GATHERING ROUTE GUIDES FOR SPECIFIC FARMS
                    *
                -->
                <BloodstoneFen v-if="benchmark.map == 'Bloodstone Fen (Logs, Plants)'"/>
                <DraconisMons v-if="benchmark.map == 'Draconis Mons (Plants)'"/>
                <Flax v-if="benchmark.map == 'Flax (Plants)'"/>
                <HoneyFlowersAndLowlandPineSaplings v-if="benchmark.map == 'Honey Flowers & Lowland Pine Saplings'"/> 
                <MaguumaLilies v-if="benchmark.map == 'Maguuma Lilies (Herbs)'"/>
                <Mussels v-if="benchmark.map == 'Mussels (Plants)'"/>
                <RichNodes v-if="benchmark.map == 'Rich Nodes (Iron, Platinum)'"/>
                
            </div>
        </div>
    </div>

    <PageButtons
        v-if="combinations"
        :data-array="combinations"
        @new-url="handleNewUrl"
    />

    
</template>

<script setup>
import { ref, computed, watch } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { activeArrow } from '@/js/vue/composables/BasicFunctions'

import BenchmarkTable from '@/js/vue/components/tables/BenchmarkTable.vue'
import PieChart from '@/js/vue/components/general/PieChart.vue'
import MobileBenchmarkTable from '@/js/vue/components/tables/MobileBenchmarkTable.vue'
import MobileDetailsTable from '@/js/vue/components/tables/MobileDetailsTable.vue'
import PageButtons from '@/js/vue/components/general/PageButtons.vue'

import { isMobile } from '@/js/vue/composables/Global.js'

import Ore from '@/imgs/icons/Ore.png'
import Log from '@/imgs/icons/Log.png'
import Plant from '@/imgs/icons/Plant.png'

// GUIDES
import BloodstoneFen from '@/js/vue/components/guides/nodes/BloodstoneFen.vue'
import DraconisMons from '@/js/vue/components/guides/nodes/DraconisMons.vue'
import Flax from '@/js/vue/components/guides/nodes/Flax.vue'
import HoneyFlowersAndLowlandPineSaplings from '@/js/vue/components/guides/nodes/HoneyFlowersAndLowlandPineSaplings.vue'
import MaguumaLilies from '@/js/vue/components/guides/nodes/MaguumaLilies.vue'
import Mussels from '@/js/vue/components/guides/nodes/Mussels.vue'
import RichNodes from '@/js/vue/components/guides/nodes/RichNodes.vue'


const props = defineProps({
    benchmarks: Object,
    combinations: Object,
})

const emit = defineEmits(['get-new-node-benchmark-url']);

// Emit new url from PageButtons via pagnation
const handleNewUrl = (url) => {
    emit('get-new-node-benchmark-url', url); 
}

// Set gathering tool icons to v-for when displaying which glyphs to use 
const setGatheringToolIcons = (index) => {
    switch (index){
        case 0: return Ore; 
        case 1: return Log;
        case 2: return Plant;
    }
}

const setCurrencies = (drops) => {
    return null; 
    // If benchmark does not contain any currencies
    if (drops.hasOwnProperty('node_benchmark_id')){
        return null; 
    }

    const set = new Set(); 
    drops.forEach(item => {
        if (item.currency_id && item.currency_id != 1){
            set.add(JSON.stringify({ 
                icon: item.icon, 
                value: Math.round(item.drop_rate / item.time) 
            }));
        }
    });
    return Array.from(set).map(item => JSON.parse(item));
}

// Individually allow each card to be expanded or not
// By default, have each card not expanded
const expand = ref(props.benchmarks.map(() => false));

const changeBackgroundType = (type) => {
    return {
        repeatable: type === 'Repeatable',
        daily: type === 'Daily',
        node: type === 'Node',
        solo: type === 'Solo',
    }
}

console.log('drop rates', props.combinations);

</script>

<style scoped>
/* .gold-label{
    font-size: var(--font-size-h5);
} */



/*
    *
    * DYNAMIC CLASSES
    * For day/night fish and routes
*/
.repeatable{
    color: var(--color-type-repeatable);
}
.daily{
    color: var(--color-type-daily);
}
.node{
    color: var(--color-type-node);
}
.solo{
    color: var(--color-type-solo);
}

</style>