<template>
    <div class="img-and-label">
        <img :src="Info" alt="Info" title="Info">
        <p>
            <span>{{ message }}</span>
            <span class="link" @click="(e) => {copyWaypoint(`${link}`); showTooltip(e)}">{{ link }}</span>
        </p>
    </div>

    <Transition name="fade">
        <CursorTooltip v-if="tooltipToggle" message="Copied!" :mouseX="mouseX" :mouseY="mouseY" />
    </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { copyWaypoint } from '@/js/vue/composables/BasicFunctions'
import { handleCursorTooltip } from '@/js/vue/composables/MouseFunctions';

import CursorTooltip from '@/js/vue/components/general/CursorTooltip.vue';
// IMGS
import Info from '@/imgs/svgs/info.svg'

const props = defineProps({
    message: String, 
    link: String, 
})
// Initilize tooltip vars
const { mouseX, mouseY, tooltipToggle, showTooltip } = handleCursorTooltip(); 

</script>

<style scoped>
.img-and-label{
    width: var(--w-p-size);
}

</style>