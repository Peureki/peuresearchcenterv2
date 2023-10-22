<template>
    <header>
        <h1>{{ pageName }}</h1>
    </header>
</template>

<script setup>

const props = defineProps({
    pageName: String,
})

</script>