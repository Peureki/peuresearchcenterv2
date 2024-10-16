<template>
    <div class="guide-container">
        <h3>Route</h3>

        <button @click="(e) => {copyWaypoint(copyAllWaypoints(guides)); handleTooltipToggle(e)}">Copy all waypoints</button>

        <GuideItem
            v-for="(guide, index) in guides"
            :index="index + 1"
            :instruction="guide.instruction"
            :waypoint-name="guide.waypointName"
            :waypoint-link="guide.waypointLink"
            :img="guide.img"
            :alt="guide.alt"
            @handle-tooltip-toggle="handleTooltipToggle"
        />       
    </div>

    <Transition name="fade">
        <CursorTooltip v-if="cursorTooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { copyWaypoint, copyAllWaypoints } from '@/js/vue/composables/BasicFunctions';

// Cursor tooltip
import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
import GuideItem from '@/js/vue/components/guides/nodes/GuideItem.vue';

// Picture guides
import BloodstoneFen1 from '@/imgs/guides/nodes/Maguuma_Lilies_Bloodstone_Fen_1.webp'
import BloodstoneFen2 from '@/imgs/guides/nodes/Maguuma_Lilies_Bloodstone_Fen_2.webp'

const mouseX = ref(0),
    mouseY = ref(0),
    cursorTooltipToggle = ref(false);

// Get position of mouse cursor with some margins
// Then display tooltip for half a second
const handleTooltipToggle = (e) => {
    mouseX.value = e.clientX - 50;
    mouseY.value = e.clientY - 50;

    cursorTooltipToggle.value = true; 
    setTimeout(() => {
        cursorTooltipToggle.value = false; 
    }, 500)
}

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Start with the platform to the left of the airship. Fly across platforms labeled in orange and when you get to the bottom left-most, drop down.",
        waypointName: "Soulkeeper's Airship Waypoint",
        waypointLink: "[&BEsJAAA=]",
        img: BloodstoneFen1,
        alt: "Bloodstone Fen"
    },
    {
        instruction: "From dropping down, head east to the ground. Jungle Plants will be scattered all around the green parts of the ground and on the cliffs.",
        img: BloodstoneFen2,
        alt: "Bloodstone Fen"
    },
])

</script>