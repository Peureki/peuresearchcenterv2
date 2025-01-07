<template>
    <!--
        *
        * WAYPOINT
        *
    -->
    <div class="img-and-label">
        <img :src="Waypoint" :alt="`Waypoint to ${guide.waypoint}`" :title="`Waypoint to ${guide.waypoint}`"> 
        <p>Waypoint: 
            <a @click="(e) => {copyWaypoint(`${guide.waypoint}`); showTooltip(e)}">{{ guide.waypoint }}</a>
        </p>
    </div>
    
    <!--
        *
        * FISHING POWER
        *
    -->
    <div class="img-and-label">
        <img :src="FishingPower" alt="Fishing Power" title="Fishing Power">
        <p>Minimum Fishing Power: {{ guide.minFishingPower }}</p>
    </div>
    <!--
        *
        * BAIT 
        *
    -->
    <div class="img-and-label">
        <p v-if="!fish.bait_name">Bait:</p>
        <img v-if="fish.bait_name" :src="fish.bait_icon" :alt="baitName" :title="baitName">
        <p>{{ baitName }}</p>
    </div>
    <!--
        *
        * DESCRIPTION
        *
    -->
    <p>{{ guide.description }}</p>
    <!--
        *
        * MAP GUIDE
        *
    -->
    <img class="map-guide" v-if="guide.src" :src="guide.src" :alt="guide.alt" :title="guide.title">

    <Transition name="fade">
        <CursorTooltip v-if="tooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { handleCursorTooltip } from '@/js/vue/composables/MouseFunctions'
import { copyWaypoint } from '@/js/vue/composables/BasicFunctions';

// Cursor tooltip
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
import GuideItem from '@/js/vue/components/guides/nodes/GuideItem.vue';

// Info imgs
import FishingPower from '@/imgs/icons/fishes/Green_Hook.png'
import Waypoint from '@/imgs/icons/Waypoint.png'
// * 
// * PHOTOS OF FISH GUIDES
// * 
import CrystalOasisDesertFish from '@/imgs/guides/fishing/Crystal_Oasis_Desert_Fish.webp'
import DiessaPlateuLakeFish from '@/imgs/guides/fishing/Diessa_Plateau_Lake_Fish.webp'
import DraconisMonsVolcanicFish from '@/imgs/guides/fishing/Draconis_Mons_Volcanic_Fish.webp'
import DragonsEndCavernFish from "@/imgs/guides/fishing/Dragon's_End_Cavern_Fish.webp"
import DragonsEndQuarryFish from "@/imgs/guides/fishing/Dragon's_End_Quarry_Fish.webp"
import DomainOfIstanOffshoreFish from '@/imgs/guides/fishing/Domain_of_Istan_Offshore_Fish.webp'
import EchovaldWildsGrottoFish from '@/imgs/guides/fishing/Echovald_Wilds_Grotto_Fish.webp'
import EchovaldWildsLakeFish from '@/imgs/guides/fishing/Echovald_Wilds_Lake_Fish.webp'
import EmberBayCoastalFish from '@/imgs/guides/fishing/Ember_Bay_Coastal_Fish.webp'
import FireheartRiseNoxiousWaterFish from '@/imgs/guides/fishing/Fireheart_Rise_Noxious_Water_Fish.webp'
import FrostgorgeSoundBorealFish from '@/imgs/guides/fishing/Frostgorge_Sound_Boreal_Fish.webp'
import GendarranFieldsLakeFish from '@/imgs/guides/fishing/Gendarren_Fields_Lake_Fish.webp'
import GendarranRiverFish from '@/imgs/guides/fishing/Gendarran_Fields_River_Fish.webp'
import HomesteadFreshwaterFish from '@/imgs/guides/fishing/Homestead_Freshwater_Fish.webp'
import InnerNayosNayosianFish from '@/imgs/guides/fishing/Inner_Nayos_Nayosian_Fish.webp'
import JanthirSyntriAllFish from '@/imgs/guides/fishing/Janthir_Syntri_All_Fish.webp'
import KessexHillsPollutedLakeFish from '@/imgs/guides/fishing/Kessex_Hills_Polluted_Lake_Fish.webp'
import LionsArchCoastalFish from '@/imgs/guides/fishing/Lions_Arch_Coastal_Fish.webp'
import LowlandShoreBrackishFish from '@/imgs/guides/fishing/Lowland_Shore_Brackish_Fish.webp'
import LowlandShoreOffshoreFish from '@/imgs/guides/fishing/Lowland_Shore_Offshore_Fish.webp'
import NewKainengCityChannelFish from '@/imgs/guides/fishing/New_Kaineng_City_Channel_Fish.webp'
import NewKainengCityCoastalFish from '@/imgs/guides/fishing/New_Kaineng_City_Coastal_Fish.webp'
import RataSumSaltwaterFish from '@/imgs/guides/fishing/Rata_Sum_Saltwater_Fish.webp'
import SandsweptIslesShoreFish from '@/imgs/guides/fishing/Sandswept_Isles_Shore_Fish.webp'
import SeitungProvinceOffshoreFish from '@/imgs/guides/fishing/Seitung_Province_Offshore_Fish.webp'
import SeitungProvinceShoreFish from '@/imgs/guides/fishing/Seitung_Province_Shore_Fish.webp'
import SirensLandingShoreFish from "@/imgs/guides/fishing/Siren's_Landing_Shore_Fish.webp"
import SnowdenDriftsLakeFish from '@/imgs/guides/fishing/Snowden_Drifts_Lake_Fish.webp'
import StraitsOfDevestationOffshoreFish from '@/imgs/guides/fishing/Straits_of_Devestation_Offshore_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

const props = defineProps({
    fish: Object
})

const guide = ref({}); 

// If guide.value.bait isn't exclusively typed out, then follow what the favorite bait is
const baitName = computed(() => {
    if (!guide.value.bait)
        return props.fish.bait_name ? props.fish.bait_name : 'Any'
    else 
        return guide.value.bait
})

// * 
// * LIST of all min fishing powers 
// * 
// * mapNamePoolName: ###
// *
const minFishingPower = {
    ascalonLakeFish: 450,
    ascalonNoxiousWaterFish: 500,
    crystalDesertDesertFish: 500,
    dragonsEndCavernFish: 350,
    dragonsEndQuarryFish: 300,
    desertIslesOffshoreFish: 650,
    desertIslesShoreFish: 600,
    echovaldWildsGrottoFish: 300,
    echovaldWildsLakeFish: 250,
    hornOfMaguumaNayosianFish: 600,
    janthirBrackishFish: 550,
    janthirOffshoreFish: 600,
    janthirSyntriBrackishFish: 650,
    janthirSyntriFreshwaterFish: 600,
    janthirSyntriOffshoreFish: 650,
    krytanCoastalFish: 450,
    krytanLakeFish: 400,
    krytanRiverFish: 350,
    maguumaJungleFreshwaterFish: 500,
    maguumaJungleSaltwaterFish: 550,
    newKainengCityChannelFish: 250,
    newKainengCityCoastalFish: 200,
    orrOffshoreFish: 700,
    orrShoreFish: 650,
    ringOfFireCoastalFish: 700,
    ringOfFireVolcanicFish: 750,
    saltwaterFish: 550,
    seitungProvinceOffshoreFish: 200,
    seitungProvinceShoreFish: 150,
    shiverpeaksBorealFish: 450,
    shiverpeaksLakeFish: 400,
    worldClassPollutedLakeFish: 500,
}


onMounted(() => {
    switch (props.fish.map){
        // *
        // * ASCALON REGION
        // *
        case 'Ascalon':
            switch (props.fish.name){
                // *
                // * LAKE FISH
                // *
                case 'Bluegill':
                case 'Rock Bass':
                case 'Largemouth Bass':
                    guide.value.src = DiessaPlateuLakeFish; 
                    guide.value.alt = "Diessa Plateau Lake Fish";
                    guide.value.waypoint = '[&BMkDAAA=] -> [&BGQBAAA=]';
                    guide.value.minFishingPower = minFishingPower.ascalonLakeFish;
                    guide.value.description = "Should be a fairly common drop. I recommend this particular route for Ascalon Lake Fish because there's so many of the pools. You have the option to stay in the first lake (first waypoint) or utilize lakes in Diessa."
                    break;

                case 'Brook Trout':
                    guide.value.src = DiessaPlateuLakeFish; 
                    guide.value.alt = "Diessa Plateau Lake Fish";
                    guide.value.waypoint = '[&BMkDAAA=] -> [&BGQBAAA=]';
                    guide.value.minFishingPower = minFishingPower.ascalonLakeFish;
                    guide.value.description = "Should be a fairly common drop, but it's also a dusk/dawn fish so..good luck."
                    break;

                case 'Golden Trout':
                case 'Gar':
                case 'Muskellunge':
                case 'Old Whiskers':
                    guide.value.src = DiessaPlateuLakeFish; 
                    guide.value.alt = "Diessa Plateau Lake Fish";
                    guide.value.waypoint = '[&BMkDAAA=] -> [&BGQBAAA=]';
                    guide.value.minFishingPower = minFishingPower.ascalonLakeFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. Good luck."
                    break;

                // *
                // * NOXIOUS WATER FISH
                // *
                case 'Black Crappie':
                case 'Yellow Perch':
                    guide.value.src = FireheartRiseNoxiousWaterFish; 
                    guide.value.alt = "Fireheart Rise Noxious Water Fish";
                    guide.value.waypoint = '[&BBYCAAA=] -> [&BBoCAAA=], or Fields of Ruin: [&BNcAAAA=]';
                    guide.value.minFishingPower = minFishingPower.ascalonNoxiousWaterFish;
                    guide.value.description = "Should be a fairly common drop. Other maps that have Noxious Water Fish include Blazerridge and Iron Marches. They have as easy of routes, but Fireheart has lots of Lake Fish in case you need those fish as well. If you don't want to waypoint for Noxious Fish and only want Noxious Fish, then I recommend Fields of Ruin. Though, it only has 4 pools close to each other and no close Lake Fish (refer to the waypoint above)."
                    break;

                case 'Aquatic Frog':
                case 'Branded Eel':
                    guide.value.src = FireheartRiseNoxiousWaterFish; 
                    guide.value.alt = "Fireheart Rise Noxious Water Fish";
                    guide.value.waypoint = '[&BBYCAAA=] -> [&BBoCAAA=], or Fields of Ruin: [&BNcAAAA=]';
                    guide.value.minFishingPower = minFishingPower.ascalonNoxiousWaterFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. Fireheart Rise is unique where it contains all the fishing pools for the Ascalon achievement. But, if you don't want to waypoint for Noxious Fish and only want Noxious Fish, then I recommend Fields of Ruin. Though, it only has 4 pools close to each other and no close Lake Fish (refer to the waypoint above)."
                    break;

                // *
                // * NONE, OPEN WATER
                // *
                case 'Bitterling':
                case 'Bream':
                case 'Cutthroat Trout':
                case 'Smallmouth Bass':
                    guide.value.waypoint = '[&BEIEAAA=], [&BMkDAAA=], [&BGQBAAA=], [&BKYAAAA=], [&BMcDAAA=]';
                    guide.value.minFishingPower = minFishingPower.ascalonLakeFish;
                    guide.value.description = "Any body of water in the Krytan region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;
            }
            break;
        // *
        // * CRYSTAL DESERT REGION
        // *
        case 'Crystal Desert':
            switch (props.fish.name){
                // *
                // * DESERT FISH
                // *
                case 'Elon Tetra':
                case 'Barramundi':
                case 'Giant Barb':
                case 'Lungfish':
                case 'Red-Eyed Piranha':
                case 'Mudskipper':
                case 'Zander':
                case 'Sand Carp':
                case 'Paddlefish':
                    guide.value.src = CrystalOasisDesertFish; 
                    guide.value.alt = "Crystal Oasis Desert Fish";
                    guide.value.waypoint = '[&BLsKAAA=] -> Head west to the bay.';
                    guide.value.minFishingPower = minFishingPower.crystalDesertDesertFish;
                    guide.value.description = "Should be a fairly common drop. There are many other great Desert Fish routes such as Kourna, but Crystal Oasis has a longer route, more pools, and it's very pretty."
                    break;

                case 'Gilded Loach':
                case 'Marbled Lungfish':
                case 'Giant Paddlefish':
                case 'Golden Mahseer':
                case 'Striped Catfish':
                case 'Kaluga':
                case 'Silver Bichir':
                case 'Tigerfish':
                case 'Vundu':
                    guide.value.src = CrystalOasisDesertFish; 
                    guide.value.alt = "Crystal Oasis Desert Fish";
                    guide.value.waypoint = '[&BLsKAAA=] -> Head west to the bay.';
                    guide.value.minFishingPower = minFishingPower.crystalDesertDesertFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. There are many other great Desert Fish routes such as Kourna, but Crystal Oasis has a longer route, more pools, and it's very pretty."
                    break;


                // *
                // * NONE, OPEN WATER
                // *
                case 'Elonian Bass':
                case 'Mahseer':
                case 'Tilapia':
                    guide.value.waypoint = '[&BLsKAAA=], [&BFcLAAA=] (take portal west of waypoint), [&BGcKAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "Any body of water in the Krytan region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;
            }
            break;
        // *
        // * DRAGON'S END REGION
        // *
        case "Dragon's End":
            switch (props.fish.name){
                // *
                // * CAVERN FISH
                // *
                case 'Gourami':
                case 'Toadfish':
                case 'Sheatfish':
                    guide.value.src = DragonsEndCavernFish; 
                    guide.value.alt = "Dragon's End Cavern Fish";
                    guide.value.waypoint = '[&BKIMAAA=] -> Head south';
                    guide.value.minFishingPower = minFishingPower.dragonsEndCavernFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Unicorn Fish':
                case 'Axolotl':
                case 'Chambered Nautilus':
                    guide.value.src = DragonsEndCavernFish; 
                    guide.value.alt = "Dragon's End Cavern Fish";
                    guide.value.waypoint = '[&BKIMAAA=] -> Head south';
                    guide.value.minFishingPower = minFishingPower.dragonsEndCavernFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;
                
                // *
                // * QUARRY FISH
                // *
                case 'Canthan Carp':
                case 'Jade Lamprey':
                case 'Spotted Pufferfish':
                    guide.value.src = DragonsEndQuarryFish; 
                    guide.value.alt = "Dragon's End Quarry Fish";
                    guide.value.waypoint = '[&BKIMAAA=] -> Head east';
                    guide.value.minFishingPower = minFishingPower.dragonsEndQuarryFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Giant Gourami':
                case 'Jade Sea Turtle':
                case 'Cuttlefish':
                    guide.value.src = DragonsEndQuarryFish; 
                    guide.value.alt = "Dragon's End Quarry Fish";
                    guide.value.waypoint = '[&BKIMAAA=] -> Head east';
                    guide.value.minFishingPower = minFishingPower.dragonsEndQuarryFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;
                
                // *
                // * NONE, OPEN WATER
                // *
                case 'Boxfish':
                case 'Rohu':
                    guide.value.waypoint = '[&BKIMAAA=]';
                    guide.value.minFishingPower = minFishingPower.dragonsEndCavernFish;
                    guide.value.description = "Any body of water in Dragon's End will do."
                    break;
            }
            break;
        
        // *
        // * DESERT ISLES REGION
        // *
        case 'Desert Isles':
            switch (props.fish.name){
                // *
                // * OFFSHORE FISH
                // *
                case 'Parrotfish':
                case 'Roosterfish':
                case 'Opah':
                    guide.value.src = DomainOfIstanOffshoreFish; 
                    guide.value.alt = "Domain of Istan Offshore Fish";
                    guide.value.waypoint = '[&BAkLAAA=] or [&BPoKAAA=] for long alternative, extended route';
                    guide.value.minFishingPower = minFishingPower.desertIslesOffshoreFish;
                    guide.value.description = "Should be a fairly common drop. This route is great compared to other Krytan maps because this will be 100% safe and straightforward. You can either follow the map or circle through the bay."
                    break;

                case 'Wahoo':
                case 'Blue Marlin':
                case 'Dandan':
                    guide.value.src = DomainOfIstanOffshoreFish; 
                    guide.value.alt = "Domain of Istan Offshore Fish";
                    guide.value.waypoint = '[&BAkLAAA=] or [&BPoKAAA=] for long alternative, extended route';
                    guide.value.minFishingPower = minFishingPower.desertIslesOffshoreFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * SHORE FISH
                // *
                case 'Cobia':
                case 'Diamond Trevally':
                case 'Yellowtail Snapper':
                    guide.value.src = SandsweptIslesShoreFish; 
                    guide.value.alt = "Sandswept Isles Shore Fish";
                    guide.value.waypoint = '[&BEMLAAA=]';
                    guide.value.minFishingPower = minFishingPower.desertIslesShoreFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Pompano':
                case 'King Crab':
                case 'Beluga':
                    guide.value.src = SandsweptIslesShoreFish; 
                    guide.value.alt = "Sandswept Isles Shore Fish";
                    guide.value.waypoint = '[&BEMLAAA=]';
                    guide.value.minFishingPower = minFishingPower.desertIslesShoreFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * NONE, OPEN WATER
                // *
                case 'Sea Trout':
                case 'Sheepshead':
                    guide.value.waypoint = '[&BAkLAAA=], [&BEMLAAA=]';
                    guide.value.minFishingPower = minFishingPower.desertIslesOffshoreFish;
                    guide.value.description = "Any body of water in the Krytan region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;

            }
            break;

        // *
        // * ECHOVALD WILDS REGION
        // *
        case 'Echovald Wilds':
            switch (props.fish.name){
                // *
                // * GROTTO FISH
                // *
                case 'Snakefish':
                case 'Petrifish':
                    guide.value.src = EchovaldWildsGrottoFish; 
                    guide.value.alt = "Echovald Wilds Grotto Fish";
                    guide.value.waypoint = '[&BMwMAAA=] (for the 5), [&BMcMAAA=]';
                    guide.value.minFishingPower = minFishingPower.echovaldWildsGrottoFish;
                    guide.value.description = "Should be a fairly common drop. If you only need Grotto Fish, then I recommend going to the (5) pool spot. If you also need Lake Fish, then I recommend the other route."
                    break;

                case 'Albino Axolotl':
                case 'Albino Gourami':
                case 'Dark Sleeper':
                    guide.value.src = EchovaldWildsGrottoFish; 
                    guide.value.alt = "Echovald Wilds Grotto Fish";
                    guide.value.waypoint = '[&BMwMAAA=] (for the 5), [&BMcMAAA=]';
                    guide.value.minFishingPower = minFishingPower.echovaldWildsGrottoFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. If you also need Lake Fish, then I recommend the other route."
                    break;

                // *
                // * LAKE FISH
                // *
                case 'Black Carp':
                case 'Knifefish':
                case 'Bullhead Catfish':
                case 'Cherry Barb':
                    guide.value.src = EchovaldWildsLakeFish; 
                    guide.value.alt = "Echovald Wilds Lake Fish";
                    guide.value.waypoint = '[&BNQMAAA=], [&BMcMAAA=]';
                    guide.value.minFishingPower = minFishingPower.echovaldWildsLakeFish;
                    guide.value.description = "Should be a fairly common drop. If you do not wish to waypoint between the two, you could stay south (the second waypoint) and go in circles around that lake."
                    break;

                case 'Amber Trout':
                case 'Royal Featherback':
                case "Melandru's Lurker":
                    guide.value.src = EchovaldWildsLakeFish; 
                    guide.value.alt = "Echovald Wilds Lake Fish";
                    guide.value.waypoint = '[&BNQMAAA=], [&BMcMAAA=]';
                    guide.value.minFishingPower = minFishingPower.echovaldWildsLakeFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. If you do not wish to waypoint between the two, you could stay south (the second waypoint) and go in circles around that lake."
                    break;

                // *
                // * NONE, OPEN WATER
                // *
                case 'Freshwater Eel':
                case 'Stone Loach':
                    guide.value.waypoint = '[&BNQMAAA=], [&BMcMAAA=]';
                    guide.value.minFishingPower = minFishingPower.echovaldWildsLakeFish;
                    guide.value.description = "Any body of water in Echovald Wilds will do."
                    break;
            }
            break;

        // *
        // * HORN OF MAGUUMA REGION
        // *
        case 'Horn of Maguuma':
            guide.value.src = InnerNayosNayosianFish; 
            guide.value.alt = "Inner Nayos Nayosian Fish";
            guide.value.waypoint = '[&BGYOAAA=]';
            guide.value.minFishingPower = minFishingPower.hornOfMaguumaNayosianFish;
            guide.value.description = "This is a unique fishing achievement where ALL of the fish can be aquired by either Nayosian Fish or Dream Fish. Any other pool in the Horn of Maguuma region is too difficult or not practical. For higher-end fishes, I recommend obtaining the highest possible Fishing Power to better your chances."
            break;

        // *
        // * JANTHIR REGION
        // *
        case 'Janthir':
            switch (props.fish.name){
                // *
                // * BRACKISH/FRESHWATER FISH
                // *
                case 'Lowland Grunt':
                case 'Shaderock Salamander':
                case 'Juvenile Frogfish':
                    guide.value.src = LowlandShoreBrackishFish; 
                    guide.value.alt = "Lowland Shore Brackish/Freshwater Fish";
                    guide.value.waypoint = '[&BC4PAAA=]';
                    guide.value.minFishingPower = minFishingPower.janthirBrackishFish;
                    guide.value.description = "Should be a fairly common drop. While the map guide is the same fishing benchmark, to make things easier, I highly recommend only going to the waypoint listed above. This refers to the middle of the map route. This should be a decent amount of both Brackish and Freshwater pools. It is possible to get this fish for Lowland Offshore and Shore pools."
                    break;

                case 'Mohawk Bream':
                case 'Spectacled Lumper':
                    guide.value.src = LowlandShoreOffshoreFish; 
                    guide.value.alt = "Lowland Shore Offshore/Shore Fish";
                    guide.value.waypoint = '[&BN8OAAA=]';
                    guide.value.minFishingPower = minFishingPower.janthirOffshoreFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                // *
                // * OFFSHORE/SHORE FISH
                // *
                case 'Violet Screamer':
                case 'Viperfish': 
                    guide.value.src = LowlandShoreOffshoreFish; 
                    guide.value.alt = "Lowland Shore Offshore/Shore Fish";
                    guide.value.waypoint = '[&BN8OAAA=]';
                    guide.value.minFishingPower = minFishingPower.janthirOffshoreFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                // *
                // * JANTHIR SYNTRI
                // *
                case 'Flowerhead':
                case 'Indigo Drakefish':
                    guide.value.src = JanthirSyntriAllFish; 
                    guide.value.alt = "Janthir Syntri All Fish";
                    guide.value.waypoint = '[&BLcOAAA=], [&BCoPAAA=], [&BLgOAAA=]';
                    guide.value.minFishingPower = minFishingPower.janthirSyntriOffshoreFish;
                    guide.value.description = "The best route would be both Brackish, Offshore, and Shore pools. The Freshwater are too isolated, but this may drop from those pools too. I recommend obtaining the highest possible Fishing Power to better your chances."
                    break;

                case 'Queen Parrotfish':
                case 'Longhorn Boxfish':
                case 'Mouse-Eared Octopus':
                    guide.value.src = JanthirSyntriAllFish; 
                    guide.value.alt = "Janthir Syntri All Fish";
                    guide.value.waypoint = '[&BLcOAAA=], [&BCoPAAA=], [&BLgOAAA=]';
                    guide.value.minFishingPower = minFishingPower.janthirSyntriOffshoreFish;
                    guide.value.description = "The best route would be both Brackish, Offshore, and Shore pools. The Freshwater are too isolated."
                    break;
            }
            break;

        // *
        // * KRYTA REGION
        // *
        case 'Kryta': 
            switch (props.fish.name){
                // *
                // * COASTAL FISH
                // *
                case 'Swampblight Lamprey':
                case 'Silver Moony':
                    guide.value.src = LionsArchCoastalFish; 
                    guide.value.alt = "Lion's Arch Coastal Fish";
                    guide.value.waypoint = '[&BDMEAAA=] or [&BC8EAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanCoastalFish;
                    guide.value.description = "Should be a fairly common drop. This route is great compared to other Krytan maps because this will be 100% safe and straightforward. You can either follow the map or circle through the bay."
                    break;

                case 'Krytan Puffer':
                case 'Holy Mackerel':
                    guide.value.src = LionsArchCoastalFish; 
                    guide.value.alt = "Lion's Arch Coastal Fish";
                    guide.value.waypoint = '[&BDMEAAA=] or [&BC8EAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanCoastalFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. This route is great compared to other Krytan maps because this will be 100% safe and straightforward. You can either follow the map or circle through the bay."
                    break;

                case 'Black Lionfish':
                    guide.value.src = LionsArchCoastalFish; 
                    guide.value.alt = "Lion's Arch Coastal Fish";
                    guide.value.waypoint = '[&BDMEAAA=] or [&BC8EAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanCoastalFish;
                    guide.value.description = "For this particular legendary fish, I highly highly HIGHLY recommend catching this during the night. Night yields a much higher drop rate (3% in the day, ~10% at night at 975 Fishing Power). I recommend aiming for higher Fishing Power to improve your chances. This route is great compared to other Krytan maps because this will be 100% safe and straightforward. You can either follow the map or circle through the bay."
                    break;

                // *
                // * LAKE FISH
                // *
                case 'Striped Bass':
                case 'Black Bass':
                    guide.value.src = GendarranFieldsLakeFish; 
                    guide.value.alt = 'Gendarran Fields Lake Fish';
                    guide.value.waypoint = '[&BJABAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanLakeFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Quagmire Eel':
                case 'Royal Pike':
                case 'Slaughterfish':
                    guide.value.src = GendarranFieldsLakeFish; 
                    guide.value.alt = 'Gendarran Fields Lake Fish';
                    guide.value.waypoint = '[&BJABAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanLakeFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * RIVER FISH
                // *
                case 'Round Goby':
                case 'Sailfin Goby':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.waypoint = '[&BAIEAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "High drop rate in River Fish in particular. While Round Goby can be captured in any other Krytan pool, River Fish, regardless of high (above 900+) or low Fishing Power, will yield blue fish. This route can be great if you still need the other River fishes."
                    break;

                case 'Steelhead Trout': 
                case 'Delvan Guppy':
                case 'Croaker':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.waypoint = '[&BAIEAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Divinity Angelfin':
                case 'Queenfish': 
                case 'Mud Skate':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.waypoint = '[&BAIEAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * NONE, OPEN WATER
                // *
                case 'Speckled Perch':
                case 'Krytan Crawfish':
                case 'Spotted Flounder':
                    guide.value.waypoint = '[&BAIEAAA=], [&BDMEAAA=], [&BEUDAAA=], [&BKYAAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "Any body of water in the Krytan region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;
            }
            break; 

        // *
        // * MAGUUMA JUNGLE REGION
        // *
        case 'Maguuma Jungle':
            switch (props.fish.name){
                // *
                // * FRESHWATER FISH
                // *
                case 'Bicuda':
                case 'Pacu':
                case 'Payara':
                case 'Peacock Bass':
                    guide.value.src = HomesteadFreshwaterFish; 
                    guide.value.alt = 'Homestead Saltwater Fish';
                    guide.value.waypoint = 'Use personal Homestead portal or Tangled Depths: [&BAwIAAA=] (head down from waypoint)';
                    guide.value.minFishingPower = minFishingPower.maguumaJungleFreshwaterFish;
                    guide.value.description = "Should be a fairly common drop. Homestead has the most straightforward route and it's easily accessible. But, if you don't have access to your Homestead, refer to the waypoint for Tangled Depths."
                    break;

                case 'Arowana':
                case 'Golden Dorado':
                case 'Arapaima':
                case 'Sardinata':
                case 'Jundia':
                    guide.value.src = HomesteadFreshwaterFish; 
                    guide.value.alt = 'Homestead Saltwater Fish';
                    guide.value.waypoint = 'Use personal Homestead portal or Tangled Depths: [&BAwIAAA=] (head down from waypoint)';
                    guide.value.minFishingPower = minFishingPower.maguumaJungleFreshwaterFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. Homestead has the most straightforward route and it's easily accessible. But, if you don't have access to your Homestead, refer to the waypoint for Tangled Depths."
                    break;

                // *
                // * SALTWATER FISH
                // *
                case 'Oscar':
                case 'Silver Drum':
                case 'Surubim':
                case 'Maguuma Trout':
                case 'Wolffish':
                    guide.value.src = RataSumSaltwaterFish; 
                    guide.value.alt = 'Rata Sum Saltwater Fish';
                    guide.value.waypoint = '[&BAcFAAA=], [&BNQCAAA=]';
                    guide.value.minFishingPower = minFishingPower.maguumaJungleSaltwaterFish;
                    guide.value.description = "Should be a fairly common drop. This map is Rata Sum because it has a really good route for Saltwater Fish (and for the Saltwater achievement), but you can also go to Mount Maelstrom (refer to second waypoint)."
                    break;

                case 'Rainbow Glowfish':
                case 'Royal Starfish':
                case 'Goliath Grouper':
                    guide.value.src = RataSumSaltwaterFish; 
                    guide.value.alt = 'Rata Sum Saltwater Fish';
                    guide.value.waypoint = '[&BAcFAAA=], [&BNQCAAA=]';
                    guide.value.minFishingPower = minFishingPower.maguumaJungleSaltwaterFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. This map is Rata Sum because it has a really good route for Saltwater Fish (and for the Saltwater achievement), but you can also go to Mount Maelstrom (refer to second waypoint)."
                    break;

                // *
                // * NONE, OPEN WATER
                // *
                case 'Brackish Goby':
                case 'Piranha':
                case 'Snook':
                    guide.value.waypoint = '[&BAcFAAA=], [&BNQCAAA=], [&BAwIAAA=] (head down from the waypoint), Homested';
                    guide.value.minFishingPower = minFishingPower.maguumaJungleSaltwaterFish;
                    guide.value.description = "Any body of water in the Maguuma Jungle region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;
            }
            break;

        // * 
        // * NEW KAINENG CITY
        // *
        case 'New Kaineng City':
            switch (props.fish.name){
                // *
                // * CHANNEL FISH
                // *
                case 'Blowfish':
                case 'Emperor Fish':
                case 'Weever':
                    guide.value.src = NewKainengCityChannelFish; 
                    guide.value.alt = 'New Kaineng City Channel Fish';
                    guide.value.waypoint = '[&BNQCAAA=]';
                    guide.value.minFishingPower = minFishingPower.newKainengCityChannelFish;
                    guide.value.description = "Should be a fairly common drop. You could get these fish from Coastal Fish as well. Both have great routes. I'm putting Channel Fish's map on here because the achievement does not require Mackerels, which can be expensive."
                    break;

                case 'Striped Barracuda':
                case 'Dragonfish':
                    guide.value.src = NewKainengCityChannelFish; 
                    guide.value.alt = 'New Kaineng City Channel Fish';
                    guide.value.waypoint = '[&BNQCAAA=]';
                    guide.value.minFishingPower = minFishingPower.newKainengCityChannelFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Taimen':
                case 'Starry Flounder':
                case 'Oarfish':
                    guide.value.src = NewKainengCityChannelFish; 
                    guide.value.alt = 'New Kaineng City Channel Fish';
                    guide.value.waypoint = '[&BNQCAAA=]';
                    guide.value.minFishingPower = minFishingPower.newKainengCityChannelFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * COASTAL FISH
                // *
                case 'Emerald Snapper':
                case 'Kahawai':
                case 'Amberjack':
                case 'Pufferfish':
                    guide.value.src = NewKainengCityCoastalFish; 
                    guide.value.alt = 'New Kaineng City Coastal Fish';
                    guide.value.waypoint = '[&BMYMAAA=]';
                    guide.value.minFishingPower = minFishingPower.newKainengCityCoastalFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Blue Dorado':
                case 'Sturgeon':
                case 'Giant Trevally':
                case 'Tarpon':
                case 'Bluefin Tuna':
                case 'Swordfish':
                    guide.value.src = NewKainengCityCoastalFish; 
                    guide.value.alt = 'New Kaineng City Coastal Fish';
                    guide.value.waypoint = '[&BMYMAAA=]';
                    guide.value.minFishingPower = minFishingPower.newKainengCityCoastalFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                


                // *
                // * NONE, OPEN WATER
                // *
                case 'Flying Fish':
                case 'Pollock':
                case 'Sea Perch':
                    guide.value.waypoint = '[&BMYMAAA=], [&BBkNAAA=]';
                    guide.value.minFishingPower = minFishingPower.newKainengCityCoastalFish
                    guide.value.description = "Any body of water in New Kaineng City will do."
                    break;
            }
            break;

        // *
        // * ORR REGION
        // *
        case 'Orr':
            switch (props.fish.name){
                // *
                // * OFFSHORE FISH
                // *
                case 'Albino Blindfish':
                case 'Dead Alewife':
                case 'Monkfish':
                case 'Viperfish':
                case 'Hagfish':
                case 'Abyssal Squid':
                case 'Spectral Jellyfish':
                    guide.value.src = StraitsOfDevestationOffshoreFish; 
                    guide.value.alt = 'Straits of Devestation Offshore Fish';
                    guide.value.waypoint = '[&BPICAAA=]';
                    guide.value.minFishingPower = minFishingPower.orrOffshoreFish;
                    guide.value.description = "Should be a fairly common drop. While the body of water is massive, this general area around the waypoint seems to have the most reliable set of pools for every instance."
                    break;

                case 'Stargazer':
                case 'Blobfish':
                case 'Benthic Behemoth':
                case 'Orrian Anglerfish':
                case 'Giant Octopus':
                case 'Shipwreck Moray':
                    guide.value.src = StraitsOfDevestationOffshoreFish; 
                    guide.value.alt = 'Straits of Devestation Offshore Fish';
                    guide.value.waypoint = '[&BPICAAA=]';
                    guide.value.minFishingPower = minFishingPower.orrOffshoreFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. While the body of water is massive, this general area around the waypoint seems to have the most reliable set of pools for every instance."
                    break;

                // *
                // * SHORE FISH
                // *
                case 'Monkfish':
                case 'Dhuum Fish':
                case 'Frilled Shark':
                    guide.value.src = SirensLandingShoreFish; 
                    guide.value.alt = "Sire's Landing Shore Fish";
                    guide.value.waypoint = "[&BO8JAAA=], or Malchor's Leap starting at [&BLICAAA=] -> along coast to [&BIoCAAA=]";
                    guide.value.minFishingPower = minFishingPower.orrShoreFish;
                    guide.value.description = "Should be a fairly common drop. If you do not have Siren's Landing unlocked, Malchor's Leap has a decent amount of Shore Fish (refer to the waypoint and POIs)."
                    break;

                case 'Man-of-War':
                case 'Risen Sea Bass':
                case 'Unholy Mackerel':
                    guide.value.src = SirensLandingShoreFish; 
                    guide.value.alt = "Sire's Landing Shore Fish";
                    guide.value.waypoint = "[&BO8JAAA=], or Malchor's Leap starting at [&BLICAAA=] -> along coast to [&BIoCAAA=]";
                    guide.value.minFishingPower = minFishingPower.orrShoreFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances. If you do not have Siren's Landing unlocked, Malchor's Leap has a decent amount of Shore Fish (refer to the waypoint and POIs)."
                    break;

                case 'Frilled Shark':
                    guide.value.src = SirensLandingShoreFish; 
                    guide.value.alt = "Sire's Landing Shore Fish";
                    guide.value.waypoint = '[&BO8JAAA=]';
                    guide.value.minFishingPower = minFishingPower.orrShoreFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;


                // *
                // * NONE, OPEN WATER
                // *
                case 'Dusky Grouper':
                case 'Ghostfish':
                case 'Murkwater Darter':
                    guide.value.waypoint = '[&BPICAAA=]';
                    guide.value.minFishingPower = minFishingPower.orrOffshoreFish;
                    guide.value.description = "Any body of water in the Orr region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;
            }
            
        
        // *
        // * RING OF FIRE REGION
        // *
        case 'Ring of Fire':
        case 'Draconis Mons':
        case 'Ember Bay':
            switch (props.fish.name){
                // *
                // * COASTAL FISH
                // *
                case 'Igneous Rockfish':
                case 'Redtail Catfish':
                case 'Geyser Batfin':
                    guide.value.src = EmberBayCoastalFish; 
                    guide.value.alt = 'Ember Bay Coastal Fish';
                    guide.value.waypoint = '[&BF8JAAA=]';
                    guide.value.minFishingPower = minFishingPower.ringOfFireCoastalFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Flamefin Betta':
                case 'Scorpion Fish':
                case 'Dunkleosteus':
                    guide.value.src = EmberBayCoastalFish; 
                    guide.value.alt = 'Ember Bay Coastal Fish';
                    guide.value.waypoint = '[&BF8JAAA=]';
                    guide.value.minFishingPower = minFishingPower.ringOfFireCoastalFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * VOLCANIC FISH
                // *
                case 'Flayfin':
                case 'Garnet Ram':
                case 'Fire Eel':
                    guide.value.src = DraconisMonsVolcanicFish; 
                    guide.value.alt = 'Draconis Mons Volcanic Fish';
                    guide.value.waypoint = '[&BL0JAAA=]';
                    guide.value.minFishingPower = minFishingPower.ringOfFireVolcanicFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Glowing Coalfish':
                case 'Magma Ray':
                case 'Stone Guiyu':
                    guide.value.src = DraconisMonsVolcanicFish; 
                    guide.value.alt = 'Draconis Mons Volcanic Fish';
                    guide.value.waypoint = '[&BL0JAAA=]';
                    guide.value.minFishingPower = minFishingPower.ringOfFireVolcanicFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;


                // *
                // * NONE, OPEN WATER
                // *
                case 'Volcanic Blackfish':
                case 'Firemouth':
                    guide.value.waypoint = '[&BF8JAAA=], [&BL0JAAA=]';
                    guide.value.minFishingPower = 
                        props.fish.name == 'Volcanic Blackfish'
                            ? minFishingPower.ringOfFireVolcanicFish
                            : minFishingPower.ringOfFireCoastalFish
                    guide.value.description = "Any body of water in the Ring of Fire region will do. I recommend having any fish food to be above the minimum fishing power if you're not using a skiff to have a green bar."
                    break;
            }
            break;

        // *
        // * SALTWATER REGION
        // *
        case 'Saltwater':
            guide.value.src = RataSumSaltwaterFish; 
            guide.value.alt = 'Rata Sum Saltwater Fish';
            guide.value.waypoint = '[&BAcFAAA=]';
            guide.value.minFishingPower = minFishingPower.RataSumSaltwaterFish;
            guide.value.description = "You could either do Rata Sum or Mount Maelstrom (refer to the waypoints above). Both are extremely plentiful for pools and are very safe. Rata's pool are more condensed, especially if you can waypoint at the end of the route."
            guide.value.bait = "Any. I recommend still running Sardines to also get the Maguuma Fisher achievement (and to get lots of legendary fishes), but you can opt out if you purely only want Saltwater.";
            break;

        // *
        // * SEITUNG PROVINCE REGION
        // *
        case 'Seitung Province':
            switch (props.fish.name){
                // *
                // * OFFSHORE REGION
                // *
                case 'Bluefin Trevally':
                case 'Corvina':
                case 'Chestnut Sea Bream':
                    guide.value.src = SeitungProvinceOffshoreFish; 
                    guide.value.alt = 'Seitung Province Offshore Fish';
                    guide.value.waypoint = '[&BJ4MAAA=]';
                    guide.value.minFishingPower = minFishingPower.seitungProvinceOffshoreFish;
                    guide.value.description = "Should be a fairly common drop. You could either do Shore or Offshore Fish or both."
                    break;

                case 'Crimson Snapper':
                case 'Honeycomb Grouper':
                case 'Green Sawfish':
                case 'Tripletail':
                    guide.value.src = SeitungProvinceOffshoreFish; 
                    guide.value.alt = 'Seitung Province Offshore Fish';
                    guide.value.waypoint = '[&BJ4MAAA=]';
                    guide.value.minFishingPower = minFishingPower.seitungProvinceOffshoreFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Humphead Wrasse':
                case 'Skipjack Tuna':
                case 'Sailfish':
                case 'Dragonet':
                case 'Mega Prawn':
                case 'Sunfish':
                    guide.value.src = SeitungProvinceOffshoreFish; 
                    guide.value.alt = 'Seitung Province Offshore Fish';
                    guide.value.waypoint = '[&BJ4MAAA=]';
                    guide.value.minFishingPower = minFishingPower.seitungProvinceOffshoreFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;
                    
                // *
                // * SHORE FISH
                // *
                case 'Cherry Salmon':
                case 'Cutlass Fish':
                    guide.value.src = SeitungProvinceShoreFish; 
                    guide.value.alt = 'Seitung Province Shore Fish';
                    guide.value.waypoint = '[&BJ4MAAA=]';
                    guide.value.minFishingPower = minFishingPower.seitungProvinceShoreFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Stingray':
                case 'Spotted Stingray':
                case 'Fugu Fish':
                    guide.value.src = SeitungProvinceShoreFish; 
                    guide.value.alt = 'Seitung Province Shore Fish';
                    guide.value.waypoint = '[&BJ4MAAA=]';
                    guide.value.minFishingPower = minFishingPower.seitungProvinceShoreFish;
                    guide.value.description = "I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * NONE, OPEN WATER
                // *
                case 'Globefish':
                case 'Mullet':
                case 'Porgy':
                    guide.value.waypoint = '[&BJ4MAAA=]';
                    guide.value.minFishingPower = minFishingPower.seitungProvinceShoreFish
                    guide.value.description = "Any body of water in Seitung Province will do."
                    break;
            }

        // *
        // * SHIVERPEAKS REGION
        // *
        case 'Shiverpeaks':
            switch (props.fish.name){
                // *
                // * BOREAL FISH
                // * 
                case 'Alpine Char':
                case 'Grayling':
                case 'Walleye':
                case 'Boreal Cod':
                case 'Icy Lumpfish':
                    guide.value.src = FrostgorgeSoundBorealFish; 
                    guide.value.alt = 'Frostgorge Sound Boreal Fish';
                    guide.value.waypoint = '[&BH4CAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish;
                    guide.value.description = "Should be a fairly common drop."
                    break;

                case 'Mystic Remora':
                    guide.value.src = FrostgorgeSoundBorealFish; 
                    guide.value.alt = 'Frostgorge Sound Boreal Fish';
                    guide.value.waypoint = '[&BH4CAAA=], Bitterfrost: [&BH0JAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish;
                    guide.value.description = "I recommend sticking with Frostgorge for the ease of route and you can plan your time to catch. But, if you ONLY need Mystic Remora, then maybe Bitterfrost could be an option. That map is unique where it changes from day -> dusk when the meta starts prepping. There's no global timer on it, but each instance cycles the meta every ~55mins or so. I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                case 'Snowflake Eel':
                    guide.value.src = FrostgorgeSoundBorealFish; 
                    guide.value.alt = 'Frostgorge Sound Boreal Fish';
                    guide.value.waypoint = '[&BH4CAAA=], Lowland: [&BC4PAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish;
                    guide.value.description = "Frostgorge (Shiverpeaks in general) will give you the best chances for these. Though, it is possible to drop these in Lowland Shore's Brackish Fish. If you go to Lowlands, they will only drop during the day. I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                case 'Halibut':
                    guide.value.src = FrostgorgeSoundBorealFish; 
                    guide.value.alt = 'Frostgorge Sound Boreal Fish';
                    guide.value.waypoint = '[&BH4CAAA=], Lowland: [&BN8OAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish;
                    guide.value.description = "Frostgorge (Shiverpeaks in general) will give you the best chances for these. Though, it is possible to drop these in Lowland Shore's Offshore/Shore Fish. If you go to Lowlands, they will only drop during the night. I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                case "Lornar's Bass":
                    guide.value.src = FrostgorgeSoundBorealFish; 
                    guide.value.alt = 'Frostgorge Sound Boreal Fish';
                    guide.value.waypoint = '[&BH4CAAA=], Lowland: [&BC4PAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish;
                    guide.value.description = "Frostgorge (Shiverpeaks in general) will give you the best chances for these. Though, it is possible to drop these in Lowland Shore's Freshwater Fish. If you go to Lowlands, they will only drop during the day. I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                case 'Alabaster Oscar':
                    guide.value.src = FrostgorgeSoundBorealFish; 
                    guide.value.alt = 'Frostgorge Sound Boreal Fish';
                    guide.value.waypoint = '[&BH4CAAA=], Lowland: [&BN8OAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish;
                    guide.value.description = "Frostgorge (Shiverpeaks in general) will give you the best chances for these. Though, it is possible to drop these in Lowland Shore's Offshore/Shore Fish. If you go to Lowlands, they will only drop during the day. I recommend aiming for higher Fishing Power to improve your chances."
                    break;

                // *
                // * LAKE FISH
                // * 
                case 'White Bass':
                case 'Sockeye':
                    guide.value.src = SnowdenDriftsLakeFish; 
                    guide.value.alt = 'Snowden Drifts Lake Fish';
                    guide.value.waypoint = '[&BLgAAAA=] -> [&BMADAAA=], Timberline: [&BEkCAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksLakeFish;
                    guide.value.description = "Should be a fairly common drop. Snowden would be the most reliable and populated option for pools. If you do not wish to waypoint, you could go to Timberline (refer to the 3rd waypoint)."
                    break;

                case 'Chain Pickerel':
                case 'Cerulean Salamander':
                case 'Glacial Snakehead':
                    guide.value.src = SnowdenDriftsLakeFish; 
                    guide.value.alt = 'Snowden Drifts Lake Fish';
                    guide.value.waypoint = '[&BLgAAAA=] -> [&BMADAAA=], Timberline: [&BEkCAAA=], Drizzlewood: [&BHIMAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksLakeFish;
                    guide.value.description = "There's a couple options. Snowden would be the most reliable and populated option for pools. If you do not wish to waypoint, you could go to Timberline (refer to the 3rd waypoint). If you want an even higher chance, could go to Drizzlewood (refer 4th waypoint). If, however, you do Drizzlewood, this method can only work if south has progressed and north has not because you need the 10% Morale Boost from the Quartermaster. I recommend aiming for higher Fishing Power to improve your chances."
                    break;


                // *
                // * NONE, OPEN WATER
                // *
                case 'Alewife':
                case 'Icefish':
                case 'Snow Crab':
                    guide.value.waypoint = '[&BH4CAAA=], [&BLgAAAA=]';
                    guide.value.minFishingPower = minFishingPower.shiverpeaksBorealFish
                    guide.value.description = "Any body of water in the Shiverpeaks region will do."
                    break;
            }
            break;

        // *
        // * WORLD REGION
        // *
        case 'World':
        case 'Any':
            switch (props.fish.name){
                case 'Moonfin Striker':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.waypoint = '[&BAIEAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "There are some areas in particular that have higher rates of Moonfin Striker because these drop tables, combined with over 900 fishing power, contain no exotic drops. As a replacement, since Moonfin can drop anywhere, it natrually fills that gap. In this case, Moonfin has a high drop rate of ~6% at 975 FP. Other areas that has high (but slightly less drop rates) are Offshore Fish, Desert Isles, or Boreal Fish, Shiverpeaks."
                    guide.value.bait = 'Any, except Freshwater Minnows, unless you also need Queenfish or Mud Skate.';
                    break;

                case 'Sunscale Striker':
                    guide.value.src = LionsArchCoastalFish; 
                    guide.value.alt = "Lion's Arch Coastal Fish";
                    guide.value.waypoint = '[&BDMEAAA=], [&BC8EAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanCoastalFish;
                    guide.value.description = "There are some areas in particular that have higher rates of Sunscale Striker because these drop tables, combined with over 900 fishing power, contain no exotic drops. As a replacement, since Sunscale can drop anywhere, it natrually fills that gap. In this case, Sunscale has a high drop rate of ~8% at 975 FP. Other areas that has high (but slightly less drop rates) are New Kaineng City, Coastal Fish and Astral Fish, Amnytas."
                    guide.value.bait = 'Any, except Shrimplings, unless you also need Holy Mackerel and Black Lionfish.';
                    break;


                default: 
                    guide.value.src = KessexHillsPollutedLakeFish; 
                    guide.value.alt = 'Kessex Hills Polluted Lake Fish';
                    guide.value.waypoint = '[&BAoAAAA=]';
                    guide.value.minFishingPower = minFishingPower.worldClassPollutedLakeFish;
                    guide.value.description = "For all of World Class and junk items, I recommend not focusing on completing it before others. These fishes will most likey be obtained passively as you finish the other achievements. If, however, you still need after completing all the others, fishing in Polluted Lake Fish drops lots of World Class fish and junk."
                    break;
            }
            break; 
    }
})

console.log('PROPS: ', props.fish); 
</script>