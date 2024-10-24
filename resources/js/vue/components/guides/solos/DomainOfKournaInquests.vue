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
import Guide from '@/imgs/guides/solos/Domain_Of_Kourna_Inquests.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Lots of Inquests gathered inside the cave. When you go outside, there will be groups of 3 throughout. If the meta is NOT active and you see a cannon event above the cliffs, that will infinitely spawn Inquests until the event is complete. If you do that, focus on the mobs and not the cannon.",
        waypointName: "Apizmic Grounds Waypoint",
        waypointLink: "[&BFALAAA=]",
        img: Guide,
        alt: "Domain of Kourna Inquest Route"
    },
])

</script>