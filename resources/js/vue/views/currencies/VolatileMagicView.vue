<template>
    <Nav/>
    <main>
        <Header page-name="Volatile Magic"/>
        <table class="vm">
            <thead>
                <tr>
                    <th colspan="4"><h4>Header</h4></th>
                </tr>
                <tr>
                    <th><h5>Name</h5></th>
                    <th><h5>/Shipment</h5></th>
                    <th><h5>VM</h5></th>
                    <th><h5>Info</h5></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="shipment in shipments">
                    <td>{{ shipment.name }}</td>
                    <td>{{ formatValue(shipment.shipmentValue) }}</td>
                    <td>{{ shipment.currencyValue }}</td>
                </tr>
            </tbody>
        </table>
        <!-- <p v-for="shipment in vm">{{ shipment.currencyValue }}</p> -->
        <button type="button" @click="merp">Merp</button>
    </main>
    
    
</template>

<script setup>
import { ref, onMounted } from 'vue'

import Header from '@/js/vue/components/general/Header.vue'

import Nav from '@/js/vue/components/Nav.vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'

const shipments = ref(null);

const getVM = async () => {
    try {
        const response = await fetch(`../api/currencies/volatile-magic/${localStorage.priceSetting}/${localStorage.taxSetting}`);
        const responseData = await response.json(); 
        shipments.value = responseData;
    } catch (error) {
        console.log('Error fetching data: ', error);
    }
}

const merp = () => {
    console.log(localStorage.taxSetting);
}

onMounted(() => {
    getVM(); 
})

</script>

<style scoped>
</style>