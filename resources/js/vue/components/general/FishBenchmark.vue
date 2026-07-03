<template>
    <div class="card-grid">
        <div class="card-container"
            :style="{border: dailyBorderColor(fishingHole)}"
            v-for="(fishingHole, index) in fishingHoles" :key="index"
        >
            <p class="rank">{{ index + 1 }}</p>
            <img v-if="fishingHole.best" :src="GoldChoya" alt="Recommended Farm!" title="Recommended Farm!" class="gold-choya">
            <div class="card">
                <img class="card-main-icon" :src="fishingHole.mostValuedIcon" :alt="fishingHole.mostValuedItem" :title="fishingHole.mostValuedItem">
                <div class="card-details">
                    <!--
                        *
                        * TITLE AND ESTIMATES
                        *
                    -->
                    <span class="card-title-and-value">
                        <span class="title-container">
                            <p class="title" :class="changeTimeBackground(fishingHole.time)">{{ fishingHole.name }}</p>
                            <!--
                                *
                                * SVG SIGNAL
                                *
                            -->
                            <svg 
                                class="signal" 
                                :class="matchTyrianTime(fishingHole.time, fishingHole.region)"
                                width="30" height="30" xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle class="fill-circle" cx="15" cy="15" r="5" stroke="black" stroke-width="1" />
                                <circle class="expand-circle" cx="15" cy="15" r="15"  fill="transparent" stroke-width="1"/>
                                <title>{{ matchTyrianTime(fishingHole.time, fishingHole.region) }}</title>
                            </svg>
                            <!--
                                *
                                * DAILY FISH MESSAGE
                                * Show "Daily Ambergris Catch" if the daily matches
                                *
                            -->
                            <p v-if="matchDailyCatch(fishingHole)" class="small-subtitle">{{ matchDailyCatch(fishingHole).daily }}</p>
                        </span>
                        <!--
                            *
                            * Show Benchmark value
                            *
                        -->
                        <span class="flex-row">
                            <span class="difficulty-container">
                                <svg width="10" height="10" viewBox="0 0 10 10" aria-hidden="true">
                                    <title>{{ fishingHole.difficulty }}</title>
                                    <circle cx="5" cy="5" r="5" :fill="farmDifficulty(fishingHole, 0)"/>
                                </svg>
                                <svg width="10" height="10" viewBox="0 0 10 10" aria-hidden="true">
                                    <title>{{ fishingHole.difficulty }}</title>
                                    <circle cx="5" cy="5" r="5" :fill="farmDifficulty(fishingHole, 1)"/>
                                </svg>
                                <svg width="10" height="10" viewBox="0 0 10 10" aria-hidden="true">
                                    <title>{{ fishingHole.difficulty }}</title>
                                    <circle cx="5" cy="5" r="5" :fill="farmDifficulty(fishingHole , 2)"/>
                                </svg>
                            </span>

                            <span class="gold-label-container benchmark-value">
                                <span 
                                    class="gold-label"
                                    v-for="gold in formatValue(fishingHole.estimateValue)"
                                >
                                    {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                </span>
                            </span>
                        </span>
                        
                    </span>
                    <!--
                        *
                        * MAP AND card-info-container
                        *
                    -->
                    <span class="card-map-and-info">
                        <p class="small-subtitle">{{ fishingHole.map}}, {{ fishingHole.region }}</p>

                        <!--
                            *
                            * card-info-container
                            *
                        -->
                        <span class="card-info-container">
                            <!--
                                *
                                * BAIT icons
                                * Alter bait icons if it's Desert Fish or an "any" bait farm
                                *
                            -->
                            <span class="flex-row">
                                <img class="bait" :src="fishingHole.baitIcon" :alt="fishingHole.bait" :title="fishingHole.bait">

                                <p v-if="fishingHole.bait == 'Mackerel' && fishingHole.region == 'Horn of Maguuma'" class="small-subtitle">or any</p>

                                <span v-else-if="fishingHole.bait == 'Mackerel' && fishingHole.region == 'Crystal Desert'" class="flex-row">
                                    <p class="small-subtitle">or</p>
                                    <img  class="bait" :src="Scorpion" alt="Scorpions" title="Scoprions">
                                </span>
                                
                            </span>
                            
                            <!-- 
                                *
                                * Fishing Power
                                *
                            -->
                            <span class="fishing-power">
                                <img class="card-currency" :src="GreenHook" alt="Fishing Power" title="Fishing Power">
                                <p class="small-subtitle">{{ fishingHole.fishingPower }}</p>
                            </span>

                            <svg 
                                class="arrow"
                                @click="expand[index] = !expand[index]"
                                :class="activeArrow(expand[index])"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-text)"/>
                            </svg>
                        </span>
                        
                    </span>
                </div>
            </div>

            <div 
                v-if="expand[index]"
                class="details-container"
            >
                <MobileDetailsTable
                    :drop-rates="dropRates[index]"
                />
                <div class="details">
                    <PieChart
                        :drop-rates="dropRates[index]"
                    />

                    <FishProofs
                        :fishing-hole="fishingHole"
                    />

                    <!--
                        * AMNYTAS, ASTRAL FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Amnytas'">
                        <p>This will not complete a full hours worth of fishing in the same way that you can continously go from pool to pool non-stop. This has a high ascended rate of fish so I wanted to put this benchmark to see where it would be. If you follow all the directions below, you will get a decent ~25 minute run, but then there will be a pause.</p>
                    </Disclaimer>
                    <AmnytasAstralFish v-if="fishingHole.map == 'Amnytas'"/>

                    <!-- 
                        * BLOODTIDE COAST, COASTAL FISH
                    -->
                    <BloodtideCoast v-if="fishingHole.map == 'Bloodtide Coast'"/>

                    <!--
                        * CALEDON FOREST, SALTWATER FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Caledon Forest'">
                        <p>This is probably my least favorite route ever. There are multiple mobs that will pull you off your skiff and put you in combat and may make you lose your stacks.</p>
                    </Disclaimer>
                    <CaledonForest v-if="fishingHole.map == 'Caledon Forest'"/>

                    <!--
                        * CRYSTAL OASIS, DESERT FISH
                    -->
                    <CrystalOasis v-if="fishingHole.map == 'Crystal Oasis'"/>

                    <!--
                        * DRACONIS MONS, VOLCANIC FISH
                    -->
                    <DraconisMons v-if="fishingHole.map == 'Draconis Mons'"/>

                    <!--
                        * DOMAIN OF ISTAN, OFFSHORE FISH
                    -->
                    <DomainOfIstan v-if="fishingHole.map == 'Domain of Istan'"/>

                    <!--
                        * DOMAIN OF KOURNA, DESERT FISH
                    -->
                    <DomainOfKourna v-if="fishingHole.map == 'Domain of Kourna'"/>

                    <!--
                        * DRAGON'S END, CAVERN FISH
                    -->
                    <DragonsEndCavernFish
                        v-if="
                            fishingHole.name == 'Cavern Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Dragon\'s End'" 
                    />

                    <!--
                        * DRAGON'S END, QUARRY FISH
                    -->
                    <Disclaimer
                        v-if="
                            fishingHole.name == 'Quarry Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Dragon\'s End'" 
                    >
                        <p>There are so many mobs that may attack you in this route that it's not worth farming.</p>
                    </Disclaimer>
                    <DragonsEndQuarryFish
                        v-if="
                            fishingHole.name == 'Quarry Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Dragon\'s End'" 
                    />

                    <!--
                        * DRIZZLEWOOD COAST, LAKE FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Drizzlewood Coast'" type="caution">
                        <p>This is a very unique farm where you can push over 1000 Fishing Power. 925 is from the normal maxing of getting Fishing Power while the additional 92 comes from <a href="https://wiki.guildwars2.com/wiki/Raise_Morale" target="_blank">Raise Morale</a> from the Quartermaster. The south camps need to be completed in order to achieve the maximum morale boost. From my experience, lots of Drizzlewood maps are left abondoned with the south portion completed and north not progressing, which is the perfect opportunity to do this farm.</p>
                    </Disclaimer>
                    <DrizzlewoodCoast
                        v-if="
                            fishingHole.name == 'Lake Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Drizzlewood Coast'" 
                    />

                    <!--
                        * ECHOVALD WILDS, LAKE FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Echovald Wilds'">
                        <p>There is a chance that Qinkai Waypoint may be locked. This happens if the event chain from Jade Gate Waypoint (will have a tangerine symbol if not started) is progressing. The waypoint can be unlocked by completing the event when it reaches Qinkai.</p>
                    </Disclaimer>
                    <EchovaldLakeFish v-if="fishingHole.map == 'Echovald Wilds'"/>

                    <!--
                        * ELON RIVERLANDS, DESERT FISH
                    -->
                    <Disclaimer
                        v-if="
                            fishingHole.name == 'Desert Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Elon Riverlands'" 
                        message="There are many mobs on the south portion of this farm. You can avoid them by fishing at the highest point of your skiff (usually on the tail end)."
                        type="caution"
                    />
                    <ElonRiverlands
                        v-if="
                            fishingHole.name == 'Desert Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Elon Riverlands'" 
                    />

                    <!--
                        * ETERNITY'S GARDEN, FRESHWATER TROPICAL FISH
                    -->
                    <Disclaimer 
                        v-if="fishingHole.map == 'Eternity\'s Garden'" 
                        type="caution"
                    >
                        <p>There are about 2-3 pools that could potentially have a mob attacking you. Their aggro range is pretty far</p>
                    </Disclaimer>

                    <Disclaimer 
                        v-if="fishingHole.map == 'Eternity\'s Garden'" 
                        type="caution"
                    >
                        <p>Not really a warning, but this is the probably the BEST farm if you are really seeking the SEA-LIFE INFUSION</p>
                    </Disclaimer>
                    <EternitysGarden
                        v-if="fishingHole.map == 'Eternity\'s Garden'"
                    />
                    


                    <!-- 
                        * FROSTGORGE SOUND, BOREAL FISH 
                    -->
                    <FrostgorgeSound v-if="fishingHole.map == 'Frostgorge Sound'"/>

                    <!--
                        * GENDARREN FIELDS, RIVER FISH
                    -->
                    <GendarrenFieldsRiverFish v-if="fishingHole.map == 'Gendarran Fields'"/>

                    <!--
                        * HOMESTEADS, FRESHWATER FISH
                    -->
                    <Homestead v-if="fishingHole.map == 'Homestead'"/>

                    <!--
                        * INNER NAYOS
                    -->
                    <Disclaimer 
                        v-if="fishingHole.map == 'Inner Nayos'" 
                        type="caution"
                    >
                        <p>While this benchmark is based on Mackerels for the sake of getting the best possible chances, this farm is totally acceptable of using ANY other bait with 875 or 925 Fishing Power.</p>
                    </Disclaimer>
                    <InnerNayosDreamFish v-if="fishingHole.name == 'Dream Fish'"/>
                    <InnerNayosNayosianFish v-if="fishingHole.name == 'Nayosian Fish'"/>
                    

                    <!--
                        * LAKE FISH, DRIZZLEWOOD 
                    -->

                    <!--
                        * LOWLAND SHORE, BRACKISH FISH
                    -->
                    <LowlandShoreBrackishFish
                        v-if="
                            fishingHole.name == 'Lowland Brackish Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Lowland Shore'"
                    />

                    <!--
                        * LOWLAND SHORE, OFFSHORE FISH
                    -->
                    <LowlandShoreOffshoreFish
                        v-if="
                            fishingHole.name == 'Lowland Offshore Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Lowland Shore'"
                    />

                    

                    <!--
                        * LION'S ARCH
                    -->
                    <LionsArch v-if="fishingHole.map == 'Lion\'s Arch'"/>

                    <!--
                        * MOUNT MAELSTROM, SALTWATER FISH
                    -->
                    <MountMaelstrom v-if="fishingHole.map == 'Mount Maelstrom'"/>

                    <!--
                        * NEW KAINENG CITY
                    -->
                    <Disclaimer 
                        v-if="
                            fishingHole.name == 'Channel Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime') 
                            && fishingHole.map == 'New Kaineng City'"
                        type="caution"
                    >
                        <p>There may be an annoying event that spawns in the middle of the route there snipers can shoot you. Try your best to get out of sight.</p>
                    </Disclaimer>
                    <NewKainengCityChannelFish
                        v-if="
                            fishingHole.name == 'Channel Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime') 
                            && fishingHole.map == 'New Kaineng City'"
                    />
                    <NewKainengCityCoastalFish
                        v-if="
                            fishingHole.name == 'Coastal Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'New Kaineng City'" 
                    />

                    <!--
                        * RATA SUM, SALTWATER FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Rata Sum'" type="caution">
                        <p>Because this is a Saltwater pool, it has a much higher chance to obtain Saltwater Fish to complete the <a href="https://wiki.guildwars2.com/wiki/Saltwater_Fisher" target="_blank">Saltwater Fisher achievement and avid</a>. If you do this farm regularly, it's common to continuously complete the avid. I've had sessions where I completed it in less than an hour from start to finish or within 2 hours. The benchmark currently does not include Avid loot.</p>
                    </Disclaimer>
                    <RataSum v-if="fishingHole.map == 'Rata Sum'"/>

                    <!--
                        * SANDSWEPT ISLES, OFFSHORE FISH
                    -->
                    <SandsweptIslesOffshoreFish
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Sandswept Isles'"
                    />

                    <!--
                        * SANDSWEPT ISLES, SHORE FISH
                    -->
                    <SandsweptIslesShoreFish
                        v-if="
                            fishingHole.name == 'Shore Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Sandswept Isles'" 
                    />

                    <!--
                        * SIREN'S LANDING, SHORE FISH
                    -->
                    <SirensLanding v-if="fishingHole.map == 'Siren\'s Landing'"/>

                    <!--
                        * STRAITS OF DEVESTATION, OFFSHORE FISH
                    -->
                    <StraitsOfDevestationOffshoreFish 
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && (fishingHole.time == 'Nighttime' || fishingHole.time == 'Daytime') 
                            && fishingHole.map == 'Straits of Devestation'" 
                    />

                    <!--
                        * SEITUNG, OFFSHORE FISH
                    -->
                    <Disclaimer 
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime')
                            && fishingHole.map == 'Seitung Province'" 
                        type="caution"
                    >
                        <p>Sometimes a Levi will trigger and it will be in parts of the route. Tag if you wish, but careful of the Naga that spawns. If that's the case, I'd tag and leave or keep your skiff afloat and kill. If your skiff disappears though, you will risk losing your stacks.</p>
                    </Disclaimer>
                    <SeitungOffshoreFish
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime')
                            && fishingHole.map == 'Seitung Province'" 
                    />

                    <!--
                        * SEITUNG, SHORE FISH
                    -->
                    <SeitungShoreFish
                        v-if="
                            fishingHole.name == 'Shore Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Seitung Province'" 
                    />

                    <!--
                        * SKYWATCH, FRESHWATER
                    -->
                    <SkywatchArchipelago v-if="fishingHole.map == 'Skywatch Archipelago'"/>

                    <!--
                        * SNOWDEN DRIFTS, LAKE FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Snowden Drifts'" type="caution">
                        <p>Sometimes there's an event that spawns underwater from the first waypoint. If that's the case, try to position your skiff as far as possible</p>
                    </Disclaimer>
                    <SnowdenDrifts v-if="fishingHole.map == 'Snowden Drifts'" />

                    <!--
                        * SPARKFLY FEN, SALTWATER FISH
                    -->
                    <SparkflyFen v-if="fishingHole.map == 'Sparkfly Fen'"/>

                    <!--
                        * THUNDERHEAD, BOREAL FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Thunderhead Peaks'" type="caution">
                        <p>To avoid the Dredge, park your skiff as far away from the ice as you can.</p>
                    </Disclaimer>
                    <Thunderhead v-if="fishingHole.map == 'Thunderhead Peaks'"/>
                    
                </div>
                
            </div>
        </div> 
    </div>

    

    
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { activeArrow } from '@/js/vue/composables/BasicFunctions'

import FishTable from '@/js/vue/components/tables/FishTable.vue'
import FishProofs from '@/js/vue/components/general/FishProofs.vue'
import PieChart from '@/js/vue/components/general/PieChart.vue'
import MobileBenchmarkTable from '@/js/vue/components/tables/MobileBenchmarkTable.vue'
import MobileDetailsTable from '@/js/vue/components/tables/MobileDetailsTable.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

import { tyrianCurrentPeriod, canthanCurrentPeriod, isMobile } from '@/js/vue/composables/Global.js'

import GreenHook from '@/imgs/icons/fishes/Green_Hook.png'
import GoldChoya from '@/imgs/choyas/Gold_Choya.png'

// SPECIFIC BAIT ICONS
import Scorpion from '@/imgs/icons/Scorpion.png'

// MAP GUIDES
import AmnytasAstralFish from '@/js/vue/components/guides/fishing/AmnytasAstralFish.vue'
import BloodtideCoast from '@/js/vue/components/guides/fishing/BloodtideCoast.vue'
import CaledonForest from '@/js/vue/components/guides/fishing/CaledonForest.vue'
import CrystalOasis from '@/js/vue/components/guides/fishing/CrystalOasis.vue'
import DomainOfIstan from '@/js/vue/components/guides/fishing/DomainOfIstan.vue'
import DomainOfKourna from '@/js/vue/components/guides/fishing/DomainOfKourna.vue'
import DraconisMons from '@/js/vue/components/guides/fishing/DraconisMons.vue'
import DragonsEndCavernFish from '@/js/vue/components/guides/fishing/DragonsEndCavernFish.vue'
import DragonsEndQuarryFish from '@/js/vue/components/guides/fishing/DragonsEndQuarryFish.vue'
import DrizzlewoodCoast from '@/js/vue/components/guides/fishing/DrizzlewoodCoast.vue'
import EchovaldLakeFish from '@/js/vue/components/guides/fishing/EchovaldLakeFish.vue'
import ElonRiverlands from '@/js/vue/components/guides/fishing/ElonRiverlands.vue'
import FrostgorgeSound from '@/js/vue/components/guides/fishing/FrostgorgeSound.vue'
import GendarrenFieldsRiverFish from '@/js/vue/components/guides/fishing/GendarrenFieldsRiverFish.vue'
import Homestead from '@/js/vue/components/guides/fishing/Homestead.vue'
import InnerNayosDreamFish from '@/js/vue/components/guides/fishing/InnerNayosDreamFish.vue'
import InnerNayosNayosianFish from '@/js/vue/components/guides/fishing/InnerNayosNayosianFish.vue'
import LionsArch from '@/js/vue/components/guides/fishing/LionsArch.vue'
import LowlandShoreBrackishFish from '@/js/vue/components/guides/fishing/LowlandShoreBrackishFish.vue'
import LowlandShoreOffshoreFish from '@/js/vue/components/guides/fishing/LowlandShoreOffshoreFish.vue'
import MountMaelstrom from '@/js/vue/components/guides/fishing/MountMaelstrom.vue'
import NewKainengCityChannelFish from '@/js/vue/components/guides/fishing/NewKainengCityChannelFish.vue'
import NewKainengCityCoastalFish from '@/js/vue/components/guides/fishing/NewKainengCityCoastalFish.vue'
import RataSum from '@/js/vue/components/guides/fishing/RataSum.vue'
import SandsweptIslesOffshoreFish from '@/js/vue/components/guides/fishing/SandsweptIslesOffshoreFish.vue'
import SandsweptIslesShoreFish from '@/js/vue/components/guides/fishing/SandsweptIslesShoreFish.vue'
import SirensLanding from '@/js/vue/components/guides/fishing/SirensLanding.vue'
import StraitsOfDevestationOffshoreFish from '@/js/vue/components/guides/fishing/StraitsOfDevestationOffshoreFish.vue'
import SeitungOffshoreFish from '@/js/vue/components/guides/fishing/SeitungOffshoreFish.vue'
import SeitungShoreFish from '@/js/vue/components/guides/fishing/SeitungShoreFish.vue'
import SkywatchArchipelago from '@/js/vue/components/guides/fishing/SkywatchArchipelago.vue'
import SnowdenDrifts from '@/js/vue/components/guides/fishing/SnowdenDrifts.vue'
import SparkflyFen from '@/js/vue/components/guides/fishing/SparkflyFen.vue'
import Thunderhead from '@/js/vue/components/guides/fishing/Thunderhead.vue'
import EternitysGarden from '../guides/fishing/EternitysGarden.vue'


const props = defineProps({
    dailyCatch: Object,
    fishingHoles: Object,
    dropRates: Object,
})

// Individually allow each card to be expanded or not
// By default, have each card not expanded
const expand = ref(props.fishingHoles.map(() => false));
//console.log('drop rates: ', props.dropRates)

// Change the color of the farm difficulty circles depending on difficulty
const farmDifficulty = (fishingHole, orderOfCircle) => {
    if (fishingHole.difficulty == 'Easy'){
        if (orderOfCircle == 0) 
            return 'var(--color-fishing-difficulty-easy)'
    } 
    else if (fishingHole.difficulty == 'Medium'){
        if (orderOfCircle <= 1)
            return 'var(--color-fishing-difficulty-medium)'
    }
    else if (fishingHole.difficulty == 'Hard'){
        if (orderOfCircle <= 2)
            return 'var(--color-fishing-difficulty-hard)'
    }
    return 'var(--color-fishing-difficulty-default)';
}

const matchDailyCatch = (benchmark) => {
    const checkFishMatch = (fish, benchmark) => {
        // Fish for specifically Brackish & Offshore Fish
        const fish_b_o = ['King Salmon', 'Viperfish', 'Violet Screamer', 'Spectacled Lumper', 'Shaderock Salamander', 'Mohawk Bream'];
        const benchmark_b_o = ['Lowland Brackish Fish', 'Lowland Offshore Fish'];

        // Fish for specifically just Brackish Fish
        const fish_b = ['Cherry Salmon', 'Sockeye'];
        const benchmark_b = ['Lowland Brackish Fish'];

        console.log('fish: ', fish, '| benchmark: ', benchmark.name);

        // Check all possible areas where daily fish is the daily
        if (
            (fish.map === benchmark.region && benchmark.name.includes(fish.fishing_hole)) ||
            (fish_b_o.includes(fish.name) && benchmark_b_o.includes(benchmark.name)) ||
            (fish_b.includes(fish.name) && benchmark_b.includes(benchmark.name)) || 
            // // For special cases such as Maguuma Jungle, Freshwater with Homesteads and SOTO freshwaters
            (fish.map === 'Maguuma Jungle' && fish.fishing_hole == 'Freshwater Fish' && benchmark.name.includes('Freshwater Fish'))
        ){
            if (fish.rarity == 'Masterwork'){
                return {
                    daily: 'Daily Flawless Catch',
                    color: 'var(--color-rarity-masterwork)'
                }
            }
            // Sometimes the daily fish for Janthir are exotic
            if (fish.rarity == 'Rare' || fish.rarity == 'Exotic'){
                return {
                    daily: 'Daily Ambergris Catch',
                    color: 'var(--color-rarity-rare)'
                }
            }
        } 
        else {
            return false; 
        }
    };

    const { arborstone, janthir } = props.dailyCatch;

    // Check for Arborstone fish match
    if (arborstone?.count) {
        const result = checkFishMatch(arborstone.fish, benchmark);
        if (result) return result; 
    }

    // Check for Janthir fish match
    if (janthir?.count) {
        const result = checkFishMatch(janthir.fish, benchmark);
        if (result) return result;
    }

    return false;
};

const dailyBorderColor = (fishingHole) => {
    return matchDailyCatch(fishingHole)?.color ? `1px solid ${matchDailyCatch(fishingHole).color}` : ``;
}

// Depending on if the farm is daytime or nighttime, change the background of the card
const changeTimeBackground = (time) => {
    return {
        day: time === 'Daytime',
        night: time === 'Nighttime',
        any: time === 'Anytime',
    }
}
// Reactively change the color of the 'active' and 'inactive' circle depending on what the time is
// const matchTyrianTime = (benchmarkTime) => {
//     return computed(() => tyrianCurrentPeriod.value === benchmarkTime ? 'var(--color-up)' : 'var(--color-down)').value; 
// }

const matchTyrianTime = (benchmarkTime, region) => {
    return computed(() => {
        // If fishing benchmark is CANTHAN
        if (region === 'Seitung Province' || 
            region === 'New Kaineng City' || 
            region === 'Echovald Wilds' || 
            region === "Dragon's End" || 
            region === 'Gyala Delves'
        ){
            if (canthanCurrentPeriod.value === benchmarkTime ||
                canthanCurrentPeriod.value === 'Dusk' || 
                canthanCurrentPeriod.value === 'Dawn'
            ){
                return 'Active'
                
            } else {
                return 'Inactive'
                
            }
        // else if fishing benchmark is TYRIAN
        } else {
            if (tyrianCurrentPeriod.value === benchmarkTime ||
                tyrianCurrentPeriod.value === 'Dusk' || 
                tyrianCurrentPeriod.value === 'Dawn'
            ){
                return 'Active'
            } else {
                return 'Inactive'
            }
        }
    }).value; 
}

</script>

<style scoped>
.gold-choya{
    width: var(--img-gold-choya);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    opacity: 0.5;
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
.any{
    color: var(--color-anytime); 
}
@media (max-width: 768px){
    .card-container{
        flex-direction: column;
    }
    .card-details{
        flex-direction: column;
        gap: unset;
    }
    .card-title-and-value{
        flex-direction: row;
        width: 100%;
    }
    .card-map-and-info{
        flex-direction: row;
        align-items: flex-end;
        width: 100%;
    }
}

</style>