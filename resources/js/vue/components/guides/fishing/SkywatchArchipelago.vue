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
import FracturedFreshwaterFish from '@/imgs/guides/fishing/Skywatch_Archipelago_Fractured_Freshwater_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "From the waypoint, head up to the higher elevated pond. Start there as it's a lot easier to go down than up. When you get the end of the bottom pond, there will be an updraft that you need to take to get back to the start. Make sure you land in the water as quick as possible to deploy your skiff.",
        waypointName: "Observation Camp Waypoint",
        waypointLink: "[&BEYOAAA=]",
        img: FracturedFreshwaterFish,
        alt: "Fractured Freshwater Fish Guide",
    },
])

</script>