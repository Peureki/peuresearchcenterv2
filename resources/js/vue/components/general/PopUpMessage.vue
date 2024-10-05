<template>
    <Transition name="fade">
        <p class="small-subtitle">{{ message }}</p>
    </Transition>
</template>

<script setup>

const props = defineProps({
    message: String,
})

</script>