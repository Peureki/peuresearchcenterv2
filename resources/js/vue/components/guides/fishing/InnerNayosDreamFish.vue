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
import DreamFish from '@/imgs/guides/fishing/Inner_Nayos_Dream_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "To get to the farm, there is a ley line near and above the waypoint towards the south. Follow that and it will go almost above the south portion of the farm.",
        waypointName: "Forward Bivouac Waypoint",
        waypointLink: "[&BHYOAAA=]",
        
    },
    {
        instruction: "I recommend putting a personal waypoint at the very start. This will make at least another cycle of fishing pools a lot easier to complete.",
    },
    {
        instruction: "It's possible to hit the middle pond with a Raptor, but I recommend Skyscale just to be safe. To get to the north pond, you need to Rollerbeetle. There will be a small doorway you can go through and go straight through it. Hitting the water may make your character bounce. Immediately swim to the top and deploy your skiff ASAP.",
    },
    {
        instruction: "To get to the north pond, you need to Rollerbeetle. There will be a small doorway you can go through and go straight through it. Hitting the water may make your character bounce. Immediately swim to the top and deploy your skiff ASAP.",
    },
    {
        instruction: "From here, if you have a personal waypoint, waypoint back. Otherwise, to go backwards, get as south as you can with your skiff in the north pond. Skyscale up, then immediatey, dash towards the door way. When you land, switch to Rollbeetle, use Bond of Vigor, and zoom to the middle pond. When you hit the water, go on your skiff ASAP.",
    },
    {
        instruction: "From the middle point, you can Skyscale up towards the south pond pretty easily. If you mess up in any of these steps, you may start questioning why you're even there and I completely understand.",
        img: DreamFish,
        alt: "Dream Fish Fish Guide"
    },
])

</script>