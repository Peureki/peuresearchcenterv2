<template>
    <img 
        class="loading-icon" 
        :src="RollingChoya" alt="Rolling Choya Loading" title="Loading data..."
        :style="{width: `${width}px`, height: `${height}px`}"
    >
</template>

<script setup>

import RollingChoya from '@/imgs/choyas/Rolling_Choya.png'
import { onMounted } from 'vue';

const props = defineProps({
    width: Number,
    height: Number,
})

</script>

<style scoped>

img.loading-icon{
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 10000000;
    animation: roll 1s linear infinite;
}
@keyframes roll{
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(-360deg);
    }
}

</style>