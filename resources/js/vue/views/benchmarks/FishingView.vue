<template>
    <Nav/>
    <Header page-name="Fishing Benchmarks"/>

    <section>
        <div class="fishing-holes-grid">
            <div 
                class="fishing-holes-container"
                v-for="(fishingHole, index) in fishingHoles" :key="index"
            >
                <img :src="MaddenedMackerel">
                <div class="fishing-hole-details">
                    <span class="fishing-title-and-estimate">
                        <p class="title">{{ fishingHole.map }}</p>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(fishingHole.estimateValue)"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                            </span>
                        </span>
                    </span>
                    <span class="fishing-map-and-requirements">
                        <p class="map-and-region">{{ fishingHole.map}}, {{ fishingHole.region }}</p>
                        <span class="requirements">
                            
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import MaddenedMackerel from '@/imgs/icons/fishes/Unholy_Mackerel.png'

const fishingHoles = ref([]); 

const getFishes = async () => {
    const response = await fetch(`../api/benchmarks/fishing/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`);
    const responseData = await response.json(); 
    
    fishingHoles.value = responseData.fishingHoles; 
    console.log(fishingHoles.value);
}

getFishes();

</script>