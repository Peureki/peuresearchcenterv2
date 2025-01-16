<template>
    <Header page-name="Drizzlewood Commendations"/>
    <Nav/>
    <!-- <CurrencyPage
        page-name="Ash Legion Commendation"
        target-currency="Ash Legion Commendation"
        :currency-icon="Currency"
    /> -->

    <section class="main">
        <div class="content-section">
            <div v-if="commendations" class="overflow-x">
                <table class="exchange-container">
                    <thead>
                        <tr>
                            <th class="table-header" colspan="100%"><h3>Reward Tracks</h3></th>
                        </tr>
                        <tr>
                            <th><h4>Name</h4></th>
                            <th><h4>Total Value</h4></th>
                            <th><h4>/Commendation</h4></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(commendation, index) in commendations" :key="index">
                            <td>
                                <div class="img-and-label">
                                    <img :src="commendation.icon" :alt="commendation.name" :title="commendation.name">
                                    <p>{{ commendation.name }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="gold-label-container">
                                    <span 
                                        class="gold-label"
                                        v-for="gold in formatValue(totalValue(commendation))"
                                    >
                                        <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                    </span>
                                </span>
                            </td>
                            <td>
                                <span class="gold-label-container">
                                    <span 
                                        class="gold-label"
                                        v-for="gold in formatValue(totalValue(commendation)/5000)"
                                    >
                                        <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>
import Header from '@/js/vue/components/general/Header.vue'
import Nav from '@/js/vue/components/general/Nav.vue'
import CurrencyPage from '@/js/vue/components/general/CurrencyPage.vue'

import Currency from '@/imgs/icons/Ash_Legion_Commendation.png'

import { onMounted, ref } from 'vue';
import { getAuthUser } from '@/js/vue/composables/Authentication';
import { user, includes, buyOrder, sellOrder, tax } from '@/js/vue/composables/Global';
import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import axios from 'axios';

const commendations = ref(null); 


onMounted(async () => {
    getAllCommendations(); 
    await getAuthUser(); 

    if (user.value){
        console.log('USER FOUND: ', user.value);
        getUserRewardTrackProgress(); 
    }
})

// *
// * GET USER'S DRIZZLEWOOD REAWRD TRACK PROGRESS
// * 
const getUserRewardTrackProgress = async () => {
    try {
        const response = await axios.get(`../api/user/achievements/drizzlewood-reward-tracks`);

        if (response){
            console.log('ACHIEVEMENT RESPONSE: ', response.data); 
        }
    } catch (error){
        console.log("Could not get user's dwc achievements: ", error); 
    }
}

// *
// * GET ALL DRIZZLEWOOD COMMENDATIONS
// * 
const getAllCommendations = async () => {
    try {
        const response = await fetch(`../api/currencies/drizzlewood-commendations/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`); 
        const responseData = await response.json(); 

        commendations.value = responseData; 

        console.log('COMMENDATION REPONSE: ', responseData); 

    } catch (error) {
        console.log('Could not get all commendations: ', error);
    }
}

// * 
// * GET TOTAL VALUE OF REWARD TRACK
// * 
const totalValue = (commendation) => {
    // Object.keys since commendations are Objects with both numerial properties and named properties
    let value = 0,
        subValue = 0; 
    Object.keys(commendation).forEach(key => {
        // Check on numerical keys 
        // If yes => continously add into value
        if (!isNaN(key)){
            value += commendation[key].value; 
        }
    })

    return value; 
}
</script>