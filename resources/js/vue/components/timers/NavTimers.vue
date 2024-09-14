<template>
    <div class="nav-timer-container">
        <!--
            *
            *   OUTPOST (if exist)
            *
        -->
        <div 
            class="outposts"
            v-for="(outpost, index) in outposts"
            @click="outpost.status.value = !outpost.status.value; startSpecificTimers(outpost, events);"  
        >
            <Transition name="toggle">
                <div v-if="outpost.status.value">
                    <img src="@/imgs/icons/Outpost_Active.png" alt="Outpost icon" title="Outpost">
                    <p>{{ outpost.name }}</p>
                </div>
            </Transition>
            
        </div>
        <!-- 
            *
            * META CONTAINER 
            *
        -->
        <div class="meta-container">
            <div 
                class="timer" v-for="(event, index) in meta" :index="index"
                :style="{'border-right': event.status.value ? 'var(--border-event-meta)' : 'none'}" 
            >
                <p class="hidden-timer">{{ event.cooldown.value }}</p>
                <article>
                    <p 
                        class="event-name event-meta"
                        :style="{color: event.status.value ? 'var(--color-event-meta)' : 'var(--color-text)'}"
                    >
                        {{ event.name }}
                    </p>
                    <div class="icons">
                        <img 
                            v-if="event.status.value"
                            src="@/imgs/icons/Active_Arrow.png" alt="Active marker" title="Currently active"
                        >
                    </div>
                </article>
                <article>
                    <div class="progress-bar-container">
                        <div 
                            class="progress-bar"
                            :style="{
                                width: `${event.progress.value * 100}%`,
                                'background-color': event.status.value ? 'var(--color-event-meta)' : 'var(--color-text)'
                            }"
                        ></div>
                    </div>
                    <div class="time">
                        <p 
                            class="event-time event-meta"
                            :style="{color: event.status.value ? 'var(--color-event-meta)' : 'var(--color-text)'}"
                        >{{ convertToTime(event.cooldown) }}</p>
                    </div>
                </article>
            </div>
        </div>
        <!-- 
            *
            * TIMER CONTAINER
            *
        -->
        <div class="timer-container">
            <div 
                v-for="(event, index) in events" :key="index"   
                :id="`timer-${event.name}`" 
            >
                <div 
                    class="timer"
                    v-show="event.toggleCheckbox.value"
                >
                    <p class="hidden-timer">{{ event.initialCooldown }}</p>
                    <article>
                        
                        <div class="event-name">
                            <p>{{ event.name }}</p>
                            <svg 
                                class="event-sync"
                                v-if="event.sync"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M5 19H16C17.8565 19 19.637 18.2625 20.9497 16.9497C22.2625 15.637 23 13.8565 23 12V9M8 15L4 19L8 23M19 5H8C6.14348 5 4.36301 5.7375 3.05025 7.05025C1.7375 8.36301 1 10.1435 1 12V15M16 1L20 5L16 9" stroke="#FFD12C" stroke-width="2"/>
                                <title>This event timer is in sync with another</title>
                            </svg>
                        </div>
                        <!-- <p class="event-name">{{ event.name }}</p> -->
                        <div class="icons">
                            <img 
                                v-for="chain in event.chain"
                                :src="chain.img" :alt="chain.type" :title="chain.type"    
                            >
                        </div>
                    </article>
                    <TimerFunctions
                        :all-events="events"
                        :event="event"
                        :index="index"
                    />
                    <Transition name="toggle">
                        <article 
                            class="info"
                            v-if="event.toggleInfo.value"
                        >
                            <!--
                                *
                                * Event outpost info (if applicable)
                                *
                            -->
                            <div 
                                class="info-block"
                                v-if="event.outpost != ''"    
                            >
                                <span class="left-right-text">
                                    <p>Outpost:</p>
                                    <p>{{ event.outpost }}</p>
                                </span>
                            </div>
                            
                            <!--
                                *
                                * Event info
                                *
                            -->
                            <p>{{ event.info }}</p>
                            <!-- 
                                *
                                * INITIAL COOLDOWN INFO
                                * Show if it has an initial cooldown. Otherwise only show the respawn time
                                *
                            -->
                            <div class="info-block">
                                <span 
                                    v-if="event.initialCooldown.value != event.respawnCooldown.value"
                                    class="left-right-text"
                                >
                                    <p class="event-upcoming">Initial min:</p>
                                    <p class="event-upcoming">{{ convertToTime(event.initialCooldown.value - event.initialMin) }}</p>
                                </span>
                                <span 
                                    v-if="event.initialCooldown.value != event.respawnCooldown.value"
                                    class="left-right-text"
                                >
                                    <p class="event-up">Initial avg:</p>
                                    <p class="event-up">{{ convertToTime(event.initialCooldown) }}</p>
                                </span>
                                <span 
                                    v-if="event.initialCooldown.value != event.respawnCooldown.value"
                                    class="left-right-text"
                                >
                                    <p class="event-overdue">Initial max:</p>
                                    <p class="event-overdue">{{ convertToTime( event.initialCooldown.value - event.initialMax) }}</p>
                                </span>
                                <!-- 
                                    *
                                    * RESPAWN COOLDOWN INFO
                                    *
                                -->
                                <span class="left-right-text">
                                    <p class="event-upcoming">Respawn min:</p>
                                    <p class="event-upcoming">{{ convertToTime(event.respawnCooldown.value - event.respawnMin) }}</p>
                                </span>
                                <span class="left-right-text">
                                    <p class="event-up">Respawn avg:</p>
                                    <p class="event-up">{{ convertToTime(event.respawnCooldown) }}</p>
                                </span>
                                <span class="left-right-text">
                                    <p class="event-overdue">Respawn max:</p>
                                    <p class="event-overdue">{{ convertToTime( event.respawnCooldown.value - event.respawnMax) }}</p>
                                </span>
                            </div>
                        </article>
                    </Transition>
                </div>
            </div>
        </div>
        <!--
            *
            * CHECKBOX CONTAINERS
            *
        -->
        <div class="checkbox-container">
            <!--
                *
                * GROUP CHECKBOXES
                *
            -->
            <h5>Add/remove group</h5>
            <div 
                class="checkbox"
                v-for="(event, index) in checkboxes" :key="event.name"
            >
                <input 
                    type="checkbox" :id="`checkbox-group-${event.name}`" :name="event.name" :checked="event.toggle.value"
                    @click="event.toggle.value = !event.toggle.value; toggleCheckboxGroup(event.name)"
                />
                <label :for="`checkbox-group-${event.name}`">{{ event.name }}</label>
            </div>
            <!--
                *
                * INDIVIDUAL CHECKBOXES
                *
            -->
            <h5>Individuals</h5>
            <div 
                class="checkbox"
                v-for="event in events" :key="event.name"
            >
                <input 
                    type="checkbox" :id="`checkbox-individual-${event.name}`" :name="event.name" :checked="event.toggleCheckbox.value"
                    @click="event.toggleCheckbox.value = !event.toggleCheckbox.value"
                />
                <label :for="`checkbox-individual-${event.name}`">{{ event.name }}</label>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'

import TimerFunctions from '@/js/vue/components/timers/TimerFunctions.vue'
import { sortTimers, colorTimers, share, metaCountdown, convertToTime } from '@/js/vue/composables/TimerFunctions.js'

const props = defineProps({
    outposts: Object,
    events: Object,
    meta: Object,
    checkboxes: Object,
})

const toggleOutpost = props.outposts;

const toggleCheckboxGroup = (targetName) => {
    console.log(targetName);
    props.events.forEach((event) => {
        if (event.name.includes(targetName) || event.outpost.includes(targetName)){
            event.toggleCheckbox.value = !event.toggleCheckbox.value;
        }
    })
}

const startSpecificTimers = (outpost, events) => {
    let toggle = false;

    share.timers.forEach((timer) => {
        if (timer.outpost == outpost.name){
            toggle = true;
            timer.start(); 
        }
    })
    if (toggle == true){
        events.forEach((event) => {
            if (outpost.name == event.outpost){
                event.togglePlay.value = !event.togglePlay.value;
            }
        })
    }
}

onMounted(() => {
    let timerContainer = document.querySelector('.timer-container'),
        metaContainer = document.querySelector('.meta-container');
    let eventContainer = timerContainer.querySelectorAll('.timer'),
        eventNames = timerContainer.querySelectorAll('.event-name'),
        eventTimes = timerContainer.querySelectorAll('.event-time');

    sortTimers(props.events, timerContainer);
    sortTimers(props.meta, metaContainer);
    colorTimers(props.events, eventContainer, eventNames, eventTimes);

    metaCountdown(props.meta);
})



</script>

<style scoped>
/* nav section.nav-timer-container article{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--padding-timers);
}
nav section.nav-timer-container svg,
nav section.nav-timer-container img{
    width: 20px;
    height: 20px;
}
nav section.nav-timer-container svg{
    cursor: pointer;
}
nav section.nav-timer-container .hidden-timer{
    display: none;
} */
article{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--padding-timers);
}
/* 
    =================================================
    * TIMER EVENTS
    =================================================
*/

.nav-timer-container svg,
.nav-timer-container img{
    width: 20px;
    height: 20px;
}
.event-name{
    display: flex;
    align-items: center;
    gap: 5px;
}
svg.event-sync{
    width: 13px;
    height: 13px;
}
.hidden-timer{
    display: none;
}

.icons{
    display: flex;
    align-items: center;
}
.outposts > div{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding-inline: var(--padding-timers);
    border-bottom: var(--border-bottom);
    cursor: pointer;
}
.outposts p{
    text-align: left;
    padding: var(--padding-outpost);
}
.timer{
    padding-inline: var(--padding-timers);
    border-bottom: var(--border-bottom);
}
.timer p{
    white-space: wrap;
}
.info{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
}
.info-block{
    width: 100%;
}
.left-right-text{
    display: flex;
    justify-content: space-between;
    text-align: right;
    width: 100%;
}

.progress-bar-container{
    width: 65%;
    height: 20px;
    border: 1px solid white;
}
.progress-bar{
    width: 0%;
    height: 100%;
    background-color: var(--color-event-meta);
    transition: var(--transition-all-03s-ease);
}

.toggle-enter-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.toggle-leave-active{
    transition: all 0.3s ease;
}

.toggle-enter-from,
.toggle-leave-to {
    opacity: 0;
    transform: translateX(25px);
}

</style>