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

const filter = ['Volatile Magic'],
    encodedFilter = encodeURIComponent(JSON.stringify(filter));

const merp = `../api/currencies/${encodedFilter}/${localStorage.sellOrderSetting}/${localStorage.taxSetting}`;

const getTable = async () => {
    const response = await fetch(merp); 
    const data = await response.json(); 
    console.log('merp: ', data);
}

getTable(); 

</script>