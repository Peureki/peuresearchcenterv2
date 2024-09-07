<template>
    <div class="mobile-benchmark-details-container">
        <div class="mobile-info-container">
            <p>Sample size:</p>
            <p>{{ dropRates[0].sample_size }}</p>
        </div>
        <div v-for="item in sortedDropRates" class="mobile-drops-container">
            <div class="img-and-label">
                <!-- IF !CURRENCY -->
                <!-- <img v-if="item.icon && !item.currency_icon && !item.item_icon" class="icon" :src="item.icon" :alt="item.name" :title="item.name">
                <p v-if="item.name && !item.currency_name && !item.item_name" :style="{color: showRarityColor(item.rarity)}">{{ item.name }}</p> -->

                <!-- IF CURRENCY -->
                <img v-if="item.currency_icon" class="icon" :src="item.currency_icon" :alt="item.currency_name" :title="item.currency_name">
                <p v-if="item.currency_name" :style="{color: showRarityColor(item.rarity)}">{{ item.currency_name }}</p>

                <!-- IF BENCHMARKS ITEM_ICON -->
                <img v-if="item.item_icon" class="icon" :src="item.item_icon" :alt="item.item_name" :title="item.item_name">
                <p v-if="item.item_name" :style="{color: showRarityColor(item.rarity)}">{{ item.item_name }}</p>
            </div>

            <div class="drop-rate">
                <p>{{ formatPercentage(item.drop_rate) }}</p>
            </div>

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
import { formatValue, formatPercentage, showRarityColor, formatToDecimal } from '@/js/vue/composables/FormatFunctions.js'
import { computed } from 'vue';

const props = defineProps({
    dropRates: Object, 
})
// Sort drop rates by value
const sortedDropRates = computed(() => {
    return props.dropRates.sort((a, b) => b.value - a.value); 
})

console.log('airship drop rates: ', props.dropRates);

</script>