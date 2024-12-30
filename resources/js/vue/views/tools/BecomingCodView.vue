<template>
    <Nav/>
    <Header page-name="Becoming Cod"/>

    <section class="main">
        <div class="content-section">
            <p>Merp</p>
        </div>
        
    </section>

    <Footer/>
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'

import { getAuthUser } from '@/js/vue/composables/Authentication';

import { user } from '@/js/vue/composables/Global'
import { onMounted } from 'vue';

onMounted(async () => {
    await getAuthUser(); 

    console.log('USER: ', user.value); 
})

</script>

<style scoped>

</style>