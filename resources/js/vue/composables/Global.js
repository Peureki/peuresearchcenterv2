// This page is to keep track global variable states
import { ref } from 'vue'
import { getAuthUser } from './Authentication';


export const nodeTrackerModalToggle = ref(false);

// USER AUTH
export const user = ref(null);
export const isAuthenticating = ref(true);

// TYRIAN AND CANTHAN TIME PEROIDS
// Used for the navigation and Fishing benchmarks
export const tyrianCurrentPeriod = ref(null);
export const tyrianTimeTilNext = ref(null); 
export const canthanCurrentPeriod = ref(null);
export const canthanTimeTilNext = ref(null);

export const isMobile = ref(window.innerWidth < 786);


// SETTINGS
// DEFAULTS
// These settings will be these settings every page refresh unless: user is logged in and has saved settings
export const includes = ref([]);
export const buyOrder = ref('buy_price');
export const sellOrder = ref('sell_price');
export const tax = ref(0.85);