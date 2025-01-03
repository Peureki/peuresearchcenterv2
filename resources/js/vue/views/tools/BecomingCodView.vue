<template>
    <Nav/>
    <Header page-name="Becoming Cod"/>

    <section class="main">
        <div class="card-grid">
            <div class="content-section">
                <div v-if="achievements" v-for="(achievement, index) in achievements" class="card-container">
                    <div class="card">
                        <div></div>

                        <div class="card-details">
                            <div class="card-title-and-value">
                                <p class="title">{{ achievement.name }}</p>

                                <p>{{ userAchievements[index].current }} / {{ achievement.bits.length }}</p>
                            </div>

                            <div class="fish-achievement-container">
                                <div class="fish-collection">
                                    <div class="fish" v-for="(fish, achievementIndex) in achievement.bits">
                                        <img :style="{opacity: capturedFishOpacity(achievementIndex, userAchievements[index].bits)}" :src="fish.icon" :alt="fish.name" :title="fish.name">
                                    </div>
                                </div>

                                <div class="fish-recommendations">
                                    <template v-for="(fish, achievementIndex) in achievement.bits">
                                        <div v-if="missingFish(achievementIndex, userAchievements[index].bits)" class="fish-details-container" :style="{border: availability(fish)}">
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
            </div>
        </div>
        
        
    </section>

    <Footer/>
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'
import Footer from '@/js/vue/components/general/Footer.vue'
import CodGuides from '@/js/vue/components/guides/cod/CodGuides.vue';

import { activeArrow } from '@/js/vue/composables/BasicFunctions'
import { getAuthUser } from '@/js/vue/composables/Authentication';
import { showRarityColor } from '@/js/vue/composables/FormatFunctions';

import { user, dayAndNightTimerToggle, tyrianCurrentPeriod, canthanCurrentPeriod } from '@/js/vue/composables/Global'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import axios from 'axios';

import GendarranRiverFish from '@/imgs/guides/fishing/Gendarran_Fields_River_Fish.webp'


const achievements = ref(null),
    userAchievements = ref(null);

const expand = ref(null);

watch(achievements, (newAchievements) => {
    if (newAchievements){
        expand.value = newAchievements.map(achievement =>
            achievement.bits.map(() => false)
        );
    }
})

onMounted(async () => {
    dayAndNightTimerToggle.value = true; 

    await getAuthUser(); 

    if (user.value){
        getFishingAchievements();
    }
})

onUnmounted(() => {
    dayAndNightTimerToggle.value = false;
})

const getFishingAchievements = async () => {
    try {
        const response = await axios.get('../api/user/achievements/fishing');

        if (response){
            achievements.value = response.data.achievements; 
            userAchievements.value = response.data.userAchievements;

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
            // Iterates through the user's achievements and if no 'bits' => create bits = []
            userAchievements.value.forEach((achievement) => {
                if (!achievement.hasOwnProperty('bits')){
                    achievement.bits = []; 
                }
            })

            console.log(achievements.value, userAchievements.value);
        }
    } catch (error) {
        console.log('Could not get fishing achievements: ', error); 
    }
}

const capturedFishOpacity = (achievementIndex, userCompletion) => {
    return userCompletion.includes(achievementIndex) ? 1 : 0.2; 
}

const missingFish = (achievementIndex, userCompletion) => {
    return !userCompletion.includes(achievementIndex);
}

const baitName = (name) => {
    return name ? name : 'Any';
}

// *
// * FISH AVAILIBITY
// * 
// * Check fish.map && respective region time (real time) to see if the fish is availble
// * IF available => green border
// * NOT availalbe => red border
// *
// const availability = (fish) => {
//     let isTyrian = false,
//         isCanthan = false; 

//     switch (fish.map){
//         case 'Seitung Province':
//         case 'New Kaineng City':
//         case 'Echovald Wilds':
//         case "Dragon's End":
//             isCanthan = true; 
//             break;
//         default: isTyrian = true; 
//     }
//     if (isCanthan){
//         if (fish.time == 'Any' || canthanCurrentPeriod.value == 'Dawn' || canthanCurrentPeriod.value == 'Dusk'){
//             return `var(--border-positive)`
//         } else {
//             return `var(--border-negative)`
//         }
        
//     }
//     if (isTyrian){
//         if (fish.time == 'Any' || tyrianCurrentPeriod.value == 'Dawn' || tyrianCurrentPeriod.value == 'Dusk'){
//             return `var(--border-positive)`
//         } else {
//             return `var(--border-negative)`
//         }
//     }
// }
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
        if (fish.time == 'Any' || canthanCurrentPeriod.value == 'Dawn' || canthanCurrentPeriod.value == 'Dusk'){
            return `Active`
        } else {
            return `Inactive`
        }
        
    }
    if (isTyrian){
        if (fish.time == 'Any' || tyrianCurrentPeriod.value == 'Dawn' || tyrianCurrentPeriod.value == 'Dusk'){
            return `Active`
        } else {
            return `Inactive`
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



</style>