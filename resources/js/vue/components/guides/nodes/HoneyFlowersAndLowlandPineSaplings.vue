<template>
    <div class="guide-container">
        <h3>Route</h3>

        <button @click="(e) => {copyWaypoint(copyAllWaypoints(guides)); handleTooltipToggle(e)}">Copy all waypoints</button>

        <GuideItem
            v-for="(guide, index) in guides"
            :index="index + 1"
            :instruction="guide.instruction"
            :waypoint-name="guide.waypointName"
            :waypoint-link="guide.waypointLink"
            :img="guide.img"
            :alt="guide.alt"
            @handle-tooltip-toggle="handleTooltipToggle"
        />       
    </div>

    <Transition name="fade">
        <CursorTooltip v-if="cursorTooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { copyWaypoint, copyAllWaypoints } from '@/js/vue/composables/BasicFunctions';

// Cursor tooltip
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
import GuideItem from '@/js/vue/components/guides/nodes/GuideItem.vue';

// Picture guides
import LowlandShore from '@/imgs/guides/nodes/Honey_Flowers_And_Lowland_Pine_Saplings.webp'

const mouseX = ref(0),
    mouseY = ref(0),
    cursorTooltipToggle = ref(false);

// Get position of mouse cursor with some margins
// Then display tooltip for half a second
const handleTooltipToggle = (e) => {
    mouseX.value = e.clientX - 50;
    mouseY.value = e.clientY - 50;

    cursorTooltipToggle.value = true; 
    setTimeout(() => {
        cursorTooltipToggle.value = false; 
    }, 500)
}

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "From Moon Camp, head down and eastward. Follow the path through the arid area",
        waypointName: "Astral Waard Moon Camp Waypoint",
        waypointLink: "[&BCcPAAA=]",
        img: LowlandShore,
        alt: "Lowland Shore"
    },
])

</script>