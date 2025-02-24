<template>
    <div class="card-grid">
        <div
            class="card-container"
            v-for="(benchmark, index) in filteredBenchmarks" :key="index"
        >
            <p class="rank">{{ index + 1 }}</p>
            <div class="card">
                
                <img class="card-main-icon" :src="benchmark.mostValuedIcon" :alt="benchmark.mostValuedItem" :title="benchmark.mostValuedItem">
                <div class="card-details">
                    <!--
                        *
                        * TITLE AND ESTIMATES
                        *
                    -->
                    <span class="card-title-and-value">
                        <!-- MAP TITLE -->
                        <span class="title-container">
                            <p 
                                class="title"
                                :class="changeBackgroundType(benchmark.type)"
                            >{{ benchmark.map }}
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
                        <p class="map-and-region">{{ benchmark.type }}</p>
                        <!--
                            *
                            * currencies
                            *
                        -->
                        <span class="card-info-container">
                            <span class="card-currencies" v-for="currency in benchmark.currencies">
                                <img class="card-currency" :src="currency.icon">
                                <p>{{ currency.count }}</p>
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
                    :drop-rates="dropRates[index]"
                />

                <div class="details">
                    <PieChart
                    v-if="!isMobile"
                    :drop-rates="dropRates[index]"
                />

                    <!--
                        *
                        * EVENT DETAIL PAGES
                        *
                    -->
                    <BitterfrostEvents v-if="benchmark.map == 'Bitterfrost Events'" />
                    <BitterfrostIceboundChests v-if="benchmark.map == 'Bitterfrost Icebound Chests'"/>
                    <DomainOfKournaInquests v-if="benchmark.map == 'Kourna Inquest'"/>
                    <SandsweptInquestDrake v-if="benchmark.map == 'Sandswept Inquest/Drake'"/>

                    <p v-else class="small-subtitle">Benchmark guide coming soon</p>
                </div>
                
            </div>
        </div>
    </div>

    

    
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

import { isMobile, filters } from '@/js/vue/composables/Global.js'

// SOLO BENCHMARK DESCRIPTIONS AND PICTURE GUIDES
import BitterfrostEvents from '@/js/vue/components/guides/solos/BitterfrostEvents.vue'
import BitterfrostIceboundChests from '@/js/vue/components/guides/solos/BitterfrostIceboundChests.vue'
import DomainOfKournaInquests from '@/js/vue/components/guides/solos/DomainOfKournaInquests.vue'
import SandsweptInquestDrake from '@/js/vue/components/guides/solos/SandsweptInquestDrake.vue'



const props = defineProps({
    benchmarks: Object,
    dropRates: Object,
    filterProperty: String, 
})

const filteredBenchmarks = computed(() => {
    if (props.filterProperty){
        return props.benchmarks.filter(benchmark => 
            filters.value[props.filterProperty].includes(benchmark.type)
        )
    } else {
        return props.benchmarks;
    }
})

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

//console.log('drop rates', props.dropRates);

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


</style>