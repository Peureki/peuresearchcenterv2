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
import NayosianFish from '@/imgs/guides/fishing/Inner_Nayos_Nayosian_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "As an option, you can prep by traveling to the north side of the map and putting a personal waypoint with a pond of 3. You can go back to this personal waypoint after completing all the bottom pools.",
        waypointName: "Forward Bivouac Waypoint",
        waypointLink: "[&BHYOAAA=]",
        
    },
    {
        instruction: "Besides the optional north pond, you can start from the main waypoint. There will be a pond of 4 immediately ahead. After the 4, go as close as you can to the north edge of the pond and mount to the next pond. Mount Stealth 2.0 is super useful for this. You can repeat this farm by waypointing back.",
        img: NayosianFish,
        alt: "Nayosian Fish Guide"
    },
])

</script>