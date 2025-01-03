<template>
    <p>Waypoint: 
        <a @click="(e) => {copyWaypoint(`${guide.waypoint}`); showTooltip(e)}">{{ guide.waypoint }}</a>
    </p>

    <div class="img-and-label">
        <p>Minimum Fishing Power: </p>
        <img :src="FishingPower" alt="Fishing Power" title="Fishing Power">
        <p>{{ guide.minFishingPower }}</p>
    </div>

    <div class="img-and-label">
        <p>Bait:</p>
        <img v-if="fish.bait_name" :src="fish.bait_icon" :alt="baitName" :title="baitName">
        <p>{{ baitName }}</p>
    </div>

    <p>{{ guide.description }}</p>
    <img class="map-guide" :src="guide.src" :alt="guide.alt" :title="guide.title">

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

import FishingPower from '@/imgs/icons/fishes/Green_Hook.png'
// * 
// * PHOTOS OF FISH GUIDES
// * 
import GendarranRiverFish from '@/imgs/guides/fishing/Gendarran_Fields_River_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

const props = defineProps({
    fish: Object
})

const guide = ref({}); 

// * 
// * LIST of all min fishing powers 
// * 
// * mapNamePoolName: ###
// *
const minFishingPower = {
    gendarranFieldsRiverFish: 350
}

const baitName = computed(() => {
    if (!guide.value.bait){
        return props.fish.bait_name ? props.fish.bait_name : 'Any'
    }
    else {
        return guide.value.bait
    }

        
})

onMounted(() => {
    switch (props.fish.map){
        case 'World':
            switch (props.fish.name){
                case 'Goldfish':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.description = "There are some areas in particular that have higher rates of Moonfin Striker because these drop tables contain no exotic drops. As a replacement, since Moonfin can drop anywhere, it natrually fills that gap. In this case, Moonfin has a high drop rate of ~6% at 975 FP. Other areas that have similar drop rates are Offshore Fish, Desert Isles, or Boreal Fish, Shiverpeaks."
                    break;

                case 'Moonfin Striker':
                    guide.value.src = GendarranRiverFish; 
                    guide.value.alt = 'Gendarran Fields River Fish';
                    guide.value.waypoint = '[&BAIEAAA=]';
                    guide.value.bait = 'Any, except Freshwater Minnows, unless you also need Queenfish or Mud Skate.';
                    guide.value.minFishingPower = minFishingPower.gendarranFieldsRiverFish;
                    guide.value.description = "There are some areas in particular that have higher rates of Moonfin Striker because these drop tables, combined with over 900 fishing power, contain no exotic drops. As a replacement, since Moonfin can drop anywhere, it natrually fills that gap. In this case, Moonfin has a high drop rate of ~6% at 975 FP. Other areas that has high (but slightly less drop rates) are Offshore Fish, Desert Isles, or Boreal Fish, Shiverpeaks."
                    break;
            }
            break; 
    }
})

console.log('PROPS: ', props.fish); 
</script>