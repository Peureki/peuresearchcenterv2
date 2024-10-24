<template>
    <div class="guide-container">
        <h3>Route</h3>

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
import IceboundChest from '@/imgs/guides/solos/Bitterfrost_Events.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "This is a very *chill* set of events that can be very easy to solo. Both meta and regular events. Throughout the ice floe, there are 9 braizers. They could either have a gear icon or a shield icon. If it's a gear, then you need to grab a torch from a lit brazier and apply it to apply/speed up the event. If it's a shield, you need to defend from incoming mobs. The more braziers that are lit, the faster the meta will spawn. Meta generally spawns ~55 minutes after it's last completion. When it starts getting dark, the braziers will go ham in activity.",
        waypointName: "Sorrow's Eclipse Waypoint",
        waypointLink: "[&BH0JAAA=]",
        img: IceboundChest,
        alt: "Icebound Chest Route"
    },
])

</script>