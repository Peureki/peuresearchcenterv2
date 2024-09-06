<template>
    <div class="mobile-benchmark-details-container">
        <!--
            *
            * TOTAL
            *
        -->
        <div class="mobile-info-container">
            <p>Avg Total: </p>

            <span class="gold-label-container">
                <span 
                    class="gold-label"
                    v-for="gold in formatValue(benchmarkTotal)"
                >
                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                </span>
            </span>
        </div>

        <!--
            * V-IF FISH
            * CATCH VALUE
            *
        -->
        <div class="mobile-info-container" v-if="type == 'Fishing'">
            <p>Catch Value: </p>

            <span class="gold-label-container">
                <span 
                    class="gold-label"
                    v-for="gold in formatValue(benchmark.catchValue)"
                >
                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                </span>
            </span>
        </div>

        <!--
            * V-IF FISH
            * AVG HOLES
            *
        -->
        <div class="mobile-info-container" v-if="type == 'Fishing'">
            <p>Avg Holes: </p>

            <p>{{ formatToDecimal(benchmark.avgHoles) }}</p>
        </div>

        <!--
            *
            * TIME
            *
        -->
        <div class="mobile-info-container">
            <p>Avg Time: </p>

            <p>{{ benchmarkTime }}</p>
        </div>

        <!--
            *
            * SAMPLE SIZE
            *
        -->
        <div class="mobile-info-container">
            <p>Sample Size: </p>

            <p>{{ benchmark.sampleSize }}</p>
        </div>

        <!--
            *
            * FORMULA
            *
        -->
        <div class="mobile-info-container">
            <p>Formula: </p>

            <!-- 
                * V-IF
                * FOR FISHING
            -->
            <span class="formula" v-if="type == 'Fishing'">
                <p>(( catchValue * avgHoles ) * #ofCatches) * (60min / avgTime)</p>
                
            </span>

            <!-- 
                * V-IF
                * FOR MAP
            -->
            <span class="formula" v-if="type == 'Map'">
                <p>Total / avgTime</p>
            </span>
        </div>
        <!--
            *
            * MATH
            *
        -->
        <div class="mobile-info-container">
            <p>Math: </p>

            <!-- 
                * V-IF
                * FOR FISHING
            -->
            <span class="formula" v-if="type == 'Fishing'">
                <span class="gold-label-container">
                    ((
                    <span 
                        class="gold-label"
                        v-for="gold in formatValue(benchmark.catchValue)"
                    >
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                    </span>
                </span>

                <p>*</p>

                <p>{{ formatToDecimal(benchmark.avgHoles)}})</p>

                <p>*</p>

                <p>3)</p>

                <p>*</p>

                <p>(60 / {{ benchmarkTimeVariable }})</p>
                
            </span>

            <!-- 
                * V-IF
                * FOR MAP
            -->
            <span class="formula" v-if="type == 'Map'">
                <span class="gold-label-container">
                    <span 
                        class="gold-label"
                        v-for="gold in formatValue(benchmarkTotal)"
                    >
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                    </span>
                </span>

                <p>/</p>

                <p>~{{ benchmarkTimeVariable }}</p>
            </span>
        </div>

        <div v-if="type == 'Fishing'" v-for="item in sortedDropRates" class="mobile-drops-container">
            <div class="img-and-label">
                <img class="icon" v-if="item.icon" :src="item.icon" :alt="item.name" :title="item.name">

                <p class="item-name" :style="{color: showRarityColor(item.rarity)}">{{ item.name }}</p>
            </div>
            

            <p class="drop-rate">{{ formatPercentage(item.drop_rate) }}</p>
            
            <span class="gold-label-container">
                <span 
                    class="gold-label"
                    v-for="gold in formatValue(item.value)"
                >
                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                </span>
            </span>
        </div>

        <!--
            *
            * DROP RATES
            *
        -->

        <div v-if="type == 'Map'" v-for="item in sortedDropRates" class="mobile-drops-container">
            <div class="img-and-label">
                <img class="icon" v-if="item.item_icon" :src="item.item_icon" :alt="item.item_name" :title="item.item_name">
                <img class="icon" v-if="item.icon" :src="item.icon" :alt="item.currency_name" :title="item.currency_name">

                <p class="item-name" :style="{color: showRarityColor(item.rarity)}" v-if="item.item_name">{{ item.item_name }}</p>
                <p class="item-name" :style="{color: showRarityColor(item.rarity)}" v-if="item.currency_name">{{ item.currency_name }}</p>
            </div>
            

            <p class="drop-rate">{{ formatToDecimal(item.drop_rate) }}</p>
            
            <span class="gold-label-container">
                <span 
                    class="gold-label"
                    v-for="gold in formatValue(item.value)"
                >
                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                </span>
            </span>
        </div>
    </div>

</template>

<script setup>
import { formatValue, formatStringToTime, showRarityColor, formatToDecimal, formatToMinutes, formatPercentage } from '@/js/vue/composables/FormatFunctions.js'
import { computed } from 'vue';

const props = defineProps({
    type: String,
    benchmark: Object, 
    dropRates: Object,
})

const sortedDropRates = computed(() => {
    // Filter out any drop rates that have 0 as a drop rate
    // Since they have 0 drop rate, they wouldn't have a value property
    const newDropRates = props.dropRates.filter(item => Number(item.drop_rate) != 0);
    return newDropRates.sort((a, b) => b.value - a.value);
})

const benchmarkTotal = computed(() => {
    switch (props.type){
        case 'Fishing': return props.benchmark.estimateValue;
        case 'Map': return props.benchmark.total;
    }
})

const benchmarkTime = computed(() => {
    switch (props.type){
        case 'Fishing': return formatToMinutes(props.benchmark.timeVariable);
        case 'Map': return formatStringToTime(props.benchmark.time);
    }
})

const benchmarkTimeVariable = computed(() => {
    switch (props.type){
        case 'Fishing': return formatToDecimal(props.benchmark.timeVariable);
        case 'Map': return formatToDecimal(props.benchmark.time);
    }
})

console.log('benchmark: ', props.benchmark);
console.log('drop rates: ', props.dropRates);

</script>

<style scoped>


</style>