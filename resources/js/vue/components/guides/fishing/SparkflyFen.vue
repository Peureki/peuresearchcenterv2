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
import SaltwaterFish from '@/imgs/guides/fishing/Sparkfly_Fen_Saltwater_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Most of the pools will be near the shore of Leeshore Gauntlet. Should be a straightforward circle route. Some pools may have a large distance between each other.",
        waypointName: "Brooloonu Waypoint",
        waypointLink: "[&BNEBAAA=]",
        img: SaltwaterFish,
        alt: "Saltwater Fish Guide",
    },
])

</script>