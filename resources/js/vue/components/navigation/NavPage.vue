<template>
    <router-link class="page-link" :to="`/${category}/${url}`">
        <img class="icon" :src="icon" :alt="name" :title="name">
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

<style scoped>
@media (max-width: 768px){
    .page-link img{
        width: 30px;
        height: 30px;
    }
    .page-link p{
        font-size: var(--font-size-h6);
    }
}


</style>