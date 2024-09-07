<template>
    <div class="mobile-currency-container">
        <div v-for="(item, index) in sortedBags.bags" class="mobile-currency-card">
            <div class="label-and-cta">
                <div class="img-and-label">
                    <img v-if="item.icon" class="icon" :src="item.icon" :alt="item.name" :title="item.name">

                    <p class="item-name" :style="{color: showRarityColor(item.rarity)}">{{ item.name }}</p>
                </div>

                <svg 
                    class="arrow" 
                    :class="activeArrow(expand[index])"
                    @click="expand[index] = !expand[index];" 
                    width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                </svg>
            </div>

            <div class="value-container">
                <div class="value-conversion">
                    <span class="gold-label-container">
                        <span 
                            class="gold-label"
                            v-for="gold in formatValue(item.profitPerBag)"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                        </span>
                    </span>
                    <p>/</p>
                    <div class="img-and-label">
                        <img class="icon" :src="currencyIcon" :alt="targetCurrency" :title="targetCurrency">

                        <p class="item-name">{{ item.costOfCurrencyPerBag }}</p>
                    </div>
                </div>

                <div class="value">
                    <span class="gold-label-container">
                        <span 
                            class="gold-label"
                            v-for="gold in formatValue(item.currencyPerBag)"
                        >
                            {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                        </span>
                    </span>
                </div>
            </div>
            <!--
                *
                * DETAILS
                *
            -->
            <div v-if="expand[index]" class="details-container">     
                <MobileDetailsTable
                    :drop-rates="sortedBags.dropRates[index]"
                />

                <PieChart
                    v-if="!isMobile"
                    :drop-rates="sortedBags.dropRates[index]"
                />
            </div>
        </div>
    </div>
        
</template>

<script setup>
import { ref, computed } from 'vue';
import { showRarityColor, formatValue } from '@/js/vue/composables/FormatFunctions';
import { isMobile } from '@/js/vue/composables/Global'
import { activeArrow } from '@/js/vue/composables/BasicFunctions';

import PieChart from '@/js/vue/components/general/PieChart.vue'
import MobileDetailsTable from '@/js/vue/components/tables/MobileDetailsTable.vue'

const props = defineProps({
    targetCurrency: String,
    bags: Object, 
    dropRates: Object,
    currencyIcon: String, 
})

console.log('drop rates: ', props.dropRates);

// Individually allow each card to be expanded or not
// By default, have each card not expanded
const expand = ref(props.bags.map(() => false));

const sortedBags = computed(() => {
    if (props.bags) {
        // Create an array of indexes based on sorting `bags`
        const sortedIndexes = props.bags
            .map((bag, index) => ({ index, bag })) // Map each bag to its original index
            .sort((a, b) => b.bag.currencyPerBag - a.bag.currencyPerBag) // Sort by currencyPerBag
            .map(item => item.index); // Extract the sorted indexes
        
        // Sort `bags` based on the sorted indexes
        const sortedBags = sortedIndexes.map(index => props.bags[index]);
        
        // Sort `dropRates` to match the sorted order of `bags`
        const sortedDropRates = sortedIndexes.map(index => props.dropRates[index]);
        
        return {
            bags: sortedBags,
            dropRates: sortedDropRates
        };
    }
});

</script>
