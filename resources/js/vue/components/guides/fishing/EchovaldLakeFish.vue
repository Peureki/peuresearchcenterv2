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
import LakeFish from '@/imgs/guides/fishing/Echovald_Wilds_Lake_Fish.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Head down and silghtly northeast from the waypoint. There will be 5 pools somewhat close together.",
        waypointName: "Qinkai Waypoint",
        waypointLink: "[&BNQMAAA=]",
    },
    {
        instruction: "Directly west will have about 4 very very close pools together. After the 4, head more west to grab an additional 1-3 more pools. Once you hit about 9 pools, it's safe to waypoint to the first as those should respawn at that point.",
        waypointName: "Mori Village Waypoint",
        waypointLink: "[&BMcMAAA=]",
        img: LakeFish,
        alt: "Lake Fish Guide",
    },
])

</script>