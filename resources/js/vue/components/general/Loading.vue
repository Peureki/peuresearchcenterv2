<template>
    <div class="loading-container">
        <ProgressBar v-if="progress" :progress="progress"/>
        <img 
            class="loading-icon" 
            :src="RollingChoya" alt="Rolling Choya Loading" title="Loading data..."
            :style="{width: `${width}px`, height: `${height}px`}"
        >
    </div>
    
</template>

<script setup>
import ProgressBar from '@/js/vue/components/general/ProgressBar.vue'
import RollingChoya from '@/imgs/choyas/Rolling_Choya.png'
import { onMounted } from 'vue';

const props = defineProps({
    width: Number,
    height: Number,
    progress: {
        type: Number,
        default: 0,
    }
})

</script>

<style scoped>
.loading-container{
    position: fixed;
    display: flex;
    align-items: center;
    bottom: 0;
    right: 0;
    z-index: 10000000;
}

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