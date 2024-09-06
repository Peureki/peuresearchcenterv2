<template>
    <div class="mobile-currency-container">
        <div v-for="item in sortedBag" class="mobile-currency-card">
            <div class="label-and-cta">
                <div class="img-and-label">
                    <img class="icon" :src="item.icon" :alt="item.name" :title="item.name">

                    <p class="item-name" :style="{color: showRarityColor(item.rarity)}">{{ item.name }}</p>
                </div>

                <svg class="arrow" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                
            
        </div>
    </div>
        
</template>

<script setup>
import { computed } from 'vue';
import { showRarityColor, formatValue } from '@/js/vue/composables/FormatFunctions';

const props = defineProps({
    targetCurrency: String,
    bags: Object, 
    currencyIcon: String, 
})

const sortedBag = computed(() => {
    if (props.bags){
        return props.bags.sort((a, b) => b.currencyPerBag - a.currencyPerBag);
    }
})

</script>
