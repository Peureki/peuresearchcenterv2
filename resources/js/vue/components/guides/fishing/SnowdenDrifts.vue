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
import LakeFish from '@/imgs/guides/fishing/Snowden_Drifts_Lake_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "There are about 4-5 pools within the lake next the waypoint. From there, head south and there should be 2 more.",
        waypointName: "Isenfall Waypoint",
        waypointLink: "[&BLgAAAA=]",
    },
    {
        instruction: "After the first 7, waypoint and Valslake will have at least 3 more pools. Waypoint to the first to cycle again.",
        waypointName: "Valslake Waypoint",
        waypointLink: "[&BMADAAA=]",
        img: LakeFish,
        alt: "Lake Fish Guide",
    },
])

</script>