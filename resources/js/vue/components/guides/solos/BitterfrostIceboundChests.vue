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
import IceboundChest from '@/imgs/guides/solos/Bitterfrost_Icebound_Chests.webp'

// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

// *
// * FILL IN GUIDES AND PICTURES
// *
const guides = ref([
    {
        instruction: "Follow the arrows on the map below in a somewhat counterclockwise rotation. These chests will respawn per character AND per meta. Meaning, even after you gather chests on one character and then complete the meta, that character will be able to loot new chests. These will despawn when the meta champs are up so if you want to continue this, kill all 9 champs.",
        waypointName: "Sorrow's Eclipse Waypoint",
        waypointLink: "[&BH0JAAA=]",
        img: IceboundChest,
        alt: "Icebound Chest Route"
    },
])

</script>