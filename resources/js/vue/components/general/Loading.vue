<template>
    <img 
        class="loading-icon" 
        :src="LoadingIcon" alt="Rolling Choya Loading" title="Loading data..."
        :style="{width: `${width}px`, height: `${height}px`}"
    >
</template>

<script setup>

import LoadingIcon from '@/imgs/icons/Rolling_Choya.png'
import { onMounted } from 'vue';

const props = defineProps({
    width: Number,
    height: Number,
})

</script>

<style scoped>

img.loading-icon{
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