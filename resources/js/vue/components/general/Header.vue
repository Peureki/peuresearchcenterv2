<template>
    <header>
        <h1 id="page-header">{{ pageName }}</h1>
    </header>
</template>

<script setup>

const props = defineProps({
    pageName: String,
})

</script>