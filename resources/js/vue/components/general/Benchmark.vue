<template>
    <div class="fishing-hole-grid">
        <div
            class="fishing-hole-card"
            v-for="(benchmark, index) in benchmarks" :key="index"
        >
            
            <div class="card-container">
                <p class="rank">{{ index + 1 }}</p>
                <img class="legendary-fish" :src="benchmark.mostValuedIcon" :alt="benchmark.mostValuedItem" :title="benchmark.mostValuedItem">
                <div class="fishing-hole-details">
                    <!--
                        *
                        * TITLE AND ESTIMATES
                        *
                    -->
                    <span class="fishing-title-and-estimate">
                        <span class="title-container">
                            <p 
                                class="title"
                                :class="changeBackgroundType(benchmark.type)"
                            >{{ benchmark.map }}
                            </p>
                            
                        </span>
                        
                        <span class="gold-label-container">
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
                        * MAP AND REQUIREMENTS
                        *
                    -->
                    <span class="fishing-map-and-requirements">
                        <p class="map-and-region">{{ benchmark.type }}</p>
                        <!--
                            *
                            * REQUIREMENTS
                            *
                        -->
                        <span class="requirements">
                            <span class="fishing-power-container" v-for="currency in setCurrencies(dropRates[index])">
                                <img class="fishing-power-icon" :src="currency.icon">
                                <p class="currencies">{{ currency.value }}</p>
                            </span>

                            <svg 
                                class="arrow"
                                @click="expand[index] = !expand[index]"
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
                class="details"
            >
                <div class="pie-chart">
                    <PieChart
                        :drop-rates="dropRates[index]"
                    />
                </div>
                
                <div>
                    <BenchmarkTable
                        :benchmark="benchmark"
                        :drop-rates="dropRates[index]"
                    />
                </div>
                
            </div>
        </div>
    </div>

    

    
</template>

<script setup>
import { ref, computed, watch } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

import BenchmarkTable from '@/js/vue/components/tables/BenchmarkTable.vue'
import FishProofs from '@/js/vue/components/general/FishProofs.vue'
import PieChart from '@/js/vue/components/general/PieChart.vue'

import { tyrianCurrentPeriod, canthanCurrentPeriod } from '@/js/vue/composables/Global.js'

import GreenHook from '@/imgs/icons/fishes/Green_Hook.png'


const props = defineProps({
    benchmarks: Object,
    dropRates: Object,
})

const setCurrencies = (drops) => {
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

console.log('drop rates', props.dropRates);

</script>

<style scoped>
.gold-label{
    font-size: var(--font-size-h5);
}


.fishing-hole-grid{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: 10px;
}
.fishing-hole-card{
    position: relative;
    display: flex;
    flex-wrap: wrap;
    border: 1px solid #686868;
    padding: var(--padding-benchmark-container);
    border-radius: 5px;
    background-color: var(--color-bkg-fade);
    gap: 50px;
    transition: var(--transition-all-03s-ease);
}
p.rank{
    position: absolute;
    font-size: var(--font-size-h2);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0.1;
    z-index: 1;
}
.card-container{
    position: relative;
    display: flex;
    gap: var(--gap-general);
    width: 100%;
    z-index: 2;
}

.fishing-hole-card:hover{
    border: 1px solid var(--color-link);
}
.fishing-hole-card:hover svg.arrow,
.fishing-hole-card:focus svg.arrow{
    transform: rotate(45deg);
}
.fishing-hole-details{
    display: flex;
    width: 100%;
    gap: var(--gap-general);
    flex-direction: column;
    justify-content: space-between;
}
.fishing-title-and-estimate{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.title-container{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}
.title {
    font-size: var(--font-size-h4);
}
.fishing-map-and-requirements{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 50px;
}

.requirements{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}
img.bait{
    width: 20px;
    height: 20px;
}
.fishing-power-container{
    display: flex;
    gap: 3px;
}
p.currencies{
    color: var(--color-text-fade);
}
img.fishing-power-icon,
svg.sun,
svg.moon,
svg.arrow{
    width: 20px;
    height: 20px;
}
svg.arrow {
    cursor: pointer;
    transform: rotate(-45deg);
    transition: var(--transition-all-03s-ease);
}
svg.arrow path{
    fill: var(--color-link);
}
.fishing-power{
    display: flex;
    align-items: center;
    gap: 5px;
}
.details{
    display: grid;
    grid-template-columns: 1fr 3fr;
    width: 100%;
    gap: var(--gap-content);
}
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