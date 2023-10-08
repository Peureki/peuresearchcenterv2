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
            @click="startSpecificTimers(outpost, events); toggle(index);"  
        >
            <Transition name="toggle">
                <div v-if="toggleOutpost[index].status">
                    <img src="@/imgs/icons/Outpost_Active.png" alt="Outpost icon" title="Outpost">
                    <h5>{{ outpost.name }}</h5>
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
                            v-if="store.toggleInfo[index]"
                        >
                            <p>{{ event.info }}</p>
                            <!-- <span class="left-right-text">
                                <p>Initial avg:</p>
                                <p>{{ event.initialCooldown }}</p>
                            </span>
                            <span class="left-right-text">
                                <p>Initial min:</p>
                                <p>{{ convertToTime(event.initialMin) }}</p>
                            </span>
                            <span class="left-right-text">
                                <p>Initial max:</p>
                                <p>{{ convertToTime(event.initialMax) }}</p>
                            </span> -->
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
            <p>Add or remove timers</p>
            <div 
                class="checkbox"
                v-for="(event, index) in events" :key="event.name"
            >
                <input 
                    type="checkbox" :id="`checkbox-${event.name}`" :name="event.name" :checked="event.toggleCheckbox.value"
                    @click="event.toggleCheckbox.value = !event.toggleCheckbox.value"
                />
                <label :for="`checkbox-${event.name}`">{{ event.name }}</label>
            </div>
        </article>
    </section>
</template>

<script setup>
import { computed, onMounted } from 'vue'

import TimerFunctions from '@/js/vue/components/timers/TimerFunctions.vue'
import { sortTimers, colorTimers, share, store, metaCountdown, convertToTime } from '@/js/vue/composables/TimerFunctions.js'

const props = defineProps({
    outposts: Object,
    events: Object,
    meta: Object,
})
const toggleOutpost = props.outposts;

const toggle = (index) => {
    toggleOutpost[index].status = !toggleOutpost[index].status;
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
.outposts > div{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding-left: var(--nav-padding-left);
    border-bottom: var(--border-bottom);
    cursor: pointer;
}
.outposts h5{
    text-align: left;
}
.info{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
}
.left-right-text{
    display: flex;
    justify-content: space-between;
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