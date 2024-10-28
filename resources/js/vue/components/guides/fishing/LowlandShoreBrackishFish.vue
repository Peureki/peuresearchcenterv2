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
import BrackishFish from '@/imgs/guides/fishing/Lowland_Shore_Brackish_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Start by flying down to where it starts becoming a river. You can put an optinonal personal waypoint here as there is a Bee-Tree to reset your cooldowns when you come back.",
        waypointName: "Journeykin Outpost Waypoint",
        waypointLink: "[&BPsOAAA=]",
    },
    {
        instruction: "After 3, go all the way down from the waypoint. Head downstream and there will be more pools. You can skip the Freshwater pools as they seem to have a less likely chance to drop Oscar.",
        waypointName: "Autumn's Vale Waypoint",
        waypointLink: "[&BC4PAAA=]",
    },
    {
        instruction: "Then finally, head upstream and there will be 2 more pools.",
        waypointName: "Harvest Shore Waypoint",
        waypointLink: "[&BN8OAAA=]",
        img: BrackishFish,
        alt: "Brackish Fish Guide",
    },
])

</script>