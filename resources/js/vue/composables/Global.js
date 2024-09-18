// This page is to keep track global variable states
import { ref, watch } from 'vue'
import { getAuthUser } from './Authentication';


export const nodeTrackerModalToggle = ref(false);

// USER AUTH
export const user = ref(null);
export const loginToggle = ref(null);
export const isAuthenticating = ref(true);

// TYRIAN AND CANTHAN TIME PEROIDS
// Used for the navigation and Fishing benchmarks
export const tyrianCurrentPeriod = ref(null);
export const tyrianTimeTilNext = ref(null); 
export const canthanCurrentPeriod = ref(null);
export const canthanTimeTilNext = ref(null);
// CHECK IF SCREEN IS MOBILE
export const isMobile = ref(window.innerWidth < 786);


// SETTINGS
// DEFAULTS
// These settings will be these settings every page refresh unless: user is logged in and has saved settings
export const buyOrder = ref('buy_price');
export const sellOrder = ref('sell_price');
export const tax = ref(0.85);
export const includes = ref([]);
export const filterResearchNotes = ref(["Crafting","TP","Armorsmith","Artificer","Chef","Huntsman","Jeweler","Leatherworker","Scribe","Tailor","Weaponsmith","Consumable","Armor","Weapon","Back","Trinket"]);
// MAKE THIS 'TRUE' IN FUNCTIONS THAT ALTER THE SETTINGS TO TRIGGER A REFRESH OF DATA ON PAGES
export const refreshSettings = ref(false);

// UPDATE settings when user has logged on or off
watch(user, (userData) => {
    console.log('userdata: ', userData)
    if (userData){
        buyOrder.value = userData.settings_buy_order;
        sellOrder.value = userData.settings_sell_order;
        tax.value = userData.settings_tax; 
        includes.value = userData.includes;
        filterResearchNotes.value = userData.filter_research_notes;
    }
})