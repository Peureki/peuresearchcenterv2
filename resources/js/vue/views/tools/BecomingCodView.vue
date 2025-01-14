<template>
    <Header page-name="Becoming Cod"/>
    <Nav>
        <!--
            *
            * FILTERS PANEL
            *
        -->
        <template v-slot:filters>
            <div class="filter-container">
                <h3>Filters</h3>
                <div class="filter-collection-container">
                    <p>Toggle</p>
                    <div class="filter-collection">
                        <FilterToggle
                            v-if="filterToggle"
                            v-for="toggle in filterToggle"
                            :toggle-option="toggle"
                            filter-property-name="toggleCodShow"
                        />
                    </div>
                </div>

                <Transition name="fade">
                    <div v-if="achievements" class="filter-collection-container">
                        <p>Achievements</p>
                        <div class="filter-collection">
                            <FilterToggle
                                :toggle-options="filterAchievements"
                                filter-property-name="toggleCodAchievements"
                                :radio="true"
                            />
                        </div>

                        <!-- <p v-if="filters.toggleCodShow.includes('Only Cod')" class="small-subtitle">Removed achievements that aren't needed for Cod anymore and are post-EOD. Toggle 'Only Cod' off to see everything.</p>
                        <p v-else class="small-subtitle">Showing all achievements. Toggle 'Only Cod' to only show achievements for Cod.</p> -->
                    </div>
                </Transition>
                
            </div>
        </template>

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

    <section class="main">
        <div class="content-section">
            <!--
                *
                * SUMMARY
                *
            -->
            <div class="achievement-summary-container" v-if="user">
                <h3>
                    {{ currentAchievementTitle }} 
                    <span v-if="cod" class="small-subtitle">{{ cod.current }}/{{ cod.max }} total achievements</span>
                </h3>
            </div>

            <!-- 
                *
                * API KEY SUBMISSION FORM 
                * 
            -->
            <div class="flex-wrap">
                <span class="img-and-label">
                    <img class="icon clickable" :src="Key" alt="Enter API Key" title="Enter API Key">
                    <form @submit.prevent="handleAPISubmission(apiKey)">
                        <input placeholder="Enter your API key" v-model="apiKey">
                        <button type="submit">Submit</button>
                    </form>
                </span>

                <p v-if="!user" class="error-message">Need to be registered/logged on to use this feature</p>

                <PopUpMessage v-if="errorMessage" :message="errorMessage" color="Red" :duration="5"/>

                <div class="img-and-label" v-if="user">
                    <svg v-if="user.has_api_key" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.92984 17.0701C1.97473 16.1476 1.21291 15.0442 0.688821 13.8241C0.164731 12.6041 -0.111131 11.2919 -0.122669 9.96409C-0.134207 8.6363 0.11881 7.3195 0.621618 6.09054C1.12443 4.86158 1.86696 3.74506 2.80589 2.80613C3.74481 1.8672 4.86133 1.12467 6.09029 0.621863C7.31926 0.119054 8.63605 -0.133963 9.96385 -0.122425C11.2916 -0.110887 12.6038 0.164975 13.8239 0.689065C15.0439 1.21316 16.1474 1.97498 17.0698 2.93008C18.8914 4.8161 19.8994 7.34212 19.8766 9.96409C19.8538 12.5861 18.8021 15.0942 16.948 16.9483C15.0939 18.8023 12.5858 19.854 9.96385 19.8768C7.34188 19.8996 4.81586 18.8917 2.92984 17.0701ZM15.6598 15.6601C17.161 14.159 18.0043 12.123 18.0043 10.0001C18.0043 7.87717 17.161 5.8412 15.6598 4.34008C14.1587 2.83895 12.1227 1.99563 9.99984 1.99563C7.87692 1.99563 5.84096 2.83895 4.33984 4.34008C2.83871 5.8412 1.99539 7.87717 1.99539 10.0001C1.99539 12.123 2.83871 14.159 4.33984 15.6601C5.84096 17.1612 7.87692 18.0045 9.99984 18.0045C12.1227 18.0045 14.1587 17.1612 15.6598 15.6601ZM6.69983 9.29008L8.99984 11.6001L13.2998 7.30008L14.6998 8.72008L8.99984 14.4001L5.29984 10.7001L6.69983 9.28008V9.29008Z" fill="var(--color-up)"/>
                    </svg>

                    <p v-if="user.has_api_key" class="event-up">API key found</p>
                </div>
            </div>
            
            <!--
                *
                * INFO BOX CONTAINER
                * General info such as recommendations, what's not part of the achievement, etc
                *
            -->
            <Transition name="fade">
                <div v-if="showTips" class="info-box-container">
                    <!--
                        *
                        * HOW THIS PAGE WORKS
                        *
                    -->
                    <div class="info-box" id="how-to">
                        <h4>How this page works</h4>
                        <ul>
                            <li>
                                1. Must be <a @click="showLogin">signed on</a> and input your API key above. You can obtain this by going to <a href="https://account.arena.net/applications" target="_blank">Arenanet's website</a> -> Applications. The option "Progression" will need to be selected for this to work. 
                            </li>
                            
                            <li>2. Achievements will be listed in order of amount that needs to be completed. Any achievement that has been completed that isn't repeatable or an avid will not show.</li>
                            <li>3. Each achievement will have a list of fishes. (Icon group) reflects your current progression in the game's achievement tab. Besides that are a list of fishes that need to be obtained to complete. Each fish will have their own information and guide on how to obtain.</li>
                        </ul>
                    </div>
                    <!--
                        *
                        * FISHING BENCHMARK ROUTER LINK
                        *
                    -->
                    <router-link class="card-container" id="fishing-benchmarks" to="/benchmarks/fishing">
                        <h4>Fishing Benchmarks</h4>
                        <div class="img-and-label">
                            <p>Page that lists all the best fishing farms and routes in the game.</p>
                            <svg class="arrow clickable inactive-arrow" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="#FFD12C"/>
                            </svg>
                        </div>
                    </router-link>
                    <!--
                        *
                        * GENERAL RECOMMENDATIONS
                        *
                    -->
                    <div class="info-box" id="general">
                        <h4>General recommendations</h4>
                        <ul>
                            <li class="img-and-label"><img :src="LocalLegend" alt="Local Legend mastery" title="Local Legend mastery">Max out fishing masteries</li>
                            <li class="img-and-label"><img :src="Skimmer" alt="Skimmer" title="Skimmer">Skimmer</li>
                        </ul>
                    </div>
                    <!--
                        *
                        * ACHIEVEMENTS NOT FOR COD
                        *
                    -->
                    <div class="info-box" id="not-for-cod">
                        <h4>Achievements that are not needed for Cod</h4>
                        <ul>
                            <li class="img-and-label"><img :src="UnholyMackerel" alt="Unholy Mackerel" title="Unholy Mackerel">Horn of Maguuma Fisher</li>
                            <li class="img-and-label"><img :src="MouseEaredOctopus" alt="Mouse-Eared Octopus" title="Mouse-Eared Octopus">Janthir Fisher</li>
                        </ul>
                    </div>
                    <!--
                        *
                        * FISHING POWER TIPS
                        *
                    -->
                    <div class="info-box" id="fishing-power">
                        <h4>Fishing Power</h4>
                        <ul>
                            <li>For fish rarities that are junk, fine, rare, having minimum fishing power or greater works. Anything above 900 will remove fine fish from the drop table.</li>
                            <li>For fish rarities that are exotic, ascended, and legendary, the higher the fishing power the better chances. Goal: 925, or 975 with Mackerels (if required)</li>
                            <li>+25 Fishing rod</li>
                            <li>+100 Masteries </li>
                            <li>+100 <a href="https://wiki.guildwars2.com/wiki/Bait" target="_blank">Bait</a> (+150 if Mackerels)</li>
                            <li>+100 <a href="https://wiki.guildwars2.com/wiki/Lure" target="_blank">Lure</a></li>
                            <li>+150 Any fishing food</li>
                            <li>+100 Fishing while nourished</li>
                            <li>+300 99 Stacks of <a href="https://wiki.guildwars2.com/wiki/Fishing_Party" target="_blank">Fishing Party</a> (4 <a href="https://wiki.guildwars2.com/wiki/Zephyrite_Fish_Jerky" target="_blank">Zephyrite Fish Jerky</a> for instant stacks)</li>
                            <li>+50 <a href="https://wiki.guildwars2.com/wiki/Tips_on_Fishing" target="_blank">Tips on Fishing</a> (if you have the EOD guild hall, you can use one of their exit portals to reach the NPC quickly)</li>
                        </ul>
                    </div>
                    <!--
                        *
                        * BAIT TIP
                        *
                    -->
                    <div class="info-box" id="bait-tip">
                        <h4>Bait tip</h4>
                        <p>I recommend having one character dedicated to fishing that has all your equipment needed to fish. For bait, spend a little to buy stacks of bait jars. Every jar contains 25 of their respective bait. This helps to:</p>
                        <ul>
                            <li>1. Saves inventory space by not having to purchase multiple stacks of the same bait, especially if you're having trouble getting a particular fish.</li>
                            <li>2. Saves time from constantly going to the right fishmonger merchant to buy bait</li>
                        </ul>
                        <img :src="Inventory" alt="Inventory with baits and jars" title="Inventory with baits and jars">
                    </div>
                </div>
            </Transition>
            

            <div class="card-grid">
                <template v-if="achievements" v-for="(achievement, index) in achievements">
                    <div v-if="onlyCodAchievements(userAchievements[index])"  class="card-container">
                        <div class="card">
                            <div class="card-details">
                                <!--
                                    *
                                    * NAME / PROGRESS
                                    *
                                -->
                                <div class="card-title-and-value">
                                    
                                    <div class="flex">
                                        <!-- NAME -->
                                        <p class="title">{{ achievement.name }}</p>
                                        <!-- REPEATED # -->
                                        <p class="small-subtitle" v-if="userAchievements[index].repeated">Repeated: {{ userAchievements[index].repeated }}</p>
                                        <!-- <p v-else class="small-subtitle">Cod requirement</p> -->

                                        <!-- <p v-else-if="checkPossibleAvid(achievement.name)" class="small-subtitle">(Avid after completion)</p> -->
                                    
                                    </div>
                                    
                                    <!-- PROGRESS -->
                                    <div class="flex">
                                        <p class="small-subtitle">{{ (achievement.bits.length - userAchievements[index].current) }} fishes left, </p>
                                        <p class="small-subtitle">{{ userAchievements[index].current }} / {{ achievement.bits.length }}</p>
                                    </div>
                                    
                                </div>

                                <div class="fish-achievement-container">
                                    <div class="fish-collection">
                                        <div class="fish" v-for="(fish, achievementIndex) in achievement.bits">
                                            <img :style="{opacity: capturedFishOpacity(achievementIndex, userAchievements[index].bits)}" :src="fish.icon" :alt="fish.name" :title="fish.name">
                                        </div>
                                    </div>

                                    <div class="fish-recommendations">
                                        <template v-for="(fish, achievementIndex) in achievement.bits">
                                            <div v-if="missingFish(achievementIndex, userAchievements[index].bits)" class="fish-details-container" :style="{opacity: fishOpacity(view[index][achievementIndex])}">
                                                <div class="fish">
                                                    <div class="fish flex-column">
                                                        <img :src="fish.icon" :alt="fish.name" :title="fish.name">
                                                        <svg 
                                                            class="arrow"
                                                            @click="expand[index][achievementIndex] = !expand[index][achievementIndex]"
                                                            :class="activeArrow(expand[index][achievementIndex])"
                                                            width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-text)"/>
                                                        </svg>

                                                    </div>
                                                    

                                                    <div class="fish-details">
                                                        <div class="img-and-label">
                                                            <p :style="{color: showRarityColor(fish.rarity)}">{{ fish.name }}</p>
                                                            <!--
                                                                *
                                                                * SVG SIGNAL
                                                                *
                                                            -->
                                                            <svg 
                                                                class="signal" 
                                                                :class="availability(fish)"
                                                                width="30" height="30" xmlns="http://www.w3.org/2000/svg"
                                                            >
                                                                <circle class="fill-circle" cx="15" cy="15" r="5" stroke="black" stroke-width="1" />
                                                                <circle class="expand-circle" cx="15" cy="15" r="15"  fill="transparent" stroke-width="1"/>
                                                                <title>{{ availability(fish) }}</title>
                                                            </svg>
                                                            <!--
                                                                *
                                                                * VIEW SYMBOL - HIDE FISH
                                                                *
                                                            -->
                                                            <!-- <svg @click="view[index][achievementIndex] = !view[index][achievementIndex]" class="icon clickable" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <title>Show/hide fish</title>
                                                            </svg> -->
                                                        </div>
                                                        
                                                        
                                                        <p class="small-subtitle">Hole: {{ fish.fishing_hole }}</p>
                                                        <p class="small-subtitle">Bait: {{ baitName(fish.bait_name) }}</p>
                                                        <p class="small-subtitle">Time: {{ fish.time }}</p>
                                                    </div>                     
                                                </div>

                                                
                                                <CodGuides
                                                    v-if="expand[index][achievementIndex]"
                                                    :fish="fish"
                                                />
                                                <!-- <img v-if="expand[index][achievementIndex]"  :src="GendarranRiverFish"> -->
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                
            </div>
        </div>
        

        
        
        
    </section>

    <Loading v-if="(!achievements || !userAchievements || currentlyLoading) && user" :width="200" :height="200"/>

    <Footer/>
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import CodGuides from '@/js/vue/components/guides/cod/CodGuides.vue';
import Loading from '@/js/vue/components/general/Loading.vue'
import FilterToggle from '@/js/vue/components/filters/FilterToggle.vue';
import FilterRadio from '@/js/vue/components/filters/FilterRadio.vue';
import PopUpMessage from '@/js/vue/components/general/PopUpMessage.vue'

import { activeArrow } from '@/js/vue/composables/BasicFunctions'
import { getAuthUser } from '@/js/vue/composables/Authentication';
import { showRarityColor, formatTime, validateAPIKey } from '@/js/vue/composables/FormatFunctions';

import { user, dayAndNightTimerToggle, tyrianCurrentPeriod, canthanCurrentPeriod, filtersToggle, filters, loginToggle, isMobile, mainNavToggle, mobileHamburger } from '@/js/vue/composables/Global'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import axios from 'axios';

// *
// * INFO IMGS
// * 
import LocalLegend from '@/imgs/icons/masteries/Local_Legend.png'
import Skimmer from '@/imgs/icons/Skimmer.png'
import UnholyMackerel from '@/imgs/icons/fishes/Unholy_Mackerel.png'
import MouseEaredOctopus from '@/imgs/icons/fishes/Mouse-Eared_Octopus.png'

import Inventory from '@/imgs/guides/fishing/Inventory.webp'
import Key from '@/imgs/svgs/key.svg'
import { filter } from 'lodash';


const achievements = ref(null),
    userAchievements = ref(null),
    cod = ref(null);

const apiKey = ref(null),
    errorMessage = ref(null),
    currentlyLoading = ref(null);

// The amount of time in seconds for API refresh (5mins)
const refreshCountdown = ref(300);

const filterToggle = ['Tips'],
    filterAchievements = ['Only Cod', 'All'];

const expand = ref(null),
    view = ref(null);

watch(achievements, (newAchievements) => {
    if (newAchievements){
        expand.value = newAchievements.map(achievement =>
            achievement.bits.map(() => false)
        );

        view.value = newAchievements.map(achievement =>
            achievement.bits.map(() => true)
        );
    }
})

onMounted(async () => {
    dayAndNightTimerToggle.value = true; 

    await getAuthUser(); 

    

    if (user.value){
        getFishingAchievements();
        console.log('USER ACHIEVEMENTS: ', user.value.achievements)
        console.log('USER: ', user.value);
    }
    // Get FILTERS nav panel
    filtersToggle.value = true;
})

onUnmounted(() => {
    dayAndNightTimerToggle.value = false;
    filtersToggle.value = false;

    clearInterval(refreshFishingAchievements);
    clearInterval(startRefreshCountdown); 
})

const getFishingAchievements = async () => {
    try {
        currentlyLoading.value = true; 
        const response = await axios.get('../api/user/achievements/fishing');

        if (response){
            achievements.value = response.data.achievements; 
            userAchievements.value = response.data.userAchievements;
            cod.value = response.data.cod[0]; 

            // Sort merp (userAchievements.value) and keep the sorted array
            userAchievements.value.sort((a, b) => (a.max - a.current) - (b.max - b.current));

            achievements.value.sort((a, b) => {
                const indexA = userAchievements.value.findIndex(ua => ua.id === a.id);
                const indexB = userAchievements.value.findIndex(ub => ub.id === b.id);
                return indexA - indexB;
            });

            // For some reason, when users reset an avid, the 'bits' property disappears
            // This is for when that happens
            // 
            // Iterates through the user's achievements and if no 'bits' => create empty bits = []
            userAchievements.value.forEach((achievement) => {
                if (!achievement.hasOwnProperty('bits')){
                    achievement.bits = []; 
                }
            })

            currentlyLoading.value = false; 
            console.log(achievements.value, userAchievements.value, cod.value);
        }
    } catch (error) {
        console.log('Could not get fishing achievements: ', error); 
        currentlyLoading.value = false; 
    }
}

const setFishingAchievements = () => {
    
}

const refreshFishingAchievements = setInterval(() => {
    console.log('Refreshing Fishing Achievements');
    getFishingAchievements(); 
    refreshCountdown.value = 300; 
}, 300000)

const startRefreshCountdown = setInterval(() => {
    refreshCountdown.value--;
}, 1000);

const capturedFishOpacity = (achievementIndex, userCompletion) => {
    return userCompletion.includes(achievementIndex) ? 1 : 0.2; 
}

const missingFish = (achievementIndex, userCompletion) => {
    return !userCompletion.includes(achievementIndex);
}

const baitName = (name) => {
    return name ? name : 'Any';
}
const showTips = computed(() => {
    return filters.value.toggleCodShow.includes('Tips'); 
})

// When users click on the X to hide/show a fish => change opacity
const fishOpacity = (viewIndex) => {
    return viewIndex ? 1 : 0.3; 
}
const isOnlyCodEnabled = computed(() => {
    return user.value.filters.toggleCodAchievements == 'Only Cod';
})
// *
// * SHOW ONLY COD ACHIEVEMENTS
// * If user clicked filter 'Only Cod' => only show those achievements
// * Else => show everything
// *
const onlyCodAchievements = (userAchievement) => {
    const isOnlyCodEnabled = filters.value.toggleCodAchievements.includes('Only Cod');
    //Horn of Maguuma (+ avid), Janthir (+ avid)
    const postEODAchievements = [7114, 8168, 7804, 8246];

    console.log('is only cod: ', isOnlyCodEnabled);
    
    if (isOnlyCodEnabled){
        if (userAchievement.hasOwnProperty('repeated') || postEODAchievements.includes(userAchievement.id)){
            return false; 
        }

        return true; 
    }

    return true; 
}
// const onlyCodAchievements = (userAchievement) => {
//     const isOnlyCodEnabled = user.value.filters.toggleCodShow.includes('Only Cod');
//     // // Horn of Maguuma (+ avid), Janthir (+ avid)
//     // const postEODAchievements = [7114, 8168, 7804, 8246];

//     console.log('is only cod: ');
    
//     // if (isOnlyCodEnabled){
//     //     if (userAchievement.hasOwnProperty('repeated') || postEODAchievements.includes(userAchievement.id)){
//     //         return false; 
//     //     }

//     //     return true; 
//     // }

//     // return true; 
// }

const showLogin = () => {
    if (isMobile){
        mainNavToggle.value = true;
        mobileHamburger.value = false; 
    }
    loginToggle.value = !loginToggle.value; 
}

const handleAPISubmission = async (apiKey) => {
    if (!validateAPIKey(apiKey)){
        errorMessage.value = "Entered invalid API key"
        return; 
    }

    try {
        const response = await axios.post('../api/user/apiSubmission', {
            apiKey: apiKey
        })

        if (response){
            errorMessage.value = null;
            console.log('API key submitted!');
            getFishingAchievements(); 
            
        }
    } catch (error){
        console.log('API key did not save: ', error); 
    }
}

const currentAchievementTitle = computed(() => {
    if (cod.value){
        if (cod.value.current == 0){
            return "Start your journey to becoming a COD today!"
        }
        else if (cod.value.current > 0 && cod.value.current < 5){
            return "On your way to becoming a COD!";
        } 
        else if (cod.value.current >= 5 && cod.value.current < 10){
            return "Kind of a big Reel";
        }
        else if (cod.value.current >= 10 && cod.value.current < 15){
            return "Fishmongers Know Me";
        }
        else if (cod.value.current >= 15 && cod.value.current < 20){
            return "I'm Very Buoyant";
        }
        else if (cod.value.current >= 20 && cod.value.current < 25){
            return "I Have Many Lure-Bound Hooks";
        }
        else if (cod.value.current >= 25 && cod.value.current < 30){
            return "My Guild Hall Smells of Fish Progeny";
        }
        else {
            return "Cod Swimming Amongst Mere Minnows";
        }
    }
})

// *
// * FISH AVAILIBITY
// * 
// * Check fish.map && respective region time (real time) to see if the fish is availble
// * IF available => green ping
// * NOT availalbe => red ping
// *
const availability = (fish) => {
    let isTyrian = false,
        isCanthan = false; 

    switch (fish.map){
        case 'Seitung Province':
        case 'New Kaineng City':
        case 'Echovald Wilds':
        case "Dragon's End":
            isCanthan = true; 
            break;
        default: isTyrian = true; 
    }
    if (isCanthan){
        if (fish.time.includes('Any')
            || canthanCurrentPeriod.value == 'Dawn' 
            || canthanCurrentPeriod.value == 'Dusk'
        ){
            return `Active`
        }
        if (canthanCurrentPeriod.value == 'Daytime'){
            if (fish.time.includes('Day') || fish.time == 'Daytime'){
                return 'Active'; 
            } else {
                return 'Inactive'; 
            }
        } 
        if (canthanCurrentPeriod.value == 'Nighttime'){
            if (fish.time.includes('Night') || fish.time == 'Nighttime'){
                return 'Active'; 
            } else {
                return 'Inactive'; 
            }
        }
        
    }
    if (isTyrian){
        if (fish.time.includes('Any')
            || tyrianCurrentPeriod.value == 'Dawn' 
            || tyrianCurrentPeriod.value == 'Dusk'
        ){
            return `Active`
        }
        if (tyrianCurrentPeriod.value == 'Daytime'){
            if (fish.time.includes('Day') || fish.time == 'Daytime'){
                return 'Active'; 
            } else {
                return 'Inactive'; 
            }
        } 
        if (tyrianCurrentPeriod.value == 'Nighttime'){
            if (fish.time.includes('Night') || fish.time == 'Nighttime'){
                return 'Active'; 
            } else {
                return 'Inactive'; 
            }
        }
    }
}

</script>

<style scoped>

.fish-collection{
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    width: fit-content;
    gap: var(--gap-general);
}
.card-details{
    gap: var(--gap-content);
}
.fish > img,
.fish-details > img{
    width: var(--img-icon-size);
    height: var(--img-icon-size);
}
.fish-achievement-container{
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: var(--gap-content);
}
.fish-recommendations{
    display: flex;
    flex-wrap: wrap;
    gap: var(--gap-general);
}
.fish-details-container{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
    background-color: var(--color-bkg-more-fade);
    padding: var(--gap-general);
    border-radius: var(--border-radius-card);
    max-width: 1000px;
}
.fish-details{
    display: flex;
    flex-direction: column;
    
}
.fish{
    display: flex;
    gap: var(--gap-general);
}
.flex-column{
    justify-content: space-between;
}

#how-to{
    grid-area: 1 / 1 / 1 / 4;
}
#fishing-benchmarks{
    grid-area: 1 / 4 / 1 / 5;
}
#general{
    grid-area: 2 / 1 / 2 / 3;
}
#not-for-cod{
    grid-area: 2 / 3 / 2 / 5;
}
#fishing-power{
    grid-area: 3 / 1 / 3 / 3;
}
#bait-tip{
    grid-area: 3 / 3 / 3 / 5;
}
@media (max-width: 768px){
    .info-box{
        grid-area: unset;
    }
    .fish > img,
    .fish-details > img{
        width: 30px;
        height: 30px;
    }
        .card-container{
        padding: unset;
    }
    .card-details{
        flex-direction: column;
        align-items: unset;
    }
    .card{
        padding: var(--gap-general);
        gap: unset;
    }
}



</style>