import { first } from 'lodash';
import { ref, reactive, isRef } from 'vue'
import { clearInterval, clearTimeout, setInterval, setTimeout } from 'worker-timers';

//const worker = new Worker(new URL('./Worker.js', import.meta.url));

// worker.postMessage('start');

// // Add an event listener to receive messages from the web worker
// worker.addEventListener('message', (event) => {
//     if (event.data === 'task_completed') {
//         // Handle the completion of a background task from the web worker
//         // You can update your UI or perform any other necessary actions here
//         console.log('merp');
//     }
// });
// STORE
// Allows state management for toggling the start/stop buttons for both the nav and map timers
// Create an array to set specficially which group of timer rather than all of them
// ex: Timer A on nav and Timer A on map
//
// When the timer page is initalized, for each instance of the timers, in that View, set store.toggle[index]
// Use setToggle as a function to know which should be changed when interacting with the timers
export const store = reactive({
    togglePlay: [],
    toggleInfo: [],
    toggleEvent: [],
    setTogglePlay(index, value){
        this.togglePlay[index] = value;
    },
    setToggleInfo(index, value){
        this.toggleInfo[index] = value;
    },
    setToggleEvent(index, value){
        this.toggleEvent[index] = value;
    }
    

})

export const share = {
    timers: [],
    setTimer(index, value){
        this.timers[index] = value;
    },
    
}

// CONVERT SECONDS TO NICE-LOOKING TIME 00:00
// Allow this to be an exportable function so that it can be used more than just here
// 
// Parameters: cooldown should be ref/reactive. This allows the nav/map timers to be sync in their cooldowns 
export function convertToTime(cooldown){
    let cd; 
    // Check if ref so that convertToTime can be used in different applications of time
    if (isRef(cooldown)){
        cd = cooldown.value;
    } else {
        cd = cooldown;
    }
    let minutes, seconds, formatTime;

    const hours = Math.floor(cd / 3600);
    const remainingSecs = cd % 3600;
    // Check if cooldown goes negative. If yes, make sure to round up than down to avoid adding +1 too early
    minutes = cd < 0 ? Math.ceil(remainingSecs / 60) : Math.floor(remainingSecs / 60);
    seconds =  remainingSecs % 60;

    // Check if cooldown is negative
    // If yes => make the displayed value in absolute values (but the cooldown is still negative to sort)
    // If no => format time normally
    if (cd < 0){
        if (seconds > -10){
            formatTime = `${Math.abs(minutes)}:0${Math.abs(seconds)}`;
        } else {
            formatTime = `${Math.abs(minutes)}:${Math.abs(seconds)}`;
        }
    } else {
        if (seconds < 10){
            formatTime = `${minutes}:0${seconds}`;
        } else {
            formatTime = `${minutes}:${seconds}`;
        }
    }
    return formatTime;
}
// TIMER CLASS
// Class b/c we're creating many many multiples instances of timers. We love a good repeatable and reuseable code
export default class Timer{
    constructor(initialCooldown, respawnCooldown, active, respawnActive, outpost){
        this.initialCooldown = ref(initialCooldown);
        this.respawnCooldown = ref(respawnCooldown);
        this.restartCooldown = this.respawnCooldown.value;
        this.active = ref(active);
        this.respawnActive = ref(respawnActive);
        this.outpost = outpost;
        this.interval = null;
    }

    start(){
        this.interval = setInterval(() => {
            this.initialCooldown.value--;
            this.active.value = true;
            console.log(this.initialCooldown.value);
        }, 1000);
    }

    stop(){
        clearInterval(this.interval);
        this.active.value = false;
        this.respawnActive.value = false;
    }

    restart(){
        this.initialCooldown.value = this.restartCooldown;
        this.respawnActive.value = true;   
    }
}

// SORT TIMERS ON THE NAV BAR
// Every second, check on the nav bar timers and swap their positions if one is less than the other
// Parameters: The parent node of the timers
export const sortTimers = (listOfEvents, parentNode) => {
    // Get events for the sake of indexing
    const events = listOfEvents;
    let parent, currentChild, nextChild,
        secFromCurrent, secFromNext;

    let switching = true,
        shouldSwitch,
        i;

    // Do a while loop to initially sort the timer list
    while (switching){
        switching = false; 

        for (i = 0; i < events.length - 1; i++){
            shouldSwitch = false;

            parent = Array.from(parentNode.children);
            currentChild = parent[i].querySelector('.hidden-timer');
            nextChild = parent[i + 1].querySelector('.hidden-timer'); 
            secFromCurrent = parseInt(currentChild.innerHTML);
            secFromNext = parseInt(nextChild.innerHTML);

            if (secFromCurrent > secFromNext){
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch){
            parentNode.insertBefore(parentNode.children[i + 1], parentNode.children[i]);
            switching = true;
        }
    }
    // After the while loop, every second, check timers to see if they need to be swapped
    setInterval(() => {
        events.forEach((event, index) => {
            // Get an array of each individual timer
            parent = Array.from(parentNode.children);

            // Only trigger if the current index is within events.length range so it doesn't go over
            if (index < events.length - 1){
                currentChild = parent[index].querySelector('.hidden-timer');
                nextChild = parent[index + 1].querySelector('.hidden-timer'); 

                // Each individual timer has a hidden timer with seconds instead of "00:00"
                // Use the seconds to easily measure                
                secFromCurrent = parseInt(currentChild.innerHTML);
                secFromNext = parseInt(nextChild.innerHTML);
                
                // Compare the current and the next timer
                if (secFromCurrent > secFromNext){
                    // Add a class to do a subtle transition effect
                    parent[index].classList.add('swap');
                    parent[index + 1].classList.add('swap');
                    // SWAP
                    parentNode.insertBefore(parentNode.children[index + 1], parentNode.children[index]);
                    // Remove the transition class
                    setTimeout(() => {
                        parent[index].classList.remove('swap');
                        parent[index + 1].classList.remove('swap');
                    }, 100)
                }
            }
        })
    }, 1000);
}

export function colorTimers(events, eventContainer, eventNames, eventTimes){
    let cooldown;

    setInterval(() => {
        events.forEach((event, index) => {     
            cooldown = event.initialCooldown.value;
            // RESPAWN ACTIVITY
            // Only triggers when users have restarted the timer OR (WIP) start a timer that does not have an initial+respawn timer
            if (event.respawnActive.value == true || event.singleCooldown.value == true){
                // Cooldown is past min time and > 0
                if (cooldown <= event.respawnMin && cooldown > 0){
                    eventContainer[index].classList.add('border-event-upcoming');
                    eventNames[index].classList.add('event-upcoming');
                    eventTimes[index].classList.add('event-upcoming');
    
                // Cooldown is most likey active
                } else if (cooldown <= 0 && cooldown > event.respawnMax){
                    eventContainer[index].classList.remove('border-event-upcoming');
                    eventContainer[index].classList.add('border-event-up');

                    eventNames[index].classList.remove('event-upcoming');
                    eventNames[index].classList.add('event-up');
    
                    eventTimes[index].classList.remove('event-upcoming');
                    eventTimes[index].classList.add('event-up');
    
                // Cooldown is beyond it's maximum time
                } else if (cooldown <= event.respawnMax){
                    eventContainer[index].classList.remove('border-event-up');
                    eventContainer[index].classList.add('border-event-overdue');

                    eventNames[index].classList.remove('event-up');
                    eventNames[index].classList.add('event-overdue');
    
                    eventTimes[index].classList.remove('event-up');
                    eventTimes[index].classList.add('event-overdue');
                
                // Cooldown has not hit min time to be active
                } else {
                    eventContainer[index].classList.remove('border-event-up');
                    eventContainer[index].classList.remove('border-event-upcoming');
                    eventContainer[index].classList.remove('border-event-overdue');
                   

                    eventNames[index].classList.remove('event-up');
                    eventNames[index].classList.remove('event-upcoming');
                    eventNames[index].classList.remove('event-overdue');
    
                    eventTimes[index].classList.remove('event-up');
                    eventTimes[index].classList.remove('event-upcoming');
                    eventTimes[index].classList.remove('event-overdue');
                }
            // User did not activate the timer yet
            } else {
                eventContainer[index].classList.remove('border-event-up');
                eventContainer[index].classList.remove('border-event-upcoming');
                eventContainer[index].classList.remove('border-event-overdue');

                eventNames[index].classList.remove('event-up');
                eventNames[index].classList.remove('event-upcoming');
                eventNames[index].classList.remove('event-overdue');

                eventTimes[index].classList.remove('event-up');
                eventTimes[index].classList.remove('event-upcoming');
                eventTimes[index].classList.remove('event-overdue');
            } 

            // INITIAL SPAWN ACTIVITY
            // Only triggers when users have started a timer that has both an initial cooldown and respawn cooldown
            if (event.active.value == true && event.singleCooldown.value == false){
                // Cooldown is past min time and > 0
                if (cooldown <= event.initialMin && cooldown > 0){
                    eventContainer[index].classList.add('border-event-upcoming');
                    eventNames[index].classList.add('event-upcoming');
                    eventTimes[index].classList.add('event-upcoming');
    
                // Cooldown is most likey active
                } else if (cooldown <= 0 && cooldown > event.initialMax){
                    eventContainer[index].classList.remove('border-event-upcoming');
                    eventContainer[index].classList.add('border-event-up');

                    eventNames[index].classList.remove('event-upcoming');
                    eventNames[index].classList.add('event-up');
    
                    eventTimes[index].classList.remove('event-upcoming');
                    eventTimes[index].classList.add('event-up');
    
                // Cooldown is beyond it's maximum time
                } else if (cooldown <= event.initialMax){
                    eventContainer[index].classList.remove('border-event-up');
                    eventContainer[index].classList.add('border-event-overdue');

                    eventNames[index].classList.remove('event-up');
                    eventNames[index].classList.add('event-overdue');
    
                    eventTimes[index].classList.remove('event-up');
                    eventTimes[index].classList.add('event-overdue');
                
                // Cooldown has not hit min time to be active
                } else {
                    eventContainer[index].classList.remove('border-event-up');
                    eventContainer[index].classList.remove('border-event-upcoming');
                    eventContainer[index].classList.remove('border-event-overdue');

                    eventNames[index].classList.remove('event-up');
                    eventNames[index].classList.remove('event-upcoming');
                    eventNames[index].classList.remove('event-overdue');
    
                    eventTimes[index].classList.remove('event-up');
                    eventTimes[index].classList.remove('event-upcoming');
                    eventTimes[index].classList.remove('event-overdue');
                }
            // User did not activate the timer yet
            } else {
                eventContainer[index].classList.remove('border-event-up');
                eventContainer[index].classList.remove('border-event-upcoming');
                eventContainer[index].classList.remove('border-event-overdue');

                eventNames[index].classList.remove('event-up');
                eventNames[index].classList.remove('event-upcoming');
                eventNames[index].classList.remove('event-overdue');

                eventTimes[index].classList.remove('event-up');
                eventTimes[index].classList.remove('event-upcoming');
                eventTimes[index].classList.remove('event-overdue');
            } 
        })
    }, 1000);
    
}

