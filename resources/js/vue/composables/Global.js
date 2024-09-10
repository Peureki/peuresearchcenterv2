// This page is to keep track global variable states
import { ref } from 'vue'


export const nodeTrackerModalToggle = ref(false);

// USER AUTH
export const user = ref(null);

// TYRIAN AND CANTHAN TIME PEROIDS
// Used for the navigation and Fishing benchmarks
export const tyrianCurrentPeriod = ref(null);
export const tyrianTimeTilNext = ref(null); 
export const canthanCurrentPeriod = ref(null);
export const canthanTimeTilNext = ref(null);

export const isMobile = ref(window.innerWidth < 786);


// SETTINGS
// These will be changed if the user is logged in or not
export const includes = ref([]);
export const buyOrderSetting = ref('buy_price');
export const sellOrderSetting = ref('sell_price');
export const tax = ref(0.85);