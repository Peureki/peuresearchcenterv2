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
import axios from 'axios';

onMounted(async () => {
    await getAuthUser(); 

    if (user.value){
        getFishingAchievements();
    }
    

    //console.log('USER: ', user.value); 
})

const getFishingAchievements = async () => {
    try {
        const response = await axios.get('../api/user/achievements/fishing');

        if (response){
            console.log('RESPONSE: ', response.data); 
        }
    } catch (error) {
        console.log('Could not get fishing achievements: ', error); 
    }
}

</script>

<style scoped>

</style>