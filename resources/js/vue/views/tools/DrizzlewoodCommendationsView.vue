<template>
    <Header page-name="Drizzlewood Commendations"/>
    <Nav>
        <!--
            *
            * API REFRESH PANEL
            *
        -->
        <template v-slot:countdown v-if="user">
            <div class="countdown-container" v-if="user.has_api_key">
                <div class="countdown">
                    <p>API Refresh</p>
                    <p>{{ formatTime(refreshCountdown) }}</p>
                </div>

                <p class="small-subtitle">Please allow 5-10 mins to update your achievements</p>                
            </div>
        </template>
    </Nav>
    <!-- <CurrencyPage
        page-name="Ash Legion Commendation"
        target-currency="Ash Legion Commendation"
        :currency-icon="Currency"
    /> -->

    <section class="main">
        <div class="content-section gap-general">
            <!-- 
                *
                * API KEY SUBMISSION FORM 
                * 
            -->
            <APIKeyForm v-if="user" :user="user"/>

            <div v-if="sortedCommendations" class="content-and-legend">
                <div class="flex-column-content">
                    <!--
                        *
                        * COMMENDATION VALUE TABLE
                        *
                    -->
                    <div class="table-container">
                        <table class="exchange-container">
                            <thead>
                                <tr>
                                    <th class="table-header" colspan="100%"><h3>Reward Tracks</h3></th>
                                </tr>
                                <tr>
                                    <th @click="sortCommendationsBy('name')"><h4>Name</h4></th>
                                    <th @click="sortCommendationsBy('total')"><h4>Total Value</h4></th>
                                    <th @click="sortCommendationsBy('currency')"><h4>/Commendation</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(commendation, index) in sortedCommendations" :key="index">
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
                                                v-for="gold in formatValue(commendation.trackValue)"
                                            >
                                                <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="gold-label-container">
                                            <span 
                                                class="gold-label"
                                                v-for="gold in formatValue(commendation.value)"
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
                
                <!--
                    *
                    * DAILY MATERIAL DONATIONS TABLE
                    *
                -->
                <div class="table-container">
                    <table class="exchange-container">
                        <thead>
                            <tr>
                                <th class="table-header" colspan="100%"><h3>Daily Material Donations</h3></th>
                            </tr>
                            <tr>
                                <th @click="sortDailyMaterialDonationsBy('name')"><h4>Commendation</h4></th>
                                <th @click="sortDailyMaterialDonationsBy('cost')"><h4>Cost</h4></th>
                                <th @click="sortDailyMaterialDonationsBy('value')"><h4>Value</h4></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(material, index) in dailyMaterialDonations" :key="index">
                                <td>
                                    <div class="img-and-label">
                                        <img :src="material.icon" :alt="material.name" :title="material.name">

                                        <p>{{ material.quantity }} {{ material.name }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="img-and-label">
                                        <img :src="material.exchange_icon" :alt="material.exchange_name" :title="material.exchange_name">

                                        <p>{{ material.exchange_rate }} {{ material.exchange_name }}</p>
                                    </div>
                                </td>
                                <td :style="{borderRight: `2px solid ${positiveOrNegative(material.value)}`}">
                                    <span class="gold-label-container">
                                        <span 
                                            class="gold-label"
                                            v-for="gold in formatValue(material.value)"
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
             

            <div v-if="rewardTracks" v-for="(achievement, index) in rewardTracks" :key="index" class="reward-track-container">
                <!--
                    *
                    * REWARD TRACK HEADER
                    *
                -->
                <div class="reward-track-header">
                    <div class="flex">
                        <!-- ACHIEVEMENT NAME -->
                        <p class="title">{{ commendationID(achievement.id).name }}</p>

                        <svg 
                            class="arrow"
                            @click="expand[index][0] = !expand[index][0]"
                            :class="activeArrow(expand[index][0])"
                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFFFFF"/>
                        </svg>
                    </div>
                    
                    
                    <!-- TOTAL REWARD TRACK VALUE -->
                    <div class="flex">
                        <p class="small-subtitle">Remaining: </p>
                        <span class="gold-label-container">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(rewardTrackValueLeft(achievement, sortedRewardTracks[index]))"
                            >
                                <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                            </span>
                        </span>
                    </div>
                </div>
                

                <div class="bar-container">
                    <!--
                        *
                        * REWARD TRACK BAR
                        *
                    -->
                    <div class="bar">
                        <!-- CURRENT REWARD TRACK PROGRESS -->
                        <div class="progress-container">
                            <p class="reward-track-percentage small-subtitle">{{ getProgressionPercentage(achievement.current, achievement.max) }}</p>

                            <p class="small-subtitle">{{ getProgressionAmount(achievement) }}</p>          
                        </div>
                        
                        
                        <!-- Create 20 lines for 20 rewards, except the last line -->
                        <span 
                            v-for="n in 20" 
                            class="progress-separator"
                            :style="{
                                left: `${n * 5}%`,
                                display: n === 20 ? 'none' : 'block'
                                }"
                        >
                        </span>
                        <!--
                            *
                            * PROGRESS BAR
                            *
                        -->
                        <span 
                            class="progress-bar" 
                            :style="{
                                width: `${(achievement.current/achievement.max) * 100}%`,
                                backgroundColor: commendationID(achievement.id).backgroundColor
                            }"
                        >
                        </span>
                        <!--
                            *
                            * REWARDS
                            *
                        -->
                        <span 
                            v-for="(n, subIndex) in 20" 
                            class="reward"
                            :style="{
                                left: `${n * 5}%`
                                }"
                        >
                            <img class="icon" :style="{opacity: opacityRewardsAchieved(achievement, subIndex)}" :src="getRewardTrackItem(sortedRewardTracks[index][subIndex]).icon" :alt="getRewardTrackItem(sortedRewardTracks[index][subIndex]).name" :title="getRewardTrackItem(sortedRewardTracks[index][subIndex]).name">
                        </span>
                    </div>
                    <!--
                        *
                        * FINAL REWARDS
                        *
                    -->
                    <div class="final-reward">
                        <img class="card-main-icon" :src="getRewardTrackItem(sortedRewardTracks[index][19]).icon">
                    </div>
                </div>

                <!--
                    *
                    * REWARD ITEM DETAILS
                    *
                -->
                <div v-if="expand[index][0]" class="drop-details-main-container">
                    <div v-for="(n, subIndex) in 20" class="drop-details-container" :style="{opacity: opacityRewardsAchieved(achievement, subIndex)}">
                        <div class="drop-details">
                            <!-- ICON, NAME -->
                            <div class="desc-details">
                                <img :src="getRewardTrackItem(sortedRewardTracks[index][subIndex]).icon" :alt="getRewardTrackItem(sortedRewardTracks[index][subIndex]).name" :title="getRewardTrackItem(sortedRewardTracks[index][subIndex]).name">
                                <p>{{ getRewardTrackItem(sortedRewardTracks[index][subIndex]).name }}</p>

                                <!-- TIER POSITION -->
                                <p class="small-subtitle">Tier: {{ subIndex + 1 }}</p>
                            </div>
                            
                            <div class="value-details">
                                <!-- VALUE -->
                                <span class="gold-label-container">
                                    <span 
                                        class="gold-label"
                                        v-for="gold in formatValue(getRewardTrackItem(sortedRewardTracks[index][subIndex]).value)"
                                    >
                                        <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                    </span>
                                </span>

                                <div class="details-ctas">
                                    <!-- WIKI -->
                                    <svg class="icon clickable" @click="wiki(getRewardTrackItem(sortedRewardTracks[index][subIndex]).name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="var(--color-link)"/>
                                        <title>Wiki</title>
                                    </svg>
                                    <svg 
                                        class="arrow"
                                        @click="expand[index][1][subIndex] = !expand[index][1][subIndex]"
                                        :class="activeArrow(expand[index][1][subIndex])"
                                        width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFFFFF"/>
                                    </svg>
                                </div>
                            </div>
                            
                        </div>

                        <!-- 
                            *
                            * SUBDROP DETAILS
                            *
                        -->
                        <div v-if="expand[index][1][subIndex]" class="sub-drop-details">
                            <div v-if="!sortedRewardTracks[index][subIndex].hasOwnProperty('0')" class="drop-details">
                                <div class="desc-details">
                                    <!-- SUBDROP ICON -->
                                    <img :src="sortedRewardTracks[index][subIndex].icon" :alt="sortedRewardTracks[index][subIndex].name" :title="sortedRewardTracks[index][subIndex].name">
                                    <!-- SUBDROP NAME -->
                                    <p>{{ sortedRewardTracks[index][subIndex].quantity }} {{ sortedRewardTracks[index][subIndex].name }}</p>
                                </div>
                                <div class="value-details">
                                    <!-- SUBDROP VALUE -->
                                    <span class="gold-label-container">
                                        <span 
                                            class="gold-label"
                                            v-for="gold in formatValue(sortedRewardTracks[index][subIndex].value)"
                                        >
                                            <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                        </span>
                                    </span>
                                </div>
                            </div>
                            

                            <template v-else>
                                <p v-if="sortedRewardTracks[index][subIndex][0].sample_size" class="small-subtitle">Sample size: {{ sortedRewardTracks[index][subIndex][0].sample_size }}</p>

                                <div v-for="subDrop in onlyNumericalProperties(sortedRewardTracks[index][subIndex])" class="drop-details">
                                    <div class="desc-details">
                                        <!-- SUBDROP ICON -->
                                        <img :src="subDrop.icon" :alt="subDrop.name" :title="subDrop.name">
                                        <!-- SUBDROP NAME -->
                                        <p>{{ formatToDecimal(subDrop.drop_rate) }} {{ subDrop.name }}</p>
                                    </div>
                                    <div class="value-details">
                                        <!-- SUBDROP VALUE -->
                                        <span class="gold-label-container">
                                            <span 
                                                class="gold-label"
                                                v-for="gold in formatValue(subDrop.value)"
                                            >
                                                <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                            </span>
                                        </span>

                                        <!-- WIKI -->
                                        <svg class="icon clickable" @click="wiki(subDrop.name)" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="var(--color-link)"/>
                                            <title>Wiki</title>
                                        </svg>
                                    </div>
                                </div>
                            </template>
                            <!-- <div v-if="!subDrop.hasOwnProperty('0')">
                                <p>{{ subDrop.name }}</p>

                                <div class="desc-details">
                                    <img :src="getSubReward(subDrop).icon" :alt="getSubReward(subDrop).name" :title="getSubReward(subDrop).name">
                                    <p>{{ getSubReward(subDrop).name }}</p>


                                    <p class="small-subtitle">Tier: {{ subIndex + 1 }}</p>
                                </div>
                            </div> -->
                            <!-- ICON, NAME -->
                            
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </section>

    <Footer/>

    <Loading v-if="!sortedCommendations || !rewardTracks" :width="200" :height="200"/>
</template>

<script setup>
import Header from '@/js/vue/components/general/Header.vue'
import Nav from '@/js/vue/components/general/Nav.vue'
import Loading from '@/js/vue/components/general/Loading.vue'

import { onMounted, onUnmounted, ref } from 'vue';
import { getAuthUser } from '@/js/vue/composables/Authentication';
import { user, includes, buyOrder, sellOrder, tax } from '@/js/vue/composables/Global';
import { formatValue, formatPercentage, formatToDecimal, positiveOrNegative, formatTime } from '@/js/vue/composables/FormatFunctions.js'
import { wiki, activeArrow, getItemBuyOrder, getItemSellOrder } from '@/js/vue/composables/BasicFunctions'
import axios from 'axios';

import dailyMaterialDonationsJSON from '@/js/vue/components/json/dailyMaterialDonations.json'
import APIKeyForm from '@/js/vue/components/general/APIKeyForm.vue';
import Footer from '@/js/vue/components/general/Footer.vue'

const commendations = ref(null),
    sortedCommendations = ref(null),
    // Sorted by closest reward track to be completed
    sortedRewardTracks = ref(null); 

const rewardTracks = ref(null);

const expand = ref(null),
    detailExpand = ref(null);

const dailyMaterialDonations = ref(dailyMaterialDonationsJSON); 

// The amount of time in seconds for API refresh (5mins)
const refreshCountdown = ref(300);

const startRefreshCountdown = setInterval(() => {
    refreshCountdown.value--;
}, 1000);

const refreshRewardTracks = setInterval(() => {
    console.log('Refreshing Reward Tracks');
    getUserRewardTrackProgress(); 
    refreshCountdown.value = 300; 
}, 300000)

const quartermasterExchangeableIDs = [
    19700, // Mithril
    19729, // Thick Leather Section
    19748, // Silk Scrap
    19722, // Elder Wood Log
    19725, // Ancient Wood Log
    19701, // Orichalcum Ore
    19745, // Gossamer Scrap
]
const quartermasterExchangeableData = ref(null); 

console.log('daily donations: ', dailyMaterialDonations);

const setDailyMaterialDonationValue = () => {
    dailyMaterialDonations.value.forEach(donation => {
        donation.value = materialDonationValue(donation);
    })
}

onMounted(async () => {
    await getQuartermasterMaterials();

    await getAuthUser(); 

    await getAllCommendations(); 
    setDailyMaterialDonationValue(); 

    console.log('set daily mat donation value: ', dailyMaterialDonations.value);

    if (user.value){
        console.log('USER FOUND: ', user.value);
        
        getUserRewardTrackProgress(); 

    }
})
onUnmounted(() => {
    clearInterval(refreshRewardTracks); 
    clearInterval(startRefreshCountdown);
})
// *
// * GET ALL DRIZZLEWOOD COMMENDATIONS
// * 
const getAllCommendations = async () => {
    try {
        const response = await fetch(`../api/currencies/drizzlewood-commendations/${JSON.stringify(includes.value)}/${sellOrder.value}/${tax.value}`); 
        const responseData = await response.json(); 

        sortedCommendations.value = responseData; 
        sortedCommendations.value.sort((a, b) => b.value - a.value); 

        console.log('COMMENDATION REPONSE: ', responseData); 

    } catch (error) {
        console.log('Could not get all commendations: ', error);
    }
}
// *
// * GET MATERIAL DONATION INFO
// * 
const getQuartermasterMaterials = async () => {
    try {
        const response = await axios.get(`../api/items/${JSON.stringify(quartermasterExchangeableIDs)}`);

        if (response){
            quartermasterExchangeableData.value = response.data; 
            console.log('quartermaster material response: ', response); 
        }

    } catch (error){
        console.log('Could not fetch quartermaster materials: ', error); 
    }
}
// *
// * GET USER'S DRIZZLEWOOD REAWRD TRACK PROGRESS
// * 
const getUserRewardTrackProgress = async () => {
    try {
        const response = await axios.get(`../api/user/achievements/drizzlewood-reward-tracks`);

        if (response){
            console.log('ACHIEVEMENT RESPONSE: ', response.data); 
            rewardTracks.value = response.data.userAchievements; 

            // SORT by reward tracks that have the most progress
            rewardTracks.value.sort((a, b) => {
                return (b.current - b.max) - (a.current - a.max); 
            })

            // SORT commendation.value into sortedRewardTracks.value by the indexes of their respective reward tracks
            const trackIDs = rewardTracks.value.map(track => track.id); 
            sortedRewardTracks.value = trackIDs.map(trackID => {
                return sortedCommendations.value.find(commendation => 
                    commendation.repeatableAchievementID == trackID || commendation.achievementID == trackID)
            });
            // console.log('track ids: ', trackIDs);
            // console.log('commendations map: ', sortedRewardTracks.value, commendations.value); 

            // Intilize all expand icons to be false if (repeatableRewardTrack.value)
            // FOR MAIN ITEMS it would be expand[index][0]
            // FOR DETAILED ITEMS it would be expand[index][1][subIndex]
            expand.value = rewardTracks.value.map(() => [
                false, 
                Array(20).fill(false),
            ]);

            console.log('expand: ', expand.value);
        }
    } catch (error){
        console.log("Could not get user's dwc achievements: ", error); 
    }
}

// *
// * SORT COMMENDATIONS
// *
const sortCommendationsBy = (request) => {
    switch (request){
        case 'currency':
            return sortedCommendations.value.sort((a, b) => b.value - a.value)

        case 'total':
            return sortedCommendations.value.sort((a, b) => b.trackValue - a.trackValue)

        case 'name':
            return sortedCommendations.value.sort((a, b) => a.name.localeCompare(b.name))
    }
}
// *
// * SORT DAILY MATERIAL DONATIONS
// *
const sortDailyMaterialDonationsBy = (request) => {
    switch (request){
        case 'value':
            return dailyMaterialDonations.value.sort((a, b) => b.value - a.value)

        case 'cost':
            return dailyMaterialDonations.value.sort((a, b) => a.exchange_name.localeCompare(b.exchange_name))

        case 'name':
            return dailyMaterialDonations.value.sort((a, b) => a.name.localeCompare(b.name))
    }
}

// *
// * RETURN MATERIAL DONATION VALUE
// *
const materialDonationValue = (material) => {
    const exchangeable = quartermasterExchangeableData.value.find(mat => mat.id == material.exchange_id);
    switch (material.name){
        case 'Charr Commendation':
            return (material.quantity * getCharrCommendationValue()) - (material.exchange_rate * getItemSellOrder(exchangeable));

        default:
            const commendation = sortedCommendations.value.find(commendation => commendation.id === material.id); 
            return (material.quantity * commendation.value) - (material.exchange_rate * getItemSellOrder(exchangeable))
    }
}

const getCharrCommendationValue = () => {
    // Object.keys since commendations are Objects with both numerial properties and named properties
    let value = 0;
    sortedCommendations.value.forEach(commendation => {
        value += commendation.value; 
    })
    return value / 6; 
}


// *
// * BASE ON COMMENDATION ID: 
// * - Change name
// * - Change background color
// * 
const commendationID = (id) => {
    switch (id){
        // Blood Legion
        case 5312:
        case 5278: 
            return {
                name: 'Glory to the Blood Legion',
                backgroundColor: 'var(--color-blood-legion-commendation)'
            }
        // Iron Legion
        case 5298:
        case 5286: 
            return {
                name: 'Glory to the Iron Legion',
                backgroundColor: 'var(--color-iron-legion-commendation)'
            }
        // Flame Legion
        case 5312:
        case 5334: 
            return {
                name: 'Glory to the Flame Legion',
                backgroundColor: 'var(--color-flame-legion-commendation)'
            }
        // Ash Legion
        case 5327:
        case 5338: 
            return {
                name: 'Glory to the Ash Legion',
                backgroundColor: 'var(--color-ash-legion-commendation)'
            }
        // Frost Legion
        case 5364:
        case 5356: 
            return {
                name: 'Death to the Corrupted',
                backgroundColor: 'var(--color-frost-legion-commendation)'
            }
        // Dominion 
        case 5403:
        case 5391: 
            return {
                name: 'Death to the Dominion',
                backgroundColor: 'var(--color-dominion-commendation)'
            }

        default: 
            return {
                backgroundColor: 'var(--color-up)'
            }
    }
}



const getRewardTrackItem = (reward) => {
    if (!reward.hasOwnProperty('0')){
        return {
            icon: reward.icon,
            name: reward.name,
            value: reward.value,
        } 
    } else {
        return {
            icon: reward[0].bag_icon,
            name: reward[0].bag_name,
            value: reward.value,
        } 
    }
}

// *
// * GET NEXT REAWRD
// * 
// * 1) Calc progress in the achievement (.current, .max)
// * 2) Each reward is 250 points out of 5000 (20 rewards total). Take the current progress, / 250, return respective reward in the track
// *
const nextReward = (achievement, track) => {
    const currentProgress = Math.floor(achievement.current / 250); 
    //console.log('next reward: ', track[currentProgress])
    return getRewardTrackItem(track[currentProgress]); 
}

const getProgressionPercentage = (min, max) => {
    return formatPercentage(min/max); 
}

const getProgressionAmount = (achievement) => {
    return `${achievement.current} / ${achievement.max}`
}

const opacityRewardsAchieved = (achievement, rewardIndex) => {
    const currentProgressIndex = Math.floor(achievement.current / 250); 
    return rewardIndex >= currentProgressIndex ? 1 : 0.5; 
}

// * 
// * Ex: Some commendation drops are a single drop, while some contain subdrops. Those subdrops contain numerical properties, but also a 'value' property that contains the overall value of that drop
// *
const onlyNumericalProperties = (drop) => {
    return Object.keys(drop)
        .filter((key) => !isNaN(Number(key)))
        .map((key) => drop[key])
}

const rewardTrackValueLeft = (achievement, track) => {
    // Object.keys since commendations are Objects with both numerial properties and named properties
    let value = 0;

    const currentProgressIndex = Math.floor(achievement.current / 250); 

    Object.keys(track).forEach((key, index) => {
        // Check on numerical keys 
        // If yes => continously add into value
        if (index >= currentProgressIndex){
            if (!isNaN(key)){
                value += track[key].value; 
            }
        }
    })
    return value; 
}

// * 
// * GET TOTAL VALUE OF REWARD TRACK
// * 
const totalRewardTrackValue = (commendation) => {
    // Object.keys since commendations are Objects with both numerial properties and named properties
    let value = 0;
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

<style scoped>
.reward-track-container{
    padding-bottom: calc(var(--gap-content));
}
.bar-container{
    display: flex;
    align-items: center;
    gap: var(--gap-content);
}
.reward-track-header{
    display: flex;
    justify-content: space-between;
}
.bar{
    position: relative; 
    width: 100%; 
    height: 30px;
    border: var(--border-general);
    border-radius: var(--border-radius-card);
}
.bar > span.progress-separator{
    position: absolute;
    width: 2px;
    height: 100%;
    background: var(--color-progress-separator);
    bottom: -50%;
    z-index: 3;
}
.progress-container{
    position: absolute;
    display: flex;
    gap: var(--gap-content);
    top: 50%;
    right: 0;
    transform: translate(-10%, -50%);
    z-index: 5;
}

.reward{
    position: absolute;
    bottom: -125%;
    z-index: 4;
    transform: translateX(-50%);
}
.progress-bar{
    position: absolute;
    width: 0px;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 2;
    transition: var(--transition-all-03s-ease);
    border-radius: var(--border-radius-card);
}
.next-reward-container{
    display: flex;
    gap: var(--gap-general);
}
.drop-details-main-container{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: var(--gap-general);
    padding-top: calc(var(--gap-content));
}
.drop-details-container{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
    border: var(--border-general);
    border-radius: var(--border-radius-card);
    padding: var(--gap-general);
    background-color: var(--color-bkg-fade);
}
.drop-details{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    gap: var(--gap-content);
}
.drop-details > p {
    white-space: nowrap;
}
.desc-details{
    display: flex;
    gap: var(--gap-general);
    align-items: center;
}
.desc-details > img{
    width: var(--img-width);
    height: var(--img-width);
}
.value-details{
    display: flex;
    gap: var(--gap-general);
}
.details-ctas{
    display: flex;
    gap: var(--gap-general);
    align-items: center;
}
.sub-drop-details{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
    padding: var(--gap-general);
    border-radius: var(--border-radius-card);
    background-color: var(--color-bkg-more-fade);
}
</style>