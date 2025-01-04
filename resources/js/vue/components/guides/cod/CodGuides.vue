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
import GendarranFieldsLakeFish from '@/imgs/guides/fishing/Gendarren_Fields_Lake_Fish.webp'
import GendarranRiverFish from '@/imgs/guides/fishing/Gendarran_Fields_River_Fish.webp'
import LionsArchCoastalFish from '@/imgs/guides/fishing/Lions_Arch_Coastal_Fish.webp'

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
    krytanCoastalFish: 450,
    krytanLakeFish: 400,
    krytanRiverFish: 350,
}


onMounted(() => {
    switch (props.fish.map){
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

        case 'World':
            switch (props.fish.name){
                

                case 'Moonfin Striker':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.waypoint = '[&BAIEAAA=]';
                    guide.value.minFishingPower = minFishingPower.krytanRiverFish;
                    guide.value.description = "There are some areas in particular that have higher rates of Moonfin Striker because these drop tables, combined with over 900 fishing power, contain no exotic drops. As a replacement, since Moonfin can drop anywhere, it natrually fills that gap. In this case, Moonfin has a high drop rate of ~6% at 975 FP. Other areas that has high (but slightly less drop rates) are Offshore Fish, Desert Isles, or Boreal Fish, Shiverpeaks."
                    guide.value.bait = 'Any, except Freshwater Minnows, unless you also need Queenfish or Mud Skate.';
                    break;
            }
            break; 
    }
})

console.log('PROPS: ', props.fish); 
</script>