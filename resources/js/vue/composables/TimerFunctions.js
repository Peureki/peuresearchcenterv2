import { first, last } from 'lodash';
import { ref, reactive, isRef } from 'vue'
import { clearInterval, clearTimeout, setInterval, setTimeout } from 'worker-timers';

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
    metas: [],
    setTimer(index, value){
        this.timers[index] = value;
    },
    setMetas(index, value){
        this.metas[index] = value;
    }
    
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
    let minutes, seconds, formatTime, formatHours, formatMinutes, formatSeconds;

    const hours = Math.floor(cd / 3600);
    const remainingSecs = cd % 3600;
    // Check if cooldown goes negative. If yes, make sure to round up than down to avoid adding +1 too early
    minutes = cd < 0 ? Math.ceil(remainingSecs / 60) : Math.floor(remainingSecs / 60);
    seconds =  remainingSecs % 60;

    // If hours is POSITIVE
    if (hours > 0){
        formatHours = `${hours}:`
        formatMinutes = minutes < 10 ? `0${minutes}:` : `${minutes}:`;
    // If hours is 0 or NEGATIVE
    } else {
        formatHours = ``;
        // If minutes is NEGATIVE
        if (minutes < 0){
            formatMinutes = minutes > -10 ? `0${Math.abs(minutes)}:` : `${Math.abs(minutes)}:`; 
        // If minutes is POSTIVE
        } else {
            formatMinutes = `${minutes}:`;
        }
    }
    // If seconds is NEGATIVE
    if (seconds < 0){
        formatSeconds = seconds > -10 ? `0${Math.abs(seconds)}` : Math.abs(seconds); 
    // If seconds is POSTIVE
    } else {
        formatSeconds = seconds < 10 ? `0${seconds}` : seconds; 
    }

    formatTime = formatHours + formatMinutes + formatSeconds;
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
            const lastEvent = parent[parent.length - 1];
            const lastEventName = lastEvent.querySelector('.event-name').innerHTML;
            // ONLY FOR METAS 
            // Meta (event) object has the status property for which is active and which is not
            // Get the last in the list as that's the one that's active
            if (event.hasOwnProperty('status')){
                if (lastEventName == event.name){
                    event.status.value = true;
                } else {
                    event.status.value = false;
                }
            }

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
            // Only triggers when users have restarted the timer OR start a timer that does not have an initial+respawn timer
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

// META COUNTDOWNS
//
// Each mapView should contain a 'meta' object
// This object contains the event name, cooldown (ref), and the time for when the meta/pre events begin.
// Time should be labeled from 0-2 UTC
// Example
// TD is 0:30 UTC, but it's better to keep it at the higher end (2:30) because math
export function metaCountdown(meta){
    setInterval(() => {
        let utcHour = new Date().getUTCHours(),
            utcMinutes = new Date().getUTCMinutes() * 60,
            utcSeconds = new Date().getUTCSeconds(),
            currentTime;

        let targetHour, targetMinutes, targetTime,
            currentHour, currentMinutes, currentSeconds;

        let cooldown, progress; 

        currentMinutes = utcMinutes;
        currentSeconds = utcSeconds;
        // For each meta or event, check on their name, start time, and return their cooldowns
        meta.forEach((event) => {
            // If meta events repeat every 2 hours
            if (event.repeats == 2){
                targetHour = event.starts[0] * 3600;
                targetMinutes = event.starts[1] * 60;

                // HOUR IS 1
                if (utcHour % 2 == 1){
                    currentHour = 3600;
                }
                // HOUR IS 0
                if (utcHour % 2 == 0){
                    currentHour = 0;
                }

                currentTime = currentHour + currentMinutes + currentSeconds;
                targetTime = targetHour + targetMinutes;
                cooldown = targetTime - currentTime; 

                // Because we're only measuring from 0-1, and events are never over 2hours, reduce cooldown by 2 hours for when the UTC time is 0 and when it's the same time as the meta spawn
                if (cooldown > 7200){
                    cooldown -= 7200; 
                }

                progress = 1 - (cooldown/7200);
                event.progress.value = progress;
            }     
            event.cooldown.value = cooldown;    
            cooldown = convertToTime(cooldown);
            
            
        })

    }, 1000);
}


