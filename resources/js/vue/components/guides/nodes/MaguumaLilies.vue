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
import DraconisMons1 from '@/imgs/guides/nodes/Maguuma_Lilies_Draconis_Mons_1.webp'
import DraconisMons2 from '@/imgs/guides/nodes/Maguuma_Lilies_Draconis_Mons_2.webp'
import DraconisMons3 from '@/imgs/guides/nodes/Maguuma_Lilies_Draconis_Mons_3.webp'
import DraconisMons4 from '@/imgs/guides/nodes/Maguuma_Lilies_Draconis_Mons_4.webp'

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
    {
        instruction: "Head uphill from the waypoint. When heading up, there will be updrafts and bouncing mushrooms. There is more likely a Jungle Plant on the cliffs than in the little valley on the right, but check the mini map to confirm.",
        waypointName: "Mariner Landing Waypoint",
        waypointLink: "[&BL0JAAA=]",
        img: DraconisMons1,
        alt: "Draconis Mons"
    },
    {
        instruction: "Follow the arrows as the Jungle Plants are scattered throughout this area. Head upward on the edge of the cliffs. When you get to an open area with ponds on the corners, Jungle Plants will most likely spawn closer to the walls and near the water. Then head even more upwards when you head south",
        img: DraconisMons2,
        alt: "Draconis Mons"
    },
    {
        instruction: "When you get to the point where the mini map doesn't show the last parts of the green area, head to where the orange area is marked on the map. There will be a skinny cliff towards the north with a leyline attached. Fly down and north from there. ",
        img: DraconisMons3,
        alt: "Draconis Mons"
    },
    {
        instruction: "From falling down, you'll see a platform ahead. Follow the arrows and you've reached the end of the route.",
        img: DraconisMons4,
        alt: "Draconis Mons"
    },
])

</script>