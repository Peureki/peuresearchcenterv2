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
import ShoreFish from '@/imgs/guides/fishing/Seitung_Province_Shore_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "There will be about 5 pools in the bay, all near the shore or port. There is a very thin canal of possibly 2 and another 2 at the west side of the map. When you finish the route, you could either waypoint back or take the optional route.",
        waypointName: "Village Waypoint",
        waypointLink: "[&BJ4MAAA=]",
    },
    {
        instruction: "Optional route: On the north side, there are about 3-4 more pools in close proximity. After you finish the 4, you can waypoint to the first waypoint.",
        waypointName: "Haiju Docks Waypoint",
        waypointLink: "[&BGQNAAA=]",
        img: ShoreFish,
        alt: "Shore Fish Guide",
    },
])

</script>