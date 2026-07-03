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
import FreshwaterTropicalFish from '@/imgs/guides/fishing/Eternitys_Garden_Freshwater_Tropical_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Head directly east of the waypoint. The route should be relatively straightforward in the body of water from the waypoint to the east side of the map. I do not recommend going to the north side of the water as it's more sparse and the waypoints either get locked or too far from the water.",
        waypointName: "Temple of Abnegation Waypoint",
        waypointLink: "[&BPoPAAA=]",
        img: FreshwaterTropicalFish,
        alt: "Freshwater Tropical Fish Guide",
    },
])

</script>