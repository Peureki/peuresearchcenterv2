<template>
    <div class="guide-container">
        <h3>Route</h3>

        <button @click="(e) => {copyWaypoint(copyAllWaypoints(guides)); showTooltip(e)}">Copy all waypoints</button>

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
import { copyWaypoint, copyAllWaypoints } from '@/js/vue/composables/BasicFunctions';
import { handleCursorTooltip } from '@/js/vue/composables/MouseFunctions'

// Cursor tooltip
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
import GuideItem from '@/js/vue/components/guides/nodes/GuideItem.vue';

// Picture guides
import VerdantBrink from '@/imgs/guides/nodes/Flax_Verdant_Brink.webp'
import TangledDepths from '@/imgs/guides/nodes/Flax_Tangled_Depths.webp'
import DraconisMons from '@/imgs/guides/nodes/Flax_Draconis_Mons.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Drop down from waypoint",
        waypointName: "Jaka Itzel Waypoint",
        waypointLink: "[&BOAHAAA=]",
        img: VerdantBrink,
        alt: "Verdant Brink"
    },
    {
        instruction: "Head up from waypoint via either Spring or Skyscale",
        waypointName: "Ogre Camp Waypoint",
        waypointLink: "[&BMwHAAA=]",
        img: TangledDepths,
        alt: "Tangled Depths"
    },
    {
        instruction: "Drop down near this edge to a layer before the water. There will be a cave and at the end will have flax.",
        waypointName: "Heathen's Hold Waypoint",
        waypointLink: "[&BM0JAAA=]",
        img: DraconisMons,
        alt: "Draconis Mons"
    },
])
</script>