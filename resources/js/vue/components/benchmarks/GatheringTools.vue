<template>
    <div class="mobile-currency-container">
        <div v-for="(tool, index) in tools" class="mobile-currency-card">
            <div class="label-and-cta">
                <div class="img-and-label">
                    <img class="icon" :src="tool.icon" :alt="tool.name" :title="tool.name">
                    <p class="item-name" :style="{color: showRarityColor(tool.rarity)}">{{ tool.name }}{{ specialTool(tool.name) }}</p>
                </div>

                <div class="svg-ctas">
                    <svg @click="wiki(tool.name)" class="icon clickable" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                    </svg>

                    <svg 
                        class="arrow" 
                        :class="activeArrow(expand[index])"
                        @click="expand[index] = !expand[index];" 
                        width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                        <title>Details</title>
                    </svg>
                </div>
            </div>
            <div class="value-container">
                <div class="img-and-label">
                    <p class="small-subtitle">Max</p>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C8.68678 0 7.38642 0.258658 6.17317 0.761205C4.95991 1.26375 3.85752 2.00035 2.92893 2.92893C1.05357 4.8043 0 7.34784 0 10C0 12.6522 1.05357 15.1957 2.92893 17.0711C3.85752 17.9997 4.95991 18.7362 6.17317 19.2388C7.38642 19.7413 8.68678 20 10 20C12.6522 20 15.1957 18.9464 17.0711 17.0711C18.9464 15.1957 20 12.6522 20 10C20 8.68678 19.7413 7.38642 19.2388 6.17317C18.7362 4.95991 17.9997 3.85752 17.0711 2.92893C16.1425 2.00035 15.0401 1.26375 13.8268 0.761205C12.6136 0.258658 11.3132 0 10 0ZM14.2 14.2L9 11V5H10.5V10.2L15 12.9L14.2 14.2Z" fill="var(--color-text-dark-fade)"/>
                        <title>Max Cast Time</title>
                    </svg>
                    <p>{{ tool.max_cast }} ms</p>
                </div>
                <div class="img-and-label">
                    <p class="small-subtitle">Min</p>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C8.68678 0 7.38642 0.258658 6.17317 0.761205C4.95991 1.26375 3.85752 2.00035 2.92893 2.92893C1.05357 4.8043 0 7.34784 0 10C0 12.6522 1.05357 15.1957 2.92893 17.0711C3.85752 17.9997 4.95991 18.7362 6.17317 19.2388C7.38642 19.7413 8.68678 20 10 20C12.6522 20 15.1957 18.9464 17.0711 17.0711C18.9464 15.1957 20 12.6522 20 10C20 8.68678 19.7413 7.38642 19.2388 6.17317C18.7362 4.95991 17.9997 3.85752 17.0711 2.92893C16.1425 2.00035 15.0401 1.26375 13.8268 0.761205C12.6136 0.258658 11.3132 0 10 0ZM14.2 14.2L9 11V5H10.5V10.2L15 12.9L14.2 14.2Z" fill="var(--color-text-dark-fade)"/>
                        <title>Min Cast Time</title>
                    </svg>
                    <p :style="{color: isAnimationLocked(tool.animation_locked)}">{{ tool.min_cast }} ms</p>
                </div>
            </div>

            <!-- 
                *
                * UNIQUE STRIKES
                *
            -->
            <div v-if="expand[index]" class="details-container">
                <p v-if="tool.name == 'Unbound Magic Logging Pulse'">
                    By completing the full animation, it will add more strikes on top of the regular 3
                </p>

                <p v-else-if="tool.name == 'Unbound Magic Mining Beam'">
                    It will take a bit longer to get the first strike, but it will gather the 3 strikes in quicker succession than the regular animations.
                </p>

                <p v-else-if="tool.name == 'Choya Mining Tool'">
                    Regular gathering strikes, but the final strike will auto strike 2 more times, for a total of 5 per animation
                </p>

                <p v-else>Nothing unique for gathering strikes</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { wiki, activeArrow } from '@/js/vue/composables/BasicFunctions'
import { showRarityColor } from '@/js/vue/composables/FormatFunctions';

const props = defineProps({
    tools: Object,
})

// Individually allow each card to be expanded or not
// By default, have each card not expanded
const expand = ref(props.tools.map(() => false));
// If a tool has animation locked after the final strike, then color the text red
const isAnimationLocked = (isLocked) => {
    if (isLocked){
        console.log('merp');
        return 'var(--color-down)';
    }
}

const specialTool = (toolName) => {
    switch (toolName){
        case 'Unbound Magic Logging Pulse':
        case 'Unbound Magic Mining Beam':
        case 'Choya Mining Tool':
            return '*';
    }
}



</script>