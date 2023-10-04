<template>
    <section class="nav-timer-container">
        <div 
            class="outposts"
            v-for="(outpost, index) in outposts"
            @click="startSpecificTimers(outpost); toggle(index);"  
        >
            <Transition name="toggle">
                <div v-if="toggleOutpost[index].status">
                    <img src="@/imgs/icons/Outpost_Active.png" alt="Outpost icon" title="Outpost">
                    <h5>{{ outpost.name }}</h5>
                </div>
            </Transition>
            
        </div>

        <div class="timer-container">
            <div 
                v-for="(event, index) in events" :key="index"    
            >
                <div 
                class="timer"
                    v-show="store.toggleEvent[index].status"
                >
                    <p class="hidden-timer">{{ event.initialCooldown }}</p>
                    <article>
                        
                        <h6 class="event-name">{{ event.name }}</h6>
                        <div 
                            class="icons">
                            <img 
                                :src="chain.img" :alt="chain.type" :title="chain.type"
                                v-for="chain in event.chain"
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
        <article class="checkbox-container">
            <p>Add or remove timers</p>
            <div 
                class="checkbox"
                v-for="(event, index) in events" :key="event.name"
            >
                <input 
                    type="checkbox" :id="event.name" :name="event.name" :checked="store.toggleEvent[index].status"
                    @click="checkCheckbox(index)"
                />
                <label :for="event.name">{{ event.name }}</label>
            </div>
        </article>
    </section>
</template>

<script setup>
import { ref, onMounted, toRef } from 'vue'

import TimerFunctions from '@/js/vue/components/timers/TimerFunctions.vue'
import { sortTimers, colorTimers, share, store, convertToTime } from '@/js/vue/composables/TimerFunctions.js'

const props = defineProps({
    outposts: Object,
    events: Object,
})
// By default, all checkboxes are checked 
// Set the array for the v-model to be all true b/c by default, it's empty and null until the user interacts with the checkboxes
//
// Store the reactive array into a global state for the v-ifs for the timers on the nav and map
props.events.forEach((event, index) => {
    if (event.recommended){
        store.setToggleEvent(index, {status: true, name: event.name});
    } else {
        store.setToggleEvent(index, {status: false, name: event.name});
    }
})

const checkCheckbox = (index) => {
    store.toggleEvent[index].status = !store.toggleEvent[index].status;
    console.log(store.toggleEvent);
}

const toggleOutpost = props.outposts;
const toggle = (index) => {
    toggleOutpost[index].status = !toggleOutpost[index].status;
}

const startSpecificTimers = (outpost) => {
    let toggle = false;

    share.timers.forEach((timer) => {
        if (timer.outpost == outpost.name){
            toggle = true;
            timer.start(); 
        }
    })
    if (toggle == true){
        store.togglePlay.forEach((_, index) => {
            if (outpost.name == store.togglePlay[index].outpost){
                store.togglePlay[index].status = !store.togglePlay[index].status;
            }
        })
    }
}

onMounted(() => {
    let timerContainer = document.querySelector('.timer-container');
    let eventContainer = timerContainer.querySelectorAll('.timer'),
        eventNames = timerContainer.querySelectorAll('.event-name'),
        eventTimes = timerContainer.querySelectorAll('.event-time');

    sortTimers(props.events, timerContainer);
    colorTimers(props.events, eventContainer, eventNames, eventTimes);
})



</script>

<style scoped>
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