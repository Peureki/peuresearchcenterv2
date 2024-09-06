// This page is to keep track global variable states
import { ref } from 'vue'


export const nodeTrackerModalToggle = ref(false);

// TYRIAN AND CANTHAN TIME PEROIDS
// Used for the navigation and Fishing benchmarks
export const tyrianCurrentPeriod = ref(null);
export const tyrianTimeTilNext = ref(null); 
export const canthanCurrentPeriod = ref(null);
export const canthanTimeTilNext = ref(null);

export const isMobile = ref(window.innerWidth < 786);