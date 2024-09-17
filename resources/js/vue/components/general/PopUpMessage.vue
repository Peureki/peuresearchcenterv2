<template>
    <Transition name="fade">
        <p class="popup-message">{{ message }}</p>
    </Transition>
</template>

<script setup>

const props = defineProps({
    message: String,
})

</script>

<style scoped>
.popup-message{
    padding-block: var(--gap-general);
}

</style>