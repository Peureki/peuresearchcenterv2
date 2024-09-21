<template>
    <div class="proof-container">
        <!-- 
            *
            * PIE CHART STATS
            *
        -->
        <div class="proof-box">
            <span class="proof">
                <p>Value per catch: </p>
                <span class="gold-label-container">
                    <span class="gold-label" v-for="gold in formatValue(fishingHole.catchValue)">
                        {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.alt">
                    </span>
                </span>
            </span>

            <span class="proof">
                <p>Average fishing holes in route: </p>
                <p>{{ Number(fishingHole.avgHoles) }}</p>
            </span>

            <span class="proof">
                <p>Average time to cycle route: </p>
                <p>{{ formatToMinutes(fishingHole.timeVariable) }}</p>
            </span>
        </div>
        <!-- 
            *
            * FORMULA
            *
        -->
        <span class="written-calculations">
            <p>Estimated gold per hour:</p>
            <p>((catchValue * avgHoles) * 3) * (60 / avgTime)</p>
        </span>

        <!-- 
            *
            * MAP GUIDE
            *
        -->
        <div class="map-guide-container">
            <img class="map-guide" :src="mapGuide" :alt="`${fishingHole.map} Fishing Guide`" :title="`${fishingHole.map} Fishing Guide`">
        </div>
        
        
    </div>
</template>

<script setup>
import { formatValue, formatPercentage, showRarityColor, formatToMinutes } from '@/js/vue/composables/FormatFunctions.js'
import { computed } from 'vue';

import DreamFishGuide from '@/imgs/guides/fishing/Inner_Nayos_Dream_Fish.webp'
import DWCLakeFishGuide from '@/imgs/guides/fishing/Drizzlewood_Coast_Lake_Fish.webp'
import EchovaldLakeFishGuide from '@/imgs/guides/fishing/Echovald_Wilds_Lake_Fish.webp'
import InnerNayosNayosianFishGuide from '@/imgs/guides/fishing/Inner_Nayos_Nayosian_Fish.webp'
import LionsArchCoastalFishGuide from '@/imgs/guides/fishing/Lions_Arch_Coastal_Fish.webp'
import NKCChannelFishGuide from '@/imgs/guides/fishing/New_Kaineng_City_Channel_Fish.webp'
import NKCCoastalFishGuide from '@/imgs/guides/fishing/New_Kaineng_City_Coastal_Fish.webp'
import SeitungShoreFish from '@/imgs/guides/fishing/Seitung_Province_Shore_Fish.webp'
import ThunderheadBorealFishGuide from '@/imgs/guides/fishing/Thunderhead_Peaks_Boreal_Fish.webp'


const props = defineProps({
    fishingHole: Object,
})

// Switch map guide depending on the fishing farm
const mapGuide = computed(() => {
    switch (props.fishingHole.map){
        case "Drizzlewood Coast":
            return DWCLakeFishGuide;

        case "Echovald Wilds":
            return EchovaldLakeFishGuide;

        case "Inner Nayos":
            if (props.fishingHole.name == 'Dream Fish'){
                return DreamFishGuide;
            }
            if (props.fishingHole.name == 'Nayosian Fish'){
                return InnerNayosNayosianFishGuide;
            }

        case "Lion's Arch":
            return LionsArchCoastalFishGuide;

        case "New Kaineng City":
            if (props.fishingHole.name == 'Channel Fish'){
                return NKCChannelFishGuide; 
            }
            if (props.fishingHole.name == 'Coastal Fish'){
                return NKCCoastalFishGuide; 
            }

        case "Seitung Province":
            if (props.fishingHole.name == 'Shore Fish'){
                return SeitungShoreFish;
            }

        case "Thunderhead Peaks":
            return ThunderheadBorealFishGuide;
    }
})

console.log('fishing hole: ', props.fishingHole);

</script>

<style scoped>


</style>