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
import AstralFish from '@/imgs/guides/fishing/Amnytas_Astral_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "To get the maximum value out of this farm, place a personal waypoint northwest of this waypoint.",
        waypointName: "Bastion of STrength Waypoint",
        waypointLink: "[&BNMNAAA=]",
    },
    {
        instruction: "Then head to Nature and head down and west.",
        waypointName: "Bastion of the Nature Waypoint",
        waypointLink: "[&BDQOAAA=]",
    },
    {
        instruction: "Then waypoint and immediately skyscale up to a pond directly west. Personal waypoint back to reset. To continue this farm without the first pond, continue steps #2, #3",
        waypointName: "Bastion of Knowledge Waypoint",
        waypointLink: "[&BEIOAAA=]",
        img: AstralFish,
        alt: "Astral Fish Guide",
    },
])

</script>