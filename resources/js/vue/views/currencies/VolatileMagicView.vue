<template>
    <Nav/>
    <main>
        <Header page-name="Volatile Magic"/>
        <table class="vm" ref="vmTable">
            <thead>
                <tr>
                    <th colspan="4"><h4>Best Value</h4></th>
                </tr>
                <tr>
                    <th @click="sortTable(vmTable, 0, 'alphabet')"><h5>Name</h5></th>
                    <th @click="sortTable(vmTable, 1, 'gold')"><h5>/Shipment</h5></th>
                    <th @click="sortTable(vmTable, 2, 'gold')"><img src="@/imgs/icons/Volatile_Magic.png" alt="Volatile Magic" title="Volatile Magic"></th>
                    <th><h5>Info</h5></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="shipment in shipments">
                    <td>{{ shipment.name }}</td>
                    <td class="gold">
                        <span v-for="currency in formatValue(shipment.shipmentValue)">
                            {{ currency.value }}<img :src="currency.src" :alt="currency.alt" :title="currency.alt">
                        </span>
                    </td>
                    <td class="gold">
                        <span v-for="currency in formatValue(shipment.currencyValue)">
                            {{ currency.value }}<img :src="currency.src" :alt="currency.alt" :title="currency.alt">
                        </span>
                    </td>
                    <td @click="getDetails(shipment.name)">
                        <span class="cta">
                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                            </svg>
                        </span>
                        
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <p v-for="shipment in vm">{{ shipment.currencyValue }}</p> -->
        <button type="button" @click="merp">Merp</button>

        <table class="vmDetails" ref="vmDetails">
            <thead>
                <tr>
                    <th colspan="4"><h4>Details</h4></th>
                </tr>
                <tr>
                    <th @click="sortTable(vmTable, 0, 'alphabet')"><h5>Name</h5></th>
                    <th @click="sortTable(vmTable, 1, 'gold')"><h5>{{ priceSetting }}</h5></th>
                    <th @click="sortTable(vmTable, 2, 'gold')"><h5>Drop Rate</h5></th>
                    <th @click="sortTable(vmTable, 3, 'gold')"><h5>Value</h5></th>
                </tr>
            </thead>
        </table>

    </main>
    
</template>

<script setup>
import { ref, onMounted } from 'vue'

import Header from '@/js/vue/components/general/Header.vue'

import Nav from '@/js/vue/components/Nav.vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { sortTable } from '@/js/vue/composables/SortFunctions.js'

const shipments = ref(null),
    vmTable = ref(null);

const priceSetting = ref(localStorage.priceSetting);

// Send a request to get VM
// use the localStorage priceSetting and taxSetting as params 
const getVM = async () => {
    try {
        const response = await fetch(`../api/currencies/volatile-magic/${localStorage.priceSetting}/${localStorage.taxSetting}`);
        const responseData = await response.json(); 
        shipments.value = responseData;
    } catch (error) {
        console.log('Error fetching data: ', error);
    }
}
const getDetails = (name) => {
    console.log(name);
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