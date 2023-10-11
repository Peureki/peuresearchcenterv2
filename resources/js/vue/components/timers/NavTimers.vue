<template>
    <section class="nav-timer-container">
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
                    <h6>{{ outpost.name }}</h6>
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
                    <h6 
                        class="event-name event-meta"
                        :style="{color: event.status.value ? 'var(--color-event-meta)' : 'var(--color-text)'}"
                    >
                        {{ event.name }}
                    </h6>
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
                        
                        <h6 class="event-name">{{ event.name }}</h6>
                        <div class="icons">
                            <img 
                                v-for="chain in event.chain"
                                :src="chain.img" :alt="chain.type" :title="chain.type"    
                            >
                        </div>
                    </article>
                    <TimerFunctions
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
        <article class="checkbox-container">
            <!--
                *
                * GROUP CHECKBOXES
                *
            -->
            <h5>Add/remove group</h5>
            <div 
                class="checkbox-timer-container"
                v-for="(event, index) in checkboxes" :key="event.name"
            >
                <input 
                    type="checkbox" :id="`checkbox-timer-group-${event.name}`" :name="event.name" :checked="event.toggle.value"
                    @click="event.toggle.value = !event.toggle.value; toggleCheckboxGroup(event.name)"
                />
                <label :for="`checkbox-timer-group-${event.name}`">{{ event.name }}</label>
            </div>
            <!--
                *
                * INDIVIDUAL CHECKBOXES
                *
            -->
            <h5>Individuals</h5>
            <div 
                class="checkbox-timer-container"
                v-for="event in events" :key="event.name"
            >
                <input 
                    type="checkbox" :id="`checkbox-timer-individual-${event.name}`" :name="event.name" :checked="event.toggleCheckbox.value"
                    @click="event.toggleCheckbox.value = !event.toggleCheckbox.value"
                />
                <label :for="`checkbox-timer-individual-${event.name}`">{{ event.name }}</label>
            </div>
        </article>
    </section>
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
.outposts h6{
    text-align: left;
    padding: var(--padding-outpost);
}
.timer h6{
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
.checkbox-container{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 5px;
    border-bottom: var(--border-bottom);
}
.checkbox{
    display: flex;
    gap: 5px;
    align-items: center;
}
.checkbox label{
    font-size: var(--font-size-p);
    font-family: var(--font-family);
    color: var(--color-text);
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