<!--
    * TIMER FUNCTIONS
    * INCLUDES FUNCTIONS: START/STOP, RESTART, INFO, COUNTDOWN
    * NOTES:
    * This component needs to be seperate from NavTimers because this creates new instances of timers individually
    * If this were to be in NavTimers, startTimer() would start all timers and not a specific one
-->
<template>
    <article>
        <div class="icons">
            <!-- PLAY -->
            <svg 
                width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg"
                v-if="event.togglePlay.value"
                @click="event.togglePlay.value = !event.togglePlay.value; startTimer(index);"    
            >
                <path d="M0 0V13L10 6.5L0 0Z" fill="#FFD12C"/>
            </svg>
            <!-- STOP -->
            <svg 
                width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg"
                v-if="!event.togglePlay.value"
                @click="event.togglePlay.value = !event.togglePlay.value; stopTimer(index);"    
            >
                <path d="M0 10V0H10V10H0Z" fill="#FFD12C"/>
            </svg>
            <!-- RESTART -->
            <svg 
                width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                @click="restartTimer(index); rotateSVG()"
                :style="{transform: `rotate(${rotate}deg)`}"
            >
                <path d="M11.25 15.5C12.7334 15.5 14.1834 15.0601 15.4168 14.236C16.6501 13.4119 17.6114 12.2406 18.1791 10.8701C18.7468 9.49968 18.8953 7.99168 18.6059 6.53683C18.3165 5.08197 17.6022 3.7456 16.5533 2.6967C15.5044 1.64781 14.168 0.933503 12.7132 0.644114C11.2583 0.354725 9.75032 0.50325 8.37987 1.07091C7.00943 1.63856 5.83809 2.59986 5.01398 3.83323C4.18987 5.0666 3.75 6.51664 3.75 8V11.875L1.5 9.625L0.625 10.5L4.375 14.25L8.125 10.5L7.25 9.625L5 11.875V8C5 6.76387 5.36656 5.5555 6.05331 4.52769C6.74007 3.49988 7.71619 2.6988 8.85823 2.22576C10.0003 1.75271 11.2569 1.62894 12.4693 1.8701C13.6817 2.11125 14.7953 2.70651 15.6694 3.58059C16.5435 4.45466 17.1388 5.56831 17.3799 6.78069C17.6211 7.99307 17.4973 9.24974 17.0242 10.3918C16.5512 11.5338 15.7501 12.5099 14.7223 13.1967C13.6945 13.8834 12.4861 14.25 11.25 14.25V15.5Z" fill="#FFD12C"/>
            </svg>
            <!-- INFO -->
            <svg 
                width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"
                v-if="!event.toggleInfo.value"
                @click="event.toggleInfo.value = !event.toggleInfo.value; scrollTo(`timer-${event.name}`)"
            >
                <path d="M8.16675 13.1665H9.83341V8.1665H8.16675V13.1665ZM9.00008 6.49984C9.23619 6.49984 9.43425 6.41984 9.59425 6.25984C9.75425 6.09984 9.83397 5.90206 9.83341 5.6665C9.83341 5.43039 9.75341 5.23234 9.59341 5.07234C9.43341 4.91234 9.23564 4.83261 9.00008 4.83317C8.76397 4.83317 8.56591 4.91317 8.40591 5.07317C8.24591 5.23317 8.16619 5.43095 8.16675 5.6665C8.16675 5.90262 8.24675 6.10067 8.40675 6.26067C8.56675 6.42067 8.76453 6.50039 9.00008 6.49984ZM9.00008 17.3332C7.8473 17.3332 6.76397 17.1143 5.75008 16.6765C4.73619 16.2387 3.85425 15.6451 3.10425 14.8957C2.35425 14.1457 1.76064 13.2637 1.32341 12.2498C0.886193 11.2359 0.667304 10.1526 0.666748 8.99984C0.666748 7.84706 0.885637 6.76373 1.32341 5.74984C1.76119 4.73595 2.3548 3.854 3.10425 3.104C3.85425 2.354 4.73619 1.76039 5.75008 1.32317C6.76397 0.885948 7.8473 0.667059 9.00008 0.666504C10.1529 0.666504 11.2362 0.885393 12.2501 1.32317C13.264 1.76095 14.1459 2.35456 14.8959 3.104C15.6459 3.854 16.2398 4.73595 16.6776 5.74984C17.1154 6.76373 17.334 7.84706 17.3334 8.99984C17.3334 10.1526 17.1145 11.2359 16.6767 12.2498C16.239 13.2637 15.6454 14.1457 14.8959 14.8957C14.1459 15.6457 13.264 16.2396 12.2501 16.6773C11.2362 17.1151 10.1529 17.3337 9.00008 17.3332ZM9.00008 15.6665C10.8612 15.6665 12.4376 15.0207 13.7292 13.729C15.0209 12.4373 15.6667 10.8609 15.6667 8.99984C15.6667 7.13873 15.0209 5.56234 13.7292 4.27067C12.4376 2.979 10.8612 2.33317 9.00008 2.33317C7.13897 2.33317 5.56258 2.979 4.27091 4.27067C2.97925 5.56234 2.33341 7.13873 2.33341 8.99984C2.33341 10.8609 2.97925 12.4373 4.27091 13.729C5.56258 15.0207 7.13897 15.6665 9.00008 15.6665Z" fill="#FFD12C"/>
            </svg>
            <!-- CLOSE INFO -->
            <svg 
                width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"
                v-if="event.toggleInfo.value"    
                @click="event.toggleInfo.value = !event.toggleInfo.value"
            >
                <path d="M14 0C6.2 0 0 6.2 0 14C0 21.8 6.2 28 14 28C21.8 28 28 21.8 28 14C28 6.2 21.8 0 14 0ZM14 26C7.4 26 2 20.6 2 14C2 7.4 7.4 2 14 2C20.6 2 26 7.4 26 14C26 20.6 20.6 26 14 26Z" fill="var(--color-link)"/>
                <path d="M19.4 21L14 15.6L8.6 21L7 19.4L12.4 14L7 8.6L8.6 7L14 12.4L19.4 7L21 8.6L15.6 14L21 19.4L19.4 21Z" fill="var(--color-link)"/>
            </svg>

            <div 
                class="timer-waypoint-container" v-if="event.waypointName"
                @click="copyText(event.waypointLink); toggleTooltip(event.toggleTooltip);"    
            >
                <img src="@/imgs/icons/Waypoint.png" :alt="event.waypointName" :title="`Click to copy '${event.waypointName}'`">
                <Transition name="fade">
                    <div 
                        class="tooltip"
                        v-if="event.toggleTooltip.value"
                    >
                        <p>Copied!</p>
                    </div>
                </Transition>
            </div>

            <div class="checkbox-container">
                <div class="checkbox">
                    <input 
                        type="checkbox" :id="`checkbox-${event.name}-${parentViewId}`" :name="event.name" :checked="event.toggleCheckbox.value"
                        @click="event.toggleCheckbox.value = !event.toggleCheckbox.value"
                    />
                    <label :for="`checkbox-${event.name}-${parentViewId}`"></label>
                </div>
                
            </div>

            
        </div>
        <div class="time">
            <p class="event-time">{{ convertToTime(event.initialCooldown) }}</p>
        </div>
    </article>
</template>

<script setup>
import { ref, onMounted, getCurrentInstance} from 'vue'

import { convertToTime} from '@/js/vue/composables/TimerFunctions.js'
import Timer from '@/js/vue/composables/TimerFunctions.js'
import { share } from '@/js/vue/composables/TimerFunctions.js'

import { scrollTo } from '@/js/vue/composables/NavFunctions.js'

import { toggleTooltip } from '@/js/vue/composables/MouseFunctions'

const props = defineProps({
    event: Object,
    index: Number,
})

const timer = ref([]);
const rotate = ref(0);

const copyText = (text) => {
    if (navigator.clipboard){
        navigator.clipboard.writeText(text)
            .then(() => {
                console.log(`copied ${text}`);
            })
            .catch(err => {
                console.log('Failed to copy text: ', err);
            })
    }
}

// For timers and any duplicated IDs
// Use the parent view ID to differentiate
const parentViewId = ref(getCurrentInstance().parent.uid);

share.timers[props.index] = new Timer(
    props.event.initialCooldown, 
    props.event.respawnCooldown, 
    props.event.active, 
    props.event.respawnActive, 
    props.event.outpost
);

share.setTimer(props.index, new Timer(
    props.event.initialCooldown, 
    props.event.respawnCooldown, 
    props.event.active, 
    props.event.respawnActive,
    props.event.outpost
));

const rotateSVG = () => {
    rotate.value = -360;
}

// For start, stop, check if there is a shared timer
// If yes => share the instance with timer[index] from share.timers[index]
// If no => create a new Timer class
const startTimer = (index) => {
    if (!timer[index]){
        if (!share.timers[index]){
            timer[index] = new Timer(
                props.event.initialCooldown, 
                props.event.respawnCooldown, 
                props.event.active, 
                props.event.respawnActive,
                props.event.outpost
            );
            share.setTimer(index, timer[index]);
        } else {
            timer[index] = share.timers[index];
        }
        timer[index].start();
    } else {
        timer[index].start();
    }
}
const stopTimer = (index) => {
    if (!timer[index]){
        timer[index] = share.timers[index];
        timer[index].stop();
    } else {
        timer[index].stop();
    }
}

const restartTimer = (index) => {
    if (!timer[index]){
        try {
            timer[index] = share.timers[index];
            timer[index].restart();
        } catch (error) {
            console.log('This timer has not started yet and cannot be reset');
        }
    } else {
        timer[index].restart();
    }
}

</script>

<style scoped>
.icons{
    display: flex;
    align-items: center;
    gap: 5px;
}
.icons svg{
    width: 20px;
    height: 20px;
    cursor: pointer;
    transition: var(--transition-all-03s-ease);
}
.icons svg:first-child{
    width: 17px;
    height: 17px;
}
.event-time{
    padding: var(--padding-event-time);
}
.timer-waypoint-container{
    position: relative;
}
.timer-waypoint-container img{
    width: 20px;
    height: 20px;
    vertical-align: middle;
    cursor: pointer;
}
.checkbox{
    padding: 13px 0px 13px 0px;
}

</style>