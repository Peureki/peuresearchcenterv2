<template>
    <div class="guide-container">
        <h3>Route</h3>

        <p>Credits: pieffff.2065. This is a slightly modified route.</p>

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
import LowlandShore from '@/imgs/guides/nodes/Honey_Flowers_And_Lowland_Pine_Saplings.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Follow the arrows on the map. Because this map is somewhat straightforward, you can rollerbeetle for most of the way. Otherwise use Jackal or Warclaw and not Raptor for the hills.",
        waypointName: "Hot Springs Waypoint",
        waypointLink: "[&BMkOAAA=]",
        img: LowlandShore,
        alt: "Lowland Shore"
    },
])

</script>