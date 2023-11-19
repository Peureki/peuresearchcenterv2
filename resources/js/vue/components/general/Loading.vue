<template>
    <img class="loading-icon" :src="LoadingIcon" alt="Rolling Choya Loading" title="Loading data...">
</template>

<script setup>

import LoadingIcon from '@/imgs/icons/Rolling_Choya.png'

</script>

<style scoped>

img.loading-icon{
    width: 200px;
    height: 200px;
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