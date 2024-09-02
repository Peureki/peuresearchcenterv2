<template>
    <router-link class="page-link" :to="`/${category}/${url}`">
        <img :src="icon" :alt="name" :title="name">
        <p>{{ name }}</p>
    </router-link>
</template>

<script setup>

const props = defineProps({
    category: String, 
    url: String,
    name: String,
    icon: String, 
})

</script>