<template>
    <div class="guide-container">
        <h3>Guide</h3>

        <GuideItem
            v-for="(guide, index) in guides"
            :index="index + 1"
            :instruction="guide.instruction"
            :waypoint-name="guide.waypointName"
            :waypoint-link="guide.waypointLink"
            :img="guide.img"
            :alt="guide.alt"
            @handle-show-tooltip="showTooltip"
        />       
    </div>

    <Transition name="fade">
        <CursorTooltip v-if="tooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { handleCursorTooltip } from '@/js/vue/composables/MouseFunctions'

// Cursor tooltip
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
import GuideItem from '@/js/vue/components/guides/nodes/GuideItem.vue';

// Picture guides
import BorealFish from '@/imgs/guides/fishing/Thunderhead_Peaks_Boreal_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Start at the north-most part of the water. Most of the time there's a pool and that will be your starting point. Follow the line of Volatile Magic as your guide to Ice Floe.",
        waypointName: "Revolution's Heart Waypoint",
        waypointLink: "[&BKYLAAA=]",
    },
    {
        instruction: "When you get to Ice Floe, it's very broad. Most nodes are very spread out, but you should always total your amount of nodes to be around 10-11 per route. As long as you hit at least 9, you can waypoint back the first pools should respawn.",
        img: BorealFish,
        alt: "Boreal Fish Guide",
    },
])

</script>