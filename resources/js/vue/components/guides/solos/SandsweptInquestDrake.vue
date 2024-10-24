<template>
    <div class="guide-container">
        <h3>Route</h3>

        <p>To keep track of the event timers, I recommend my <router-link to="/timers/sandswept-isles" target="_blank">Sandswept Isles Timer Page</router-link>.</p>
        

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
import Guide from '@/imgs/guides/solos/Sandswept_Isles_Inquest_And_Drake.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "If the Specimen Chamber pre is up (purple portals), then prioritize that event until it's over. Otherwise, around the building has veteran Inquests. There is frequently a collection event that spawns and lasts for over 10 minutes. During that time, many normal Inquests surround and respawn very quickly. You can also turn in the event collection pieces to complete the event (need at least 30 seconds of the remaining time). Specimen Chamber has a 45 minute respawn timer after defeating the bosses and the collection event has a ~12 minute respawn timer.",
        waypointName: "Anniogel Encampment Waypoint",
        waypointLink: "[&BCULAAA=]",
        img: Guide,
        alt: "Sandswept Inquest/Drake Route"
    },
])

</script>