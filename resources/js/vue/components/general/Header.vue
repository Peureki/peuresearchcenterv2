<template>
    <header>
        <h1>{{ pageName }}</h1>
    </header>
    
</template>

<script setup>
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue';

const props = defineProps({
    pageName: String,
})

</script>

<style scoped>

header{
    border-bottom: var(--border-general);
}
/* Temp */
section.main{
    padding-block: var(--gap-general);
}
@media (max-width: 768px){
    header{
        padding-left: unset;
        padding: var(--padding-mobile-general);
        padding-top: calc(var(--padding-general) * 2 + 60px);
    }
}

</style>