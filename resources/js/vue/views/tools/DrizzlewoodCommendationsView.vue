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
            <!--
                *
                * COMMENDATION VALUE TABLE
                *
            -->
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
                                        v-for="gold in formatValue(totalRewardTrackValue(commendation))"
                                    >
                                        <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                    </span>
                                </span>
                            </td>
                            <td>
                                <span class="gold-label-container">
                                    <span 
                                        class="gold-label"
                                        v-for="gold in formatValue(totalRewardTrackValue(commendation)/5000)"
                                    >
                                        <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> 

            <div v-if="repeatableRewardTracks" v-for="(achievement, index) in repeatableRewardTracks" :key="index" class="reward-track-container">

                <div class="reward-track-header">
                    <!-- ACHIEVEMENT NAME -->
                    <p class="title">{{ commendationID(achievement.id).name }}</p>
                    
                    <!-- TOTAL REWARD TRACK VALUE -->
                    <span class="gold-label-container">
                        <span 
                            class="gold-label"
                            v-for="gold in formatValue(totalRewardTrackValue(sortedCommendations[index]))"
                        >
                            <p>{{ gold.value }}</p><img :src="gold.src" :alt="gold.alt" :title="gold.title">
                        </span>
                    </span>
                </div>
                

                <div class="reward-track-bar-container">
                    <!--
                        *
                        * REWARD TRACK BAR
                        *
                    -->
                    <div class="reward-track-bar">
                        <!-- CURRENT REWARD TRACK PROGRESS -->
                        <div class="reward-track-progress-container">
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
                            <img class="icon" :src="getRewardTrackItem(commendations[index][subIndex]).icon" :alt="getRewardTrackItem(commendations[index][subIndex]).name" :title="getRewardTrackItem(commendations[index][subIndex]).name">
                        </span>
                    </div>
                    <!--
                        *
                        * FINAL REWARDS
                        *
                    -->
                    <div class="final-reward">
                        <img class="card-main-icon" :src="getRewardTrackItem(commendations[index][19]).icon">
                    </div>
                </div>
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
import { formatValue, formatPercentage } from '@/js/vue/composables/FormatFunctions.js'
import axios from 'axios';

import Choya from '@/imgs/icons/Choya_Mining_Tool.png'

const commendations = ref(null),
    sortedCommendations = ref(null); 

const repeatableRewardTracks = ref(null);

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
            repeatableRewardTracks.value = response.data.repeatableAchievements; 

            // SORT by reward tracks that have the most progress
            repeatableRewardTracks.value.sort((a, b) => {
                return (b.current - b.max) - (a.current - a.max); 
            })

            // SORT commendation.value into sortedCommendations.value by the indexes of their respective reward tracks
            const trackIDs = repeatableRewardTracks.value.map(track => track.id); 
            sortedCommendations.value = trackIDs.map(trackID => {
                return commendations.value.find(commendation => commendation.repeatableAchievementID == trackID)
            });
            // console.log('track ids: ', trackIDs);
            // console.log('commendations map: ', sortedCommendations.value, commendations.value); 
        }
    } catch (error){
        console.log("Could not get user's dwc achievements: ", error); 
    }
}




// *
// * BASE ON COMMENDATION ID: 
// * - Change name
// * - Change background color
// * 
const commendationID = (id) => {
    switch (id){
        case 5278: // Blood Legion
            return {
                name: 'Glory to the Blood Legion',
                backgroundColor: 'var(--color-blood-legion-commendation)'
            }

        case 5286: // Iron Legion
            return {
                name: 'Glory to the Iron Legion',
                backgroundColor: 'var(--color-iron-legion-commendation)'
            }

        case 5334: // Flame Legion
            return {
                name: 'Glory to the Flame Legion',
                backgroundColor: 'var(--color-flame-legion-commendation)'
            }

        case 5338: // Ash Legion
            return {
                name: 'Glory to the Ash Legion',
                backgroundColor: 'var(--color-ash-legion-commendation)'
            }

        case 5356: // Frost Legion
            return {
                name: 'Death to the Corrupted',
                backgroundColor: 'var(--color-frost-legion-commendation)'
            }

        case 5391: // Dominion 
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

const getRewardTrackItem = (reward) => {
    if (!reward.hasOwnProperty('0')){
        return {
            icon: reward.icon,
            name: reward.name
        } 
    } else {
        return {
            icon: reward[0].bag_icon,
            name: reward[0].bag_name,
        } 
    }
}

const getProgressionPercentage = (min, max) => {
    return formatPercentage(min/max); 
}

const getProgressionAmount = (achievement) => {
    return `${achievement.current} / ${achievement.max}`
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
.reward-track-bar-container{
    display: flex;
    align-items: center;
    gap: var(--gap-content);
}
.reward-track-header{
    display: flex;
    justify-content: space-between;
}
.reward-track-bar{
    position: relative; 
    width: 100%; 
    height: 30px;
    border: var(--border-general);
    border-radius: var(--border-radius-card);
}
.reward-track-bar > span.progress-separator{
    position: absolute;
    width: 2px;
    height: 100%;
    background: var(--color-progress-separator);
    bottom: -50%;
    z-index: 3;
}
.reward-track-progress-container{
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

</style>