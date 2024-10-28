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
import ElonRiverlandsDesert from '@/imgs/guides/fishing/Elon_Riverlands_Desert_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "This farm requires a small amount of prep. From the waypoint, head south to where the green star is marked on the map below. Put a personal waypoint down as this section of the farm contains at least 13 nodes.",
        waypointName: "Skimmer Ranch Waypoint",
        waypointLink: "[&BGcKAAA=]",
        
    },
    {
        instruction: "After the 13, you can waypoint back to the Skimmer Ranch, do the 7 along the river, then personal waypoint back. Alternatively, it is possible to rollerbeetle from the Skimmer Ranch, to the pond on the west side, and rollerbeetling again from the pond to the south portion.",
        img: ElonRiverlandsDesert,
        alt: "Elon Riverlands Fish Guide"
    },
])

</script>