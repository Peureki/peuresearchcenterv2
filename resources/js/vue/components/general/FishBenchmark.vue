<template>
    <div class="fishing-hole-grid">
        <div
            class="fishing-hole-card"
            v-for="(fishingHole, index) in fishingHoles" :key="index"
        >
            <div class="card-container">
                <img class="legendary-fish" :src="fishingHole.mostValuedIcon" :alt="fishingHole.mostValuedItem" :title="fishingHole.mostValuedItem">
                <div class="fishing-hole-details">
                    <!--
                        *
                        * TITLE AND ESTIMATES
                        *
                    -->
                    <span class="fishing-title-and-estimate">
                        <p class="title" :class="changeTimeBackground(fishingHole.time)">{{ fishingHole.name }}</p>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(fishingHole.estimateValue)"
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
                        <p class="map-and-region">{{ fishingHole.map}}, {{ fishingHole.region }}</p>
                        <!--
                            *
                            * REQUIREMENTS
                            *
                        -->
                        <span class="requirements">
                            <img class="bait" :src="fishingHole.baitIcon" :alt="fishingHole.bait" :title="fishingHole.bait">
                            
                            <span class="fishing-power">
                                <img class="fishing-power-icon" :src="GreenHook" alt="Fishing Power" title="Fishing Power">
                                <p>{{ fishingHole.fishingPower }}</p>
                            </span>

                            <svg 
                                class="sun"
                                v-if="fishingHole.time == 'Daytime'"
                                width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M11.7188 3.90625V1.5625C11.7188 1.3553 11.8011 1.15659 11.9476 1.01007C12.0941 0.86356 12.2928 0.78125 12.5 0.78125C12.7072 0.78125 12.9059 0.86356 13.0524 1.01007C13.1989 1.15659 13.2812 1.3553 13.2812 1.5625V3.90625C13.2812 4.11345 13.1989 4.31216 13.0524 4.45868C12.9059 4.60519 12.7072 4.6875 12.5 4.6875C12.2928 4.6875 12.0941 4.60519 11.9476 4.45868C11.8011 4.31216 11.7188 4.11345 11.7188 3.90625ZM12.5 6.25C11.2639 6.25 10.0555 6.61656 9.02769 7.30331C7.99988 7.99007 7.1988 8.96619 6.72575 10.1082C6.25271 11.2503 6.12893 12.5069 6.37009 13.7193C6.61125 14.9317 7.2065 16.0453 8.08058 16.9194C8.95466 17.7935 10.0683 18.3888 11.2807 18.6299C12.4931 18.8711 13.7497 18.7473 14.8918 18.2742C16.0338 17.8012 17.0099 17.0001 17.6967 15.9723C18.3834 14.9445 18.75 13.7361 18.75 12.5C18.7482 10.843 18.0891 9.25429 16.9174 8.08258C15.7457 6.91087 14.157 6.25181 12.5 6.25ZM5.69727 6.80273C5.84386 6.94933 6.04268 7.03168 6.25 7.03168C6.45732 7.03168 6.65614 6.94933 6.80273 6.80273C6.94933 6.65614 7.03168 6.45732 7.03168 6.25C7.03168 6.04268 6.94933 5.84386 6.80273 5.69727L5.24023 4.13477C5.09364 3.98817 4.89482 3.90582 4.6875 3.90582C4.48018 3.90582 4.28136 3.98817 4.13477 4.13477C3.98817 4.28136 3.90582 4.48018 3.90582 4.6875C3.90582 4.89482 3.98817 5.09364 4.13477 5.24023L5.69727 6.80273ZM5.69727 18.1973L4.13477 19.7598C3.98817 19.9064 3.90582 20.1052 3.90582 20.3125C3.90582 20.5198 3.98817 20.7186 4.13477 20.8652C4.28136 21.0118 4.48018 21.0942 4.6875 21.0942C4.89482 21.0942 5.09364 21.0118 5.24023 20.8652L6.80273 19.3027C6.87532 19.2301 6.9329 19.144 6.97218 19.0491C7.01147 18.9543 7.03168 18.8527 7.03168 18.75C7.03168 18.6473 7.01147 18.5457 6.97218 18.4509C6.9329 18.356 6.87532 18.2699 6.80273 18.1973C6.73015 18.1247 6.64398 18.0671 6.54914 18.0278C6.4543 17.9885 6.35265 17.9683 6.25 17.9683C6.14735 17.9683 6.0457 17.9885 5.95086 18.0278C5.85602 18.0671 5.76985 18.1247 5.69727 18.1973ZM18.75 7.03125C18.8526 7.03133 18.9543 7.01119 19.0491 6.97198C19.1439 6.93277 19.2301 6.87526 19.3027 6.80273L20.8652 5.24023C21.0118 5.09364 21.0942 4.89482 21.0942 4.6875C21.0942 4.48018 21.0118 4.28136 20.8652 4.13477C20.7186 3.98817 20.5198 3.90582 20.3125 3.90582C20.1052 3.90582 19.9064 3.98817 19.7598 4.13477L18.1973 5.69727C18.0879 5.80653 18.0134 5.94579 17.9832 6.09742C17.953 6.24905 17.9685 6.40622 18.0276 6.54906C18.0868 6.69189 18.187 6.81394 18.3156 6.89978C18.4442 6.98562 18.5954 7.03137 18.75 7.03125ZM19.3027 18.1973C19.1561 18.0507 18.9573 17.9683 18.75 17.9683C18.5427 17.9683 18.3439 18.0507 18.1973 18.1973C18.0507 18.3439 17.9683 18.5427 17.9683 18.75C17.9683 18.9573 18.0507 19.1561 18.1973 19.3027L19.7598 20.8652C19.8324 20.9378 19.9185 20.9954 20.0134 21.0347C20.1082 21.074 20.2098 21.0942 20.3125 21.0942C20.4152 21.0942 20.5168 21.074 20.6116 21.0347C20.7065 20.9954 20.7926 20.9378 20.8652 20.8652C20.9378 20.7926 20.9954 20.7065 21.0347 20.6116C21.074 20.5168 21.0942 20.4152 21.0942 20.3125C21.0942 20.2098 21.074 20.1082 21.0347 20.0134C20.9954 19.9185 20.9378 19.8324 20.8652 19.7598L19.3027 18.1973ZM4.6875 12.5C4.6875 12.2928 4.60519 12.0941 4.45868 11.9476C4.31216 11.8011 4.11345 11.7188 3.90625 11.7188H1.5625C1.3553 11.7188 1.15659 11.8011 1.01007 11.9476C0.86356 12.0941 0.78125 12.2928 0.78125 12.5C0.78125 12.7072 0.86356 12.9059 1.01007 13.0524C1.15659 13.1989 1.3553 13.2812 1.5625 13.2812H3.90625C4.11345 13.2812 4.31216 13.1989 4.45868 13.0524C4.60519 12.9059 4.6875 12.7072 4.6875 12.5ZM12.5 20.3125C12.2928 20.3125 12.0941 20.3948 11.9476 20.5413C11.8011 20.6878 11.7188 20.8865 11.7188 21.0938V23.4375C11.7188 23.6447 11.8011 23.8434 11.9476 23.9899C12.0941 24.1364 12.2928 24.2188 12.5 24.2188C12.7072 24.2188 12.9059 24.1364 13.0524 23.9899C13.1989 23.8434 13.2812 23.6447 13.2812 23.4375V21.0938C13.2812 20.8865 13.1989 20.6878 13.0524 20.5413C12.9059 20.3948 12.7072 20.3125 12.5 20.3125ZM23.4375 11.7188H21.0938C20.8865 11.7188 20.6878 11.8011 20.5413 11.9476C20.3948 12.0941 20.3125 12.2928 20.3125 12.5C20.3125 12.7072 20.3948 12.9059 20.5413 13.0524C20.6878 13.1989 20.8865 13.2812 21.0938 13.2812H23.4375C23.6447 13.2812 23.8434 13.1989 23.9899 13.0524C24.1364 12.9059 24.2188 12.7072 24.2188 12.5C24.2188 12.2928 24.1364 12.0941 23.9899 11.9476C23.8434 11.8011 23.6447 11.7188 23.4375 11.7188Z" fill="#FFFFFF"/>
                            </svg>

                            <svg 
                                class="moon"
                                v-else
                                width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M5.67754 4.45195C5.67754 3.16289 5.86699 1.86016 6.35059 0.75C3.13535 2.14961 0.96582 5.4332 0.96582 9.16328C0.96582 14.1816 5.03418 18.25 10.0525 18.25C13.7826 18.25 17.0662 16.0805 18.4658 12.8652C17.3557 13.3488 16.0518 13.5383 14.7639 13.5383C9.74551 13.5383 5.67754 9.47031 5.67754 4.45195Z" fill="#FFFFFF"/>
                            </svg>

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
                    <FishProofs
                        :fishing-hole="fishingHole"
                    />
                </div>
                
                <div>
                    <FishTable
                        :fishing-hole="fishingHole"
                        :drop-rates="dropRates[index]"
                    />
                </div>
                
            </div>
        </div>
    </div>

    

    
</template>

<script setup>
import { ref } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

import FishTable from '@/js/vue/components/tables/FishTable.vue'
import FishProofs from '@/js/vue/components/general/FishProofs.vue'
import PieChart from '@/js/vue/components/general/PieChart.vue'

import GreenHook from '@/imgs/icons/fishes/Green_Hook.png'
import MaddenedMackerel from '@/imgs/icons/fishes/Unholy_Mackerel.png'
import SwordFish from '@/imgs/icons/fishes/Swordfish.png'
import Kaluga from '@/imgs/icons/fishes/Kaluga.png'
import GoliathGrouper from '@/imgs/icons/fishes/Goliath_Grouper.png'
import GlacialSnakehead from '@/imgs/icons/fishes/Glacial_Snakehead.png'
import AlabasterOscar from '@/imgs/icons/fishes/Alabaster_Oscar.png'
import ShipwreckMoray from '@/imgs/icons/fishes/Shipwreck_Moray.png'

const props = defineProps({
    fishingHoles: Object,
    dropRates: Object,
})

const expand = ref(props.fishingHoles.map(() => false));



// Depending on if the farm is daytime or nighttime, change the background of the card
const changeTimeBackground = (time) => {
    return {
        day: time === 'Daytime',
        night: time !== 'Daytime',
    }
}


</script>

<style scoped>
.fishing-hole-grid{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: 10px;
}
.fishing-hole-card{
    display: flex;
    flex-wrap: wrap;
    border: 1px solid #686868;
    padding: var(--padding-benchmark-container);
    border-radius: 5px;
    background-color: var(--color-bkg-fade);
    gap: 50px;
    transition: var(--transition-all-03s-ease);
}
.card-container{
    display: flex;
    gap: var(--gap-general);
    width: 100%;
}
.fishing-hole-card:hover{
    border: 1px solid var(--color-link);
}
.fishing-hole-card:hover svg.arrow,
.fishing-hole-card:focus svg.arrow{
    transform: rotate(45deg);
}
img.legendary-fish{
    height: 50px;
}
.fishing-hole-details{
    display: flex;
    width: 100%;
    flex-direction: column;
    justify-content: space-between;
}
.fishing-title-and-estimate{
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    gap: 10px;
}
img.bait{
    width: 20px;
    height: 20px;
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
.day{
    color: var(--color-rarity-exotic);
}
.night{
    color: var(--color-rarity-legendary);
}

</style>