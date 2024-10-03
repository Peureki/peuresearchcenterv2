<template>
    <div class="progress-bar-container">
        <div class="progress-bar" :style="{width: `${progress * 100}%`}">
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    progress: {
        type: Number,
        default: 0,
    }
})

</script>

<style scoped>
.progress-bar-container{
    width: 150px;
    height: 25px;
    background-color: var(--color-bkg-fade);
    border: var(--border-general);
}
.progress-bar{
    height: 100%;
    background-color: var(--color-up);
    transition: var(--transition-all-03s-ease);
}
</style>