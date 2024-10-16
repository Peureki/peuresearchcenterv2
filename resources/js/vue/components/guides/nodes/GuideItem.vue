<template>
    <div class="guide-and-label">
        <span class="inline">
            <p>{{ index }}. {{ waypointName }} 
            <span 
                v-if="waypointLink"
                class="inline-link" 
                @click="(e) => {
                    copyWaypoint(`${waypointLink}`); 
                    $emit('handleTooltipToggle', e)
                }"
            > 
            {{ waypointLink }}</span>
            <span v-if="waypointLink">.</span>
            {{ instruction }}</p>
        </span>
        <img class="map-guide" :src="img" :alt="alt" :title="alt">
    </div>
</template>

<script setup>
// *
// * INDIVIDUAL GUIDES FOR EACH GATHERING FARM
// * 
import { copyWaypoint } from '@/js/vue/composables/BasicFunctions';

const props = defineProps({
    index: Number,
    instruction: String, 
    waypointName: String, 
    waypointLink: String, 
    img: String, 
    alt: String, 
})

</script>

