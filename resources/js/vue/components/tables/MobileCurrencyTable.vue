<template>
    <div class="mobile-currency-container">
        <div v-for="(item, index) in sortedBags.bags" class="mobile-currency-card">
            <div class="label-and-cta">
                <div class="img-and-label">
                    <img v-if="item.icon" class="icon" :src="item.icon" :alt="item.name" :title="item.name">

                    <p class="item-name" :style="{color: showRarityColor(item.rarity)}">{{ item.name }}</p>
                </div>

                <!--
                    * 
                    * SVG CTAs
                    *
                -->
                <div class="svg-ctas">
                    <svg class="icon clickable" @click="wiki(item.name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                        <title>Wiki</title>
                    </svg>
                    <svg 
                        class="arrow" 
                        :class="activeArrow(expand[index])"
                        @click="expand[index] = !expand[index];" 
                        width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                        <title>Details</title>
                    </svg>
                </div>
                
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

                        <p>{{ item.costOfCurrencyPerBag }}</p>
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
import { activeArrow, wiki } from '@/js/vue/composables/BasicFunctions';

import PieChart from '@/js/vue/components/general/PieChart.vue'
import MobileDetailsTable from '@/js/vue/components/tables/MobileDetailsTable.vue'

const props = defineProps({
    targetCurrency: String,
    bags: Object, 
    dropRates: Object,
    currencyIcon: String, 
})

//console.log('drop rates: ', props.dropRates);

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
