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

import CrystalOasisDesertFishGuide from '@/imgs/guides/fishing/Crystal_Oasis_Desert_Fish.webp'
import DreamFishGuide from '@/imgs/guides/fishing/Inner_Nayos_Dream_Fish.webp'
import DomainOfKournaDesertFishGuide from '@/imgs/guides/fishing/Domain_of_Kourna_Desert_Fish.webp'
import DWCLakeFishGuide from '@/imgs/guides/fishing/Drizzlewood_Coast_Lake_Fish.webp'
import EchovaldLakeFishGuide from '@/imgs/guides/fishing/Echovald_Wilds_Lake_Fish.webp'
import FrostgorgeBorealFishGuide from '@/imgs/guides/fishing/Frostgorge_Sound_Boreal_Fish.webp'
import InnerNayosNayosianFishGuide from '@/imgs/guides/fishing/Inner_Nayos_Nayosian_Fish.webp'
import LionsArchCoastalFishGuide from '@/imgs/guides/fishing/Lions_Arch_Coastal_Fish.webp'
import LowlandOffshoreFishGuide from '@/imgs/guides/fishing/Lowland_Shore_Offshore_Fish.webp'
import MountMaelstromSaltwaterFishGuide from '@/imgs/guides/fishing/Mount_Maelstrom_Saltwater_Fish.webp'
import NKCChannelFishGuide from '@/imgs/guides/fishing/New_Kaineng_City_Channel_Fish.webp'
import NKCCoastalFishGuide from '@/imgs/guides/fishing/New_Kaineng_City_Coastal_Fish.webp'
import RataSumSaltwaterFishGuide from '@/imgs/guides/fishing/Rata_Sum_Saltwater_Fish.webp'
import SandsweptIslesOffshoreFishGuide from '@/imgs/guides/fishing/Sandswept_Isles_Offshore_Fish.webp'
import SandsweptIslesShoreFishGuide from '@/imgs/guides/fishing/Sandswept_Isles_Shore_Fish.webp'
import SeitungOffshoreFishGuide from '@/imgs/guides/fishing/Seitung_Province_Offshore_Fish.webp'
import SeitungShoreFish from '@/imgs/guides/fishing/Seitung_Province_Shore_Fish.webp'
import StraitsOffshroeFish from '@/imgs/guides/fishing/Straits_of_Devestation_Offshore_Fish.webp'
import SnowdenDriftsLakeFishGuide from '@/imgs/guides/fishing/Snowden_Drifts_Lake_Fish.webp'
import ThunderheadBorealFishGuide from '@/imgs/guides/fishing/Thunderhead_Peaks_Boreal_Fish.webp'


const props = defineProps({
    fishingHole: Object,
})

// Switch map guide depending on the fishing farm
const mapGuide = computed(() => {
    switch (props.fishingHole.map){
        case 'Crystal Oasis':
            return CrystalOasisDesertFishGuide;

        case 'Domain of Kourna':
            return DomainOfKournaDesertFishGuide; 

        case "Drizzlewood Coast":
            return DWCLakeFishGuide;

        case "Echovald Wilds":
            return EchovaldLakeFishGuide;

        case "Frostgorge Sound":
            return FrostgorgeBorealFishGuide;

        case "Inner Nayos":
            if (props.fishingHole.name == 'Dream Fish'){
                return DreamFishGuide;
            }
            if (props.fishingHole.name == 'Nayosian Fish'){
                return InnerNayosNayosianFishGuide;
            }

        case "Lion's Arch":
            return LionsArchCoastalFishGuide;

        case "Lowland Shore":
            return LowlandOffshoreFishGuide;

        case "Mount Maelstrom":
            return MountMaelstromSaltwaterFishGuide;

        case "New Kaineng City":
            if (props.fishingHole.name == 'Channel Fish'){
                return NKCChannelFishGuide; 
            }
            if (props.fishingHole.name == 'Coastal Fish'){
                return NKCCoastalFishGuide; 
            }

        case "Rata Sum":
            return RataSumSaltwaterFishGuide;

        case "Seitung Province":
            if (props.fishingHole.name == 'Offshore Fish'){
                return SeitungOffshoreFishGuide;
            }
            if (props.fishingHole.name == 'Shore Fish'){
                return SeitungShoreFish;
            }

        case "Sandswept Isles":
            if (props.fishingHole.name == 'Offshore Fish'){
                return SandsweptIslesOffshoreFishGuide;
            }
            if (props.fishingHole.name == 'Shore Fish'){
                return SandsweptIslesShoreFishGuide;
            }
            

        case "Straits of Devestation":
            return StraitsOffshroeFish;

        case "Snowden Drifts":
            return SnowdenDriftsLakeFishGuide;

        case "Thunderhead Peaks":
            return ThunderheadBorealFishGuide;
    }
})

console.log('fishing hole: ', props.fishingHole);

</script>

<style scoped>


</style>