<template>
    <Nav/>
    <main>  
        <Header page-name="Map Benchmarks"/>
        <button @click="getBenchmarks">Get Benchmarks</button>
    </main>
    
</template>

<script setup>
import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import axios from 'axios';

const getBenchmarks = async () => {
    try {
        const response = await axios.get(`../api/fetch-benchmarks`);
    } catch (error){
        console.log('Error getting benchmarks: ', error);
    }
}

</script>