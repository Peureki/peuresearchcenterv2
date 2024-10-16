<template>
    <div class="cursor-tooltip" :style="{top: `${mouseY}px`, left: `${mouseX}px`}">
        <p>{{ message }}</p>
    </div>
</template>

<script setup>

const props = defineProps({
    message: String,
    mouseX: Number,
    mouseY: Number,
})
</script>

<style scoped>
.cursor-tooltip{
    position: fixed;
    z-index: 1000000;
    padding: var(--gap-general);
    background-color: var(--color-bkg);
    border: var(--border-tooltip);
}
</style>